<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SubscriptionLimitService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;


use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $limitService;

    public function __construct(SubscriptionLimitService $limitService)
    {
        $this->limitService = $limitService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $users = User::forBusiness()->paginate(50);

       
        $totalUsers = $users->count();
        return view('users.index', compact('users', 'totalUsers', ));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
          $business = auth()->user()->business;
        $userLimit = $this->limitService->canAddUser($business);

        return view('users.create', compact('roles', 'permissions', 'userLimit'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {

         $business = auth()->user()->business;
        
        // Double-check limit (middleware already checked, but good practice)
        $limitCheck = $this->limitService->canAddUser($business);
        if (!$limitCheck['allowed']) {
            return redirect()->back()
                ->with('error', $limitCheck['message']);
        }
        
        // 1. Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|string|in:active,disabled,suspended',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        
        // 2. Create the user
        $user = User::create([
            'business_id' => auth()->user()->business_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $validated['status'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Assign the role
        $user->assignRole($validated['role']);

        // 4. Assign the permissions
        // syncPermissions method will remove any existing permissions and assign only the selected ones
        if ($request->has('permissions')) {
            $user->syncPermissions($validated['permissions']);
        }
        
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
         $this->authorizeBusiness($user);

         return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(User $user)
{
 $this->authorizeBusiness($user);

    $roles = Role::all();
    $permissions = Permission::all();

    return view('users.edit', compact('user', 'roles', 'permissions'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{

    $this->authorizeBusiness($user);


    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'phone' => 'nullable|string|max:20',
        'status' => 'required|string|in:active,disabled,suspended',
        'password' => ['nullable', 'confirmed', Password::min(8)],
        'role' => 'required|exists:roles,name',
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,name',
    ]);
    
    // Update the user's details
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'status' => $validated['status'],
        'password' => $request->filled('password') ? Hash::make($validated['password']) : $user->password,
    ]);

    // Update the user's role
    $user->syncRoles([$validated['role']]);

    // Update the user's permissions
    $user->syncPermissions($validated['permissions'] ?? []);
    
    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */


public function destroy(User $user)
{
    // Prevent a user from deleting their own account.
    if ($user->id === Auth::id()) {
        return redirect()->back()->with('error', 'You cannot delete your own account.');
    }

    // Protect the super admin role.
    if ($user->hasRole('superadmin')) {
        return redirect()->back()->with('error', 'Cannot delete a super admin.');
    }

    $this->authorizeBusiness($user);
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}

       private function authorizeBusiness(User $user)
    {
        if ($user->business_id !== auth()->user()->business_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
