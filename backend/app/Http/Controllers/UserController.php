<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ResponseMessage;
use Auth;

class UserController extends Controller
{
    use ResponseMessage;

    public function store (Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        $user = User::create($attributes);

        return response()->json($this->getSuccessMessage([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $atttributes = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);

        $user->update($atttributes);

        return response()->json($this->getSuccessMessage([
            'name' => $user->name,
            'email' => $user->email
        ]));
    }
}
