<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\DB;
use App\Movement;
use App\Http\Resources\Movement as MovementResource;
use Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class MovementControllerAPI extends Controller
{

    public function index(Request $request)
    {
       if ($request->has('page')) {
            return MovementResource::collection(Movement::paginate(5));
       } else {
            return MovementResource::collection(Movement::all());
        }
    }
    public function list()
    {
        $user = Auth::user();

        return MovementResource::collection(
            Movement::where('wallet_id', Auth::id())
            ->orderBy('date', 'desc')->get()
                //->paginate(15)
        );
    }

    public function show($id)
    {
        $movements = Auth::user()->wallet->movement;
        //return $movements;
        //$movements = Movement::where("wallet_id",$id)->get();
        //return $movements;
        return MovementResource::collection($movements);
    }


    public function store(Request $request)
    {
      /*   $request->validate([
                'email' => 'required|email|unique:users,email',
                ''

            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);*/
    }

    /* public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email,'.$id,
                //'type' => 'enum('u','o','a')'
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    } */
}

