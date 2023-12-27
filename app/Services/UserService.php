<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\CRUDRepositoryInterface;

class UserService
{
    public function __construct(private readonly CRUDRepositoryInterface $repository)
    {
    }

    public function getById(int $id): Model|Builder
    {
        return $this->repository->getById($id);
    }

    public function create(array $requestData): Model|Builder
    {
        return $this->repository->create($requestData);
    }

    public function update(int $id, array $requestData): bool
    {
        return $this->repository->update($id, $requestData);
    }

    /**
     * Set the user's email verification code.
     *
     * @param int $id
     * @return bool
     */
    public function setEmailVerificationCode(int $id): bool
    {
        return $this->repository->update($id, [
            'email_verification_code' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'email_verification_expires_at' => Carbon::now()->addMinutes(30)
        ]);
    }

    /**
     * Check the user's email verification code.
     *
     * @param int $id
     * @param array $requestData
     * @return bool
     */
    public function checkEmailVerification(int $id, array $requestData): bool
    {
        $user = $this->repository->getById($id);
        if ($user->email_verification_code != $requestData['email_verification_code']) return false;

        return $this->repository->update($id, [
            'email_verification_code' => null,
            'email_verification_expires_at' => null
        ]);
    }

    /**
     * Upload and save the user's attached file.
     *
     * @param int $id
     * @param Attachment $attachment
     * @return Attachment
     */
    public function assignAttachment(int $id, Attachment $attachment): Attachment
    {
        $user = $this->repository->getById($id);
        $user->attachment()->delete();
        return $user->attachment()->save($attachment);
    }
}
