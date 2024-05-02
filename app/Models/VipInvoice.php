<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipInvoice extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(VipCustomer::class);
    }

    public function sales(){
        return $this->hasMany(VipInvoice::class);
    }
    public function location(){
        return $this->belongsTo(Location::class);
    }
}
