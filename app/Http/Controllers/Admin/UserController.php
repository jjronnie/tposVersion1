<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Business;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager-load roles and permissions if shown in the view
        $users = User::with(['roles', 'permissions', 'business'])->get();

        // Aggregate counts
        $stats = [
            'total' => User::count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
            'active' => User::where('status', 'active')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'disabled' => User::where('status', 'disabled')->count(),
            'email_signups' => User::where('signup_method', 'email')->count(),
            'google_signups' => User::where('signup_method', 'google')->count(),
        ];

        return view('superadmin.users.index', compact('users', 'stats'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show(User $user)
    {
        // Load relationships
        $user->load([
            'business',
            'creator',
            'roles',
            'permissions'
        ]);

        // Get all sessions if available
        if (method_exists($user, 'sessions')) {
            $user->allSessions = $user->sessions()->get()->map(function ($session) {
                return [
                    'agent' => [
                        'platform' => $session->platform ?? 'Unknown',
                        'browser' => $session->browser ?? 'Unknown',
                    ],
                    'ip_address' => $session->ip_address,
                    'last_active' => $session->last_activity,
                ];
            })->toArray();
        } else {
            $user->allSessions = [];
        }

        return view('superadmin.users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified user.
     */


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $businesses = Business::all();
        $creators = User::all();
        $roles = Role::all();

        return view('superadmin.users.edit', compact('user', 'businesses', 'creators', 'roles'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'created_by' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,suspended,disabled',
            'password' => 'nullable|min:8',
            'profile_photo_path' => 'nullable|image|max:2048',
            'role' => 'required|exists:roles,name',
            'verified' => 'required|boolean',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo_path')) {
            $validated['profile_photo_path'] = $request->file('profile_photo_path')->store('profile_photos', 'public');
        }

        // Handle password update
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Handle email verification
        $validated['email_verified_at'] = $request->verified ? now() : null;

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
