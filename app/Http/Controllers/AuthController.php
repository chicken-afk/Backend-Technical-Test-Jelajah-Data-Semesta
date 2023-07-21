<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $userRole = $user->role;

            if ($userRole) {
                $this->scope = $userRole->role_name;
            }

            $token = $user->createToken($user->email . '-' . now(), [$this->scope]);

            $success['token'] = $token->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
