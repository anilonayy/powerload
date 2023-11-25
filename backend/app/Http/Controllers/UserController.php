<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store (Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        $user = User::create($attributes);

        return apiResponse('Message',200,[
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ])->toSuccess();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

        $user->name = $atttributes['name'];
        $user->email = $atttributes['email'];

        $user->save();


        return apiResponse('Profiliniz başarıyla güncellendi!',200,[
            'name' => $user->name,
            'email' => $user->email
        ])->toSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
