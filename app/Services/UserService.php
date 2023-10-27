<?php

namespace App\Services;

use App\Models\User;
use App\Traits\AttachmentTrait;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class UserService
{
    use AttachmentTrait;

    /**
     * Set the user's email verification code.
     *
     * @param User $user
     * @return void
     */
    public function setEmailVerificationCode(User $user): void
    {
        $user->email_verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $user->email_verification_expires_at = Carbon::now()->addMinutes(30);
        $user->save();
    }

    /**
     * Check the user's email verification code.
     *
     * @param User $user
     * @param array $requestData
     * @return bool
     */
    public function checkEmailVerification(User $user, array $requestData): bool
    {
        if ($user->email_verification_code != $requestData['email_verification_code']) return false;

        $user->email_verification_code = null;
        $user->email_verification_expires_at = null;
        return $user->save();
    }

    /**
     * Upload and save the user's attached file.
     *
     * @param User $user
     * @param UploadedFile $file
     * @return void
     */
    public function uploadAttachment(User $user, UploadedFile $file): void
    {
        $attachment = $this->uploadFile($file);
        $user->attachment()->delete();
        $user->attachment()->save($attachment);
    }
}
