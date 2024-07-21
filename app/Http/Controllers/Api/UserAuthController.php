<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

class UserAuthController extends Controller
{

    public function register(RegisterUserRequest $request)
    {

        $data = $request->validated();
        $data['user_ip'] = $request->ip();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        return $this->successResponse($user, 'User created.', 201);
    }

    public function login(LoginUserRequest $request)
    {
        $request->authenticate();
        $user = auth()->user();
        if ($user) {
            $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
            $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

            $data = [
                'access_token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken ? $refreshToken->plainTextToken : null
            ];
            return $this->successResponse($data, 'Logged in successfully.', 200);
        }
    }



}
