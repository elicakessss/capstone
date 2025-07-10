<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'bio' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                \Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
        $user->bio = $validated['bio'] ?? $user->bio;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
