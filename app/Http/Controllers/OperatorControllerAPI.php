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
            $validated = $request->validate([
                'value' => 'required|numeric|min:0.01|max:5000',
                'email' => 'required|string|email|max:255',
                'type_payment' => 'required|in:c,mb,bt',
                'iban' => 'nullable|regex:/^[A-Za-z]{2}[0-9]{23}/',
                'source_description' => 'max:255'
            ]);
        }else{
            $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'value' => 'required|numeric|min:0.01|max:5000',
            'type_payment' => 'required|in:c,mb,bt',
            ]);
        }

        //Alterar balance da wallet destino
        $wallet = Wallet::where('email',$request->email)->first();
        if($wallet == null){
            return response('Email is not valid!');
        }
        $wallet->balance = $wallet->balance + $request->value;
        $wallet->save();

         //Date/Time atual
        $date = Carbon::now();

        $movement = new Movement();
        $movement->fill($validated);
        $movement->wallet_id = $wallet->id;
        $movement->type = "i";
        $movement->start_balance = $wallet->balance;
        $movement->end_balance = $wallet->balance + $request->value;
        $movement->transfer=0;
        $movement->date = $date->toDateTimeString();
        if($movement->type_payment == "bt"){
            $movement->iban = $request->iban;
            $movement->source_description = $request->source_description;
        }

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
