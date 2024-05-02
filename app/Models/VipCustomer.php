<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipCustomer extends Model
{
    use HasFactory;
    public function invoices(){
        return $this->hasMany(VipInvoice::class);
    }
}
