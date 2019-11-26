<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Requests\RegisterUserRequest;

class RegisterControllerAPI extends Controller
{

    protected function create(RegisterUserRequest $request){
        $user = new User([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'photo' => $request['photo'],
            'nif' => $request['nif']
        ]);
        
        
            
       

        $user->save();
        
    }
    public function changePhoto(Request $request, $id)
    {
            $user = User::findOrFail($id);
            $filename = basename($request->file('file')->store('images/profiles'));
            $user->photo = $filename;
            $user->update($request->all());
            return new UserResource($user);
        } 
}    