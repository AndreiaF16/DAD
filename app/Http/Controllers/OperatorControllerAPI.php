<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use App\Movement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Movement as MovementResource;

class OperatorControllerAPI extends Controller
{
    public function registerIncome(Request $request){
        if($request->type_payment == 'bt'){
            $request->validate([
                'value' => 'required|numeric|min:0.01|max:5000',
                'email' => 'required|string|email|max:255',
                'type_payment' => 'required|in:c,mb,bt',
                'iban' => 'nullable|regex:/^[A-Za-z]{2}[0-9]{23}/',
                'source_description' => 'max:255'
            ]);
            }else{
                $request->validate([

                'email' => 'required|string|email|max:255',
                'value' => 'required|numeric|min:0.01|max:5000',
                'type_payment' => 'required|in:c,mb,bt',
                ]);
            }


        $walletsId = DB::table('wallets')->where('email',$request->email)->get();
        if($walletsId == isEmpty()){
            return response('Email is not valid!');
            //return response()->json([
            //    'email' => 'The mail does not exist'
           // ], 422);
        }

        $balance = DB::table('wallets')->select('balance')->where('email', $request->email)->get();

        //Alterar balance da wallet destino
        $wallet = Wallet::findOrFail($walletsId[0]->id);
        $wallet->balance = $balance[0]->balance + $request->value;
        $wallet->save();

         //Date/Time atual
        $date = Carbon::now();

        $movement = new Movement();
        $movement->fill($request->all());
        $movement->wallet_id = $walletsId[0]->id;
        $movement->type = "i";
        $movement->start_balance = $balance[0]->balance;
        $movement->end_balance = $balance[0]->balance + $request->value;
        $movement->transfer=0;
        $movement->date = $date->toDateTimeString();

      /*  $movement->end_balance = $wallets->balance + $request->value;
        $movement->wallet_id = $wallets->id;
        $movement->date = date('Y-m-d H:i:s');
        $movement->value = $request->value;
        $movement->type_payment = $request->type_payment;
        $movement->source_description = $request->source_description;
        if($movement->type_payment == "bt"){
            $movement->iban = $request->iban;
        }*/
        $movement->save();

        /*$wallets->balance = $movement->end_balance;
        $wallets->save();*/

       // return response()->json(new MovementResource($movement), 201);

       return new MovementResource($movement);

    }
}
