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
}