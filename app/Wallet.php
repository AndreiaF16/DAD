<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model{
    //
    protected $fillable = [
        'id',
        'email',
        'balance',
        'created_at',
        'updated_at'
    ];

  /*  public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }*/

}


