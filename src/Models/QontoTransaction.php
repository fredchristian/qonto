<?php

namespace Brocorp\Qonto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class QontoTransaction extends Model
{
    protected $guarded = [];
    protected $dates = ['settled_at', 'emitted_at'];


    public static function boot() 
    {
        parent::boot();
        self::creating(function ($model) { $model->uuid = (string) Str::uuid(); });
    }


    protected function sync($id, $data)
    {
        return self::updateOrCreate(['transaction_id' => $data['transaction_id']],
            [ 
                'qonto_account_id' => $id,
                'amount' => $data['amount'],
                'amount_cents' => $data['amount_cents'],
                'local_amount' => $data['local_amount'],
                'local_amount_cents' => $data['local_amount_cents'],
                'side' => $data['side'],
                'operation_type' => $data['operation_type'],
                'currency' => $data['currency'],
                'local_currency' => $data['local_currency'],
                'label' => $data['label'],
                'settled_at' => $data['settled_at'],
                'emitted_at' => $data['emitted_at'],
                'status' => $data['status'],
                'note' => $data['note'],
                'reference' => $data['reference'],
                'vat_amount' => $data['vat_amount'],
                'vat_amount_cents' => $data['vat_amount_cents'],
                'vat_rate' => $data['vat_rate'],
                'initiator_id' => $data['initiator_id'],
                'attachment_lost' => $data['attachment_lost'],
                'attachment_required' => $data['attachment_required']
            ]);
    }


    public function account() 
    { 
        return $this->belongsTo(QontoAccount::class);
    }


    public function attachments() 
    { 
        return $this->hasMany(QontoAttachment::class); 
    }


    public function setSettledAtAttribute($value)
    {
        $this->attributes['settled_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    

    public function setEmittedAtAttribute($value)
    {
        $this->attributes['emitted_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
