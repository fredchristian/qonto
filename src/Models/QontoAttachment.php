<?php

namespace Brocorp\Qonto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QontoAttachment extends Model
{
    protected $guarded = [];

    public static function boot() 
    {
        parent::boot();
        self::creating(function ($model) { $model->uuid = (string) Str::uuid(); });
    }


    protected function sync($attachment, $id)
    {
        return self::updateOrCreate([ 'attachment_id' => $attachment ], [ 'qonto_transaction_id' => $id ]);
        
    }
    

    public function transaction() 
    { 
        return $this->belongsTo(QontoTransaction::class); 
    }
}
