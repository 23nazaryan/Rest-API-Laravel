<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\UserFacade;
use Illuminate\Http\Response;
use App\Facades\AttachmentFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param ProfileUpdateRequest $request
     * @return Response
     */
    public function update(ProfileUpdateRequest $request): Response
    {
        $userId = $request->user()->id;
        UserFacade::update($userId, $request->validated());

        if ($request->file('attachment')) {
            $attachment = AttachmentFacade::uploadFile($request->file('attachment'));
            UserFacade::assignAttachment($userId, $attachment);
        }

        return response()->noContent();
    }
}
