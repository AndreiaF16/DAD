<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Wallet;

class WalletControllerAPI extends Controller
{

    public function index(){
        $wallets = DB::table('wallets')->count();
        return $wallets;
    }

    public function movementsWithCategoriesandUsers() {
        $myWallets = Movement::join('movements', 'wallets.id', '=', 'movements.wallet_id')
        ->join('categories', 'categories.id', '=', 'movements.category_id')->where('id', '=', 'movements.category_id')
        ->get(['movements.*']);
        return Movement::collection($myWallets);

    }

    public function showVirtualWallet($id /* $request*/)
	{
        $user=Wallet::findOrFail($id);

        if((Auth::guard('api')->user()->id != $user->id) || (Auth::guard('api')->user()->type != 'cook')){
            return Response::json([
                'unauthorized' => 'Access forbiden!'
            ], 401);
        }
		/*if(Auth::guard('api')->user()->type != 'u'){
			return Response::json([
				'unauthorized' => 'Access forbiden! Only Plataform Users are allowed'
			], 401);
        }*/
    }
}
