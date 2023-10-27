<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VerifyEmailController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): Response|JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->noContent();
        }

        if (!$this->userService->checkEmailVerification($request->user(), $request->validated())) {
            return response()->json([
                'message' => 'Invalid verification code, please try again.',
                'errors' => ['email_verification_code' => 'Invalid verification code, please try again.']
            ]);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->noContent();
    }
}
