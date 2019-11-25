<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;

class UserControllerAPI extends Controller
{
    public function getAuthUser(){
        return new UserResource(Auth::user());
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'string|email|max:255|unique:users,email,'.$request->id,
            'password' => 'min:3','password',
            'nif' => 'max:9',

        ]);
        $user = Auth::user();

        $user->fill($validated);
        $user->save();

        return response()->json(new UserResource($user), 201);
    }


    public function myProfile(Request $request)
    {
        return new UserResource($request->user());

    }

}
