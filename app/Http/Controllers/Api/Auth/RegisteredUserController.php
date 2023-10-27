<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserService             $userService
    ) {}

    /**
     * Handle an incoming registration request.
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function store(RegisterRequest $request): UserResource
    {
        $user = $this->userRepository->create($request->validated());
        $this->userService->setEmailVerificationCode($user);
        event(new Registered($user));
        Auth::login($user);
        return new UserResource($user);
    }
}
