<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     

        $users = auth()->user()->business->users;
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

        return view('users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(User $user)
{

    $this->authorize('view', $user);

    $roles = Role::all();
    $permissions = Permission::all();

    return view('users.edit', compact('user', 'roles', 'permissions'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
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
        //
    }
}
