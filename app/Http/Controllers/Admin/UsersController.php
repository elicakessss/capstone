<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('department');

        // Filter by role if specified
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);
        $departments = Department::all();

        // Fetch registration requests for the Requests tab (only pending)
        $requests = UserRequest::with('department')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.users.index', compact('users', 'departments', 'requests'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.users.create', compact('departments'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'id_number' => ['required', 'string', 'max:255', 'unique:users,id_number'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'roles' => ['required', 'array', 'min:1'],
                'roles.*' => ['in:student,adviser,admin'],
                'department_id' => ['required', 'exists:departments,id'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'first_name.required' => 'First name is required.',
                'last_name.required' => 'Last name is required.',
                'id_number.required' => 'ID number is required.',
                'id_number.unique' => 'This ID number is already registered in the system.',
                'email.required' => 'Email address is required.',
                'email.unique' => 'This email address is already registered in the system.',
                'roles.required' => 'At least one role is required.',
                'roles.min' => 'At least one role is required.',
                'roles.*.in' => 'Invalid role selected.',
                'department_id.required' => 'Department is required.',
                'department_id.exists' => 'Selected department is invalid.',
                'password.required' => 'Password is required.',
                'password.confirmed' => 'The password confirmation does not match.',
                'password.min' => 'The password must be at least 8 characters long.',
            ]);

            // Combine first and last name for the name field
            $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

            // Hash the password
            $validated['password'] = Hash::make($validated['password']);

            // Set active status based on checkbox
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            $user = User::create($validated);
            $user->load('department'); // Eager load department for response

            // Always return JSON for this endpoint
            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'user' => $user,
                'show_url' => route('admin.users.show', $user),
                'current_user_id' => auth()->id(),
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the user.',
                'error' => $e->getMessage(), // Show the real error for debugging
                'trace' => $e->getTraceAsString(), // Optional: include stack trace for deeper debugging
            ], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $departments = Department::all();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['in:student,adviser,admin'],
            'role' => ['nullable', 'in:student,adviser,admin'], // keep for backward compatibility
            'department_id' => ['nullable', 'exists:departments,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['boolean'],
        ]);

        // Combine first and last name for the name field
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        // Only hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Set active status
        $validated['is_active'] = $request->has('is_active') ? true : false;

        try {
            $user->update($validated);

            // Save roles as array
            $user->roles = $validated['roles'] ?? [];
            // Optionally, set is_admin and is_adviser flags for convenience
            $user->is_admin = in_array('admin', $user->roles ?? []);
            $user->is_adviser = in_array('adviser', $user->roles ?? []);
            $user->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully!',
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.users.index')
                           ->with('success', 'User updated successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the user.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                        ->with('error', 'An error occurred while updating the user.');
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deleting the currently logged-in user
            if ($user->id === auth()->id()) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot delete your own account.'
                    ], 403);
                }

                return back()->with('error', 'You cannot delete your own account.');
            }

            $user->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully!'
                ]);
            }

            return redirect()->route('admin.users.index')
                           ->with('success', 'User deleted successfully!');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while deleting the user.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'An error occurred while deleting the user.');
        }
    }
}
