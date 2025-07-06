<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserRequestController extends Controller
{
    /**
     * Show the registration request form.
     */
    public function create()
    {
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    /**
     * Store a new registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user_requests', 'unique:users'],
            'id_number' => ['required', 'string', 'max:255', 'unique:user_requests', 'unique:users'],
            'department_id' => ['required', 'exists:departments,id'],
            'role' => ['required', 'in:student,adviser,admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        UserRequest::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'id_number' => $request->id_number,
            'department_id' => $request->department_id,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        return redirect()->route('registration.pending')->with('success', 'Your registration request has been submitted successfully. Please wait for admin approval.');
    }

    /**
     * Show pending registration message.
     */
    public function pending()
    {
        return view('auth.registration-pending');
    }

    /**
     * Show admin dashboard for managing user requests.
     */
    public function index(Request $request)
    {
        $query = UserRequest::with(['department', 'reviewer']);

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.user-requests.index', compact('requests'));
    }

    /**
     * Show a specific user request for admin review.
     */
    public function show(UserRequest $userRequest)
    {
        $userRequest->load(['department', 'reviewer']);
        return view('admin.user-requests.show', compact('userRequest'));
    }

    /**
     * Approve a user request and create the user account.
     */
    public function approve(Request $request, UserRequest $userRequest)
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if (!$userRequest->isPending()) {
            return back()->with('error', 'This request has already been processed.');
        }

        // Create the user account
        $user = User::create([
            'first_name' => $userRequest->first_name,
            'last_name' => $userRequest->last_name,
            'email' => $userRequest->email,
            'id_number' => $userRequest->id_number,
            'department_id' => $userRequest->department_id,
            'role' => $userRequest->role, // Ensure role is copied
            'password' => $userRequest->password, // Already hashed
        ]);

        // Update the request status
        $userRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'User request approved and account created successfully.');
    }

    /**
     * Reject a user request.
     */
    public function reject(Request $request, UserRequest $userRequest)
    {
        $request->validate([
            'admin_notes' => ['required', 'string', 'max:1000'],
        ]);

        if (!$userRequest->isPending()) {
            return back()->with('error', 'This request has already been processed.');
        }

        $userRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'User request rejected successfully.');
    }
}
