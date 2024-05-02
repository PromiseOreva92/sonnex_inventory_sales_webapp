<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
