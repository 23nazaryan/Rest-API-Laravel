<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileUpdateRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserService             $userService
    ) {}

    /**
     * Update the user's profile information.
     *
     * @param ProfileUpdateRequest $request
     * @return void
     */
    public function update(ProfileUpdateRequest $request): void
    {
        $this->userRepository->update($request->user(), $request->validated());

        if ($request->file('attachment')) {
            $this->userService->uploadAttachment($request->user(), $request->file('attachment'));
        }
    }
}
