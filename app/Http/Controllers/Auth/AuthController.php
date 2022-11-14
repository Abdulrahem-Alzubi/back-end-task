<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'role_id' => 1
        ];
        if ($request->has('email')) {
            $userData['email'] = $request->email;
        }
        if ($request->has('phone_number')) {
            $userData['phone_number'] = $request->phone_number;
        }
        $user = User::query()->create($userData);
        $token = $user->createToken('user');
        $data['user']=$user;
        $data['type']='Bearer';
        $data['token']=$token->plainTextToken;
       return successResponse($data);
    }

    public function login(LoginRequest $request){
        $identify = null;
        if ($request->has('email')) {
            $identify = 'email';
        }
        elseif ($request->has('phone_number')) {
            $identify = 'phone_number';
        }
        $credentials = request([$identify, 'password']);
        if (!Auth::attempt($credentials)){
            throw new AuthenticationException();
        }

        $user = $request->user();
        $token=$user->createToken('user');

        $data['user']=$user;
        $data['type']='Bearer';
        $data['token']=$token->plainTextToken;

       return successResponse($data);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return successMessage('logout success');
    }
}
