<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\DB;
use App\Movement;
use App\Http\Resources\Movement as MovementResource;
use App\Http\Controllers\Requests\DebitMovementRequest;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        return MovementResource::collection($movements);
    }


    public function getUserMovements($id){

        $movements = Auth::user()->wallet->movement->with('category', 'transfer_wallet', 'transfer_wallet.user')->orderBy('date', 'desc')->paginate(10);
        return $movements;
    }

    public function store(Request $request)
    {

    }


    public function getFilteredMovements(Request $request){

        if(!is_null($request->id) || !is_null($request->type) || !is_null($request->category) || !is_null($request->type_payment) || !is_null($request->transfer_email) || !is_null($request->data_inf) || !is_null($request->data_sup)){

            $movements = Movement::with('category', 'transfer_wallet', 'transfer_wallet.user')->select('*')->where('wallet_id', $request->user_id);

            if (!is_null($request->id)){
                $movements = $movements->where('id', 'like', $request->id . '%');
            }
            if (!is_null($request->type)){
                $movements = $movements->where('type', $request->type);
            }
            if (!is_null($request->category)){
                $category = DB::table('categories')->select('id')->where('name', $request->category)->get();
                if($category->isEmpty()){
                    return 'Category does not exist!';
                }
                $movements = $movements->where('category_id', $category[0]->id);
            }
            if (!is_null($request->type_payment)){
                $movements = $movements->where('type_payment', $request->type_payment);
            }
            if (!is_null($request->transfer_email)){
                $transfer_email = DB::table('wallets')->select('id')->where('email', $request->transfer_email)->get();
                if($transfer_email->isEmpty()){
                    return 'Transfer e-mail does not exist!';
                }
                $movements = $movements->where('transfer_wallet_id', $transfer_email[0]->id);
            }
            if (!is_null($request->data_sup)){
                $movements = $movements->where('date', '>=', $request->data_sup);
            }
            if (!is_null($request->data_inf)){
                $movements = $movements->where('date', '<=', $request->data_inf);
            }

            $movements = $movements->orderBy('date', 'desc')->paginate(10);

        }else{
            $movements = Movement::with('category', 'transfer_wallet', 'transfer_wallet.user')->select('*')->where('wallet_id', $request->user_id)->orderBy('date', 'desc')->paginate(10);
        }

        return $movements;
    }

    public function update(Request $request, $id){
        $movement = Movement::findOrFail($id);

        $category_name = $request->category['name'];
        $category =  DB::table('categories')->select('id')->where('name', $category_name)->where('type', $movement->type)->get();
        if($category->isEmpty()){
            return 'Category does not exist for this type of movement';
        }

        $movement->category_id = $category[0]->id;
        $movement->description = $request->description;

        $movement->save();
        return new MovementResource($movement);
    }

    public function createDebit(DebitMovementRequest $request) {
        $movement = new Movement();
        $movement->fill($request->except(['destination_email',"email"]));

        if($request->email == $request->destination_email){
            return response('Email and Destination Email are the same!');
        }

        $wallet = Wallet::where('email',$request->email)->first();
        if($wallet == null){
            return response('Email is not valid!');
        }
        $wallet->balance = $wallet->balance - $request->value;
        $wallet->save();

        $date = Carbon::now();
        $movement->wallet_id = $wallet->id;
        $movement->type = "e";
        $movement->start_balance = $wallet->balance + $request->value;
        $movement->end_balance = $wallet->balance;
        $movement->date = $date->toDateTimeString();
        $movement->save();

        if($request->transfer == 1){
            
            $wallet_dest = Wallet::where('email',$request->destination_email)->first();
            if($wallet_dest == null){
                return response('Destination Email is invalid!');
            }

            $wallet_dest->balance = $wallet_dest->balance + $request->value;
            $wallet_dest->save();

            $date = Carbon::now();

            $movement_dest = new Movement();
            $movement_dest->fill($request->except(['destination_email',"email"]));
            $movement_dest->wallet_id = $wallet_dest->id;
            $movement_dest->type = "i";
            $movement_dest->start_balance = $wallet_dest->balance;
            $movement_dest->end_balance = $wallet_dest->balance + $request->value;
            $movement_dest->date = $date->toDateTimeString();
            $movement_dest->transfer_movement_id = $movement->id;
            $movement_dest->transfer_wallet_id = $wallet->id;
            $movement_dest->iban = $request->iban;
            $movement_dest->source_description = $request->source_description;
            
            $movement_dest->save();

            $movement->transfer_movement_id = $movement_dest->id;
            $movement->transfer_wallet_id = $wallet_dest->id;
                    
            $movement->save();
        }
    }
}

