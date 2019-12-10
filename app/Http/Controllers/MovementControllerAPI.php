<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\DB;
use App\Movement;
use App\Http\Resources\Movement as MovementResource;

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


    public function getUserMovements($id){
        //$movements = DB::table('movements')->select('*')->where('wallet_id', $id)->orderBy('date', 'desc')->paginate(20);//tirar paginate paginate(20)
        //$wallet = Wallet::findOrFail($id);
        //return $wallet->movements()->orderBy('date', 'desc');
        $movements = Movement::with('category', 'transfer_wallet', 'transfer_wallet.user')->select('*')->where('wallet_id', $id)->orderBy('date', 'desc')->paginate(10);
        return $movements;
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
}

