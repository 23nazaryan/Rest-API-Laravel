<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\UserFacade;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): Response|JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->noContent();
        }

        if (!UserFacade::checkEmailVerification($user->id, $request->validated())) {
            return response()->json([
                'message' => 'Invalid verification code, please try again.',
                'errors' => ['email_verification_code' => 'Invalid verification code, please try again.']
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->noContent();
    }
}
