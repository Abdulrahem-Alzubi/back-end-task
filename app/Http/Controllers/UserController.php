<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function profile() {
        $user = Auth::user();
        return successResponse($user);
    }

    public function store(StoreUserRequest $request) {
        $user = User::query()->create([
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'phone_number' => $request->phone_number,
           'email' => $request->email,
           'password' => Hash::make('12345678'),
           'role_id' => 2
        ]);
        return successResponse($user->load('role'));
    }

    public function update(User $user, UpdateUserRequest $request) {
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
        return successResponse($user);
    }

    public function delete(User $user) {
        $user->delete();
        return successMessage('deleted successfully');

    }

    public function showHisProduct() {
        $user = Auth::user();
        return successResponse($user->products);
    }
}
