<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard');
    }

    /**
     * Send a new email verification notification.
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
