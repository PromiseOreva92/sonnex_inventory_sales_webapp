<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_by')->constrained('users');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('stock_id')->constrained('stocks');
            $table->foreignId('invoice_id')->constrained('invoices');
            $table->integer('quantity');
            $table->decimal('amount'); 
            $table->decimal('profit'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
