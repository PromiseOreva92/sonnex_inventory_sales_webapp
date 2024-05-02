<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
