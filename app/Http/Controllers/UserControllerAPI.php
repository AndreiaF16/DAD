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
            'nif' => 'min:9|max:9',

        ]);
        $user = Auth::user();

        $user->fill($validated);

      /*  if((Auth::guard('api')->user()->id != $user->id) && (Auth::guard('api')->user())){
            return Response::json([
                'unauthorized' => 'Access forbiden!'
            ], 401);
        }*/


        $user->save();

        return response()->json(new UserResource($user), 201);
    }

    public function changePassword(Request $request){

       $validated = $request->validate([
            'old_password'=>'required',
            'password'=>'required|confirmed|min:3|different:old_password',
            'password_confirmation'=>'required|same:password',
        ]);
        $user = Auth::user();

        $user->fill($validated);

        if (!(Hash::check($request->input('old_password'), $user->password))) {
            return Response::json([
                'old_password' => 'Please enter the correct current password'
            ], 422);
        }


        $user->password=Hash::make($request->input('password'));

        $user->save();

        return new UserResource($user);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());

    }

}
