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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'min:3','password',
            'nif' => 'max:9',

        ]  );
        $user = User::findOrFail($id);


        $user->name = $request->name;
        $user->update($request->all());
        $user->save();

    return new UserResource($user);
    }


    public function myProfile(Request $request)
    {
        return new UserResource($request->user());

    }

}
