<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipSale extends Model
{
    use HasFactory;
    public function invoice(){
        return $this->belongsTo(VipInvoice::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function customer(){
        return $this->belongsTo(VipCustomer::class);
    }
    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
