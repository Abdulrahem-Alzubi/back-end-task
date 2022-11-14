<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changPassword(ChangPasswordRequest $request) {
        $user = Auth::user();
        if (Hash::check($request->password, $user->getAuthPassword())) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            $user->tokens()->delete();
            return successResponse($user);
        } else {
            return errorResponse('wrong password', 403);
        }

    }
}
