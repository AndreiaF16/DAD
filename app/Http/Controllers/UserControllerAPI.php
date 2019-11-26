<?php

namespace App\Http\Controllers;
use Hash;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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


      /*  if($request->photo != null) {
            $image = $request->file('photo');
            $path = basename($image->store('profiles', 'public'));
            $user->photo = basename($path);
        }*/

        $user->save();

        return response()->json(new UserResource($user), 201);
    }

    public function changePassword(Request $request){

       $validated = $request->validate([
            'password_old'=>'required',
            'password'=>'required|confirmed|min:3|different:password_old',
            'password_confirmation'=>'required|same:password',
        ]);
        $user = Auth::user();

      //  $user->fill($validated);

        if (!(Hash::check($request->input('password_old'), $user->password))) {
            return response()->json([
                'password_old' => 'Please enter the correct current password'
            ], 422);
        }


        $user->password=Hash::make($request->input('password'));

        $user->save();

        return new UserResource($user);
    }
}
