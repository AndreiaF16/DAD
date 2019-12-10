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
            
            'nif' => $request['nif']
        ]);
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $fileName = $user->id . '_' . $request->file('photo')->hashName();
            $request->file('photo')->storeAs('public/fotos', $fileName);
            $user->fill(['photo' => $fileName,]);
        }
        
            
       

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