<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\UserFacade;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['status' => 'Verification has already been carried out.']);
        }

        UserFacade::setEmailVerificationCode($request->user()->id);
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'Verification code sent.']);
    }
}
