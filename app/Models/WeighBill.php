<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeighBill extends Model
{
    use HasFactory;
    use HasFactory;
    public function location() {
       return $this->belongsTo(Location::class); 
    }
    public function product() {
        return $this->belongsTo(Product::class); 
     }
}
