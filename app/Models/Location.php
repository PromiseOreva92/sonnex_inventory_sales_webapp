<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    public function users(){
        return $this->hasMany(User::class);
    }
    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function stocklogs(){
        return $this->hasMany(StockLog::class);
    }

    
}
