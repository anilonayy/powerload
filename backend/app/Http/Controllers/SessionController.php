<?php

namespace App\Http\Controllers;

use App\Http\Requests\Session\LoginRequest;
use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(! Auth::attempt($attributes)) {
            return apiResponse(400,'Hata!',__('auth.failed'))->toFail();
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return apiResponse(200,'Başarılı','Başarıyla giriş yaptınız.',[
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $token = Auth::user()->currentAccessToken();

        if($token) {
            Auth::user()->tokens()->where('id', $token->id)->delete();
        }

        return apiResponse(200,'Başarılı','Güvenli bir şekilde çıkış yaptınız.')->toSuccess();
    }
}
