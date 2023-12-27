<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\UserFacade;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function store(RegisterRequest $request): UserResource
    {
        $user = UserFacade::create($request->validated());
        UserFacade::setEmailVerificationCode($user->id);
        event(new Registered($user));
        Auth::login($user);
        return new UserResource($user);
    }
}
