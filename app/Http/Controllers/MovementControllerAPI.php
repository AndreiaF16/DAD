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
        //$movements = Auth::user()->wallet->movement;
        //return $movements;
        //$movements = Movement::where("wallet_id",$id)->get();
        //return $movements;
        $user = Auth::user();
        /*$movements = DB::table('wallets')
            ->join('movements', 'wallets.id', '=', 'movements.wallet_id')
            ->join('categories', 'categories.id', '=', 'movements.category_id')
            ->where("wallets.id","=",$user->id)
            ->select("wallets.email","movements.id","movements.type","movements.type_payment","movements.id"
                    ,"categories.name","movements.date","movements.description","movements.source_description"
                    ,"movements.iban","movements.mb_entity_code","movements.start_balance","movements.end_balance"
                    ,"movements.value")
            ->orderBy("movements.date","desc")
            ->paginate(15);*/
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

