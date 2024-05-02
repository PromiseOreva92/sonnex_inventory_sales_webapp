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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_by')->constrained('users');
            $table->foreignId('customer_id')->constrained('customers');
            $table->decimal('amount'); 
            $table->string('payment_type'); 
            $table->decimal('balance'); 
            $table->string('comment');
            $table->decimal('profit'); 
            $table->integer('status'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
