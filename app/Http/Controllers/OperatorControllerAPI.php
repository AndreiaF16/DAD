<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Movement;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Movement as MovementResource;

class OperatorControllerAPI extends Controller
{
    public function registerIncome(Request $request){
        $validated = $request->validate([
            'value' => 'required|numeric|min:0.01|max:5000',
            'email' => 'required|string|email|max:255',
            'type_payment' => 'required|in:c,mb,bt',
            'iban' => 'nullable|regex:/^[A-Za-z]{2}[0-9]{23}/',
            'source_description' => 'max:255'
        ]);
        
        $wallets = DB::table('wallets')->where('email',$request->email)->first();
        if($wallets == null){
            return response()->json([
                'email' => 'The mail does not exist'
            ], 422);
        }
        $movement = new Movement();
        $movement->start_balance = $wallets->balance;
        $movement->end_balance = $wallets->balance + $request->value;
        $movement->wallet_id = $wallets->id;
        $movement->type = "i";
        $movement->date = date('Y-m-d H:i:s');
        $movement->transfer=0;
        $movement->value = $request->value;
        $movement->type_payment = $request->type_payment;
        $movement->source_description = $request->source_description;
        if($movement->type_payment == "bt"){
            $movement->iban = $request->iban;
        }
        $movement->save();

        /*$wallets->balance = $movement->end_balance;
        $wallets->save();*/

        return response()->json(new MovementResource($movement), 201);
    }
}
