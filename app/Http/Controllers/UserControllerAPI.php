<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\Requests\RegisterUserRequest;
use App\Http\Controllers\Requests\RegisterUserAdminOpRequest;

class UserControllerAPI extends Controller
{
    public function getAuthUser(){
        return new UserResource(Auth::user());
    }

    public function getUser($email){
        $user = User::where("email","=",$email)->first();
        return new UserResource($user);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'string|email|max:255|unique:users,email,'.$request->id,
            'password' => 'min:3','password',
            'photo' => 'nullable|image|max:2048',
            'nif' => 'min:9|max:9',
            'file' => 'nullable|image|max:2048',
        ]);
        $user = Auth::user();

        $user->fill($request->except(['file']));

        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            $fileName = $user->id . '_' . $request->file('file')->hashName();
            $request->file('file')->storeAs('public/fotos', $fileName);
            $user->fill(['photo' => $fileName,]);
        }

        $user->save();

        return response()->json(new UserResource($user), 201);
    }

    public function changePassword(Request $request){

       $validated = $request->validate([
            'password_old'=>'required|min:3',
            'password'=>'required|confirmed|min:3|different:password_old',
            'password_confirmation'=>'required|same:password',
       ], [
            'password_old.required' => 'Is necessary insert the old password',
            'password.required' => 'Is necessary insert the new password',
            'password_confirmation.required' => 'Is necessary confirm the new password',
            'password_old.min' => 'The old password needs at least 3 characters',
            'password.min' => 'The new password needs at least 3 characters',
            'password_confirmation.min' => 'Password confirmation must be at least 3 characters',
            'password_confirmation.same' => 'Verification password must match password'
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
    public function store(RegisterUserAdminOpRequest $request) {
        $user = new User([
            'name' => $request['name'],
            'type' => $request ['type'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $fileName = $user->id . '_' . $request->file('photo')->hashName();
            $request->file('photo')->storeAs('public/fotos', $fileName);
            $user->fill(['photo' => $fileName,]);
        }
        $user->save();
        return new UserResource($user);
    }

    public function deactivateUser($id){
        $user = User::findOrFail($id);
        $balance = DB::table('wallets')->select('balance')->where('id', $id)->get();
        if($balance[0]->balance == 0){
            $user->active = 0;
            $user->save();
        }else{
            return "Wallet balance must be 0.00 to deactivate a user!";
        }
        return new UserResource($user);
    }

    public function activateUser($id){
        $user = User::findOrFail($id);
        $user->active = 1;
        $user->save();
        return new UserResource($user);
    }

    public function getFilteredUsers(Request $request){

        if(!is_null($request->name) || !is_null($request->type) || !is_null($request->email) || !is_null($request->active)){

            $users = User::with('wallet')->select('*');

            if(!is_null($request->name)){
                $users = $users->where('name', 'like', $request->name . '%');
            }
            if(!is_null($request->type)){
                $users = $users->where('type', $request->type);
            }
            if(!is_null($request->email)){
                $users = $users->where('email', 'like', $request->email . '%');
            }
            if(!is_null($request->active)){
                if($request->type == null || $request->type == 'u'){
                    $users = $users->where('active', $request->active);
                }else{
                    return "Can't search by status and type at the sime time, because the type of user is different from 'Platform User'!";
                }
            }

            $users = $users->paginate(10);

        }else{
            $users = User::with('wallet')->select('*')->paginate(10);
        }
        return $users;
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function getPhotoByEmail($email){
        $photo = User::where('email', '=', $email)->pluck('photo');
        return $photo;
    }
}
