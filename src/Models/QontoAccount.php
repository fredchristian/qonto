<?php

namespace Brocorp\Qonto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QontoAccount extends Model
{
    protected $guarded = [];

    public static function boot() 
    {
        parent::boot();
        self::creating(function ($model) { $model->uuid = (string) Str::uuid(); });
    }

    protected function sync($data) 
    {
        return self::updateOrCreate(['slug'=> $data['slug']], 
            [ 
                'iban' => $data['iban'], 
                'bic' => $data['bic'], 
                'currency' => $data['currency'], 
                'balance' => $data['balance'], 
                'balance_cents' => $data['balance_cents'], 
                'authorized_balance' => $data['authorized_balance'],
                'authorized_balance_cents' => $data['authorized_balance_cents']
            ]);
    }
    
    public function transactions() 
    { 
        return $this->hasMany(QontoTransaction::class); 
    }
}
