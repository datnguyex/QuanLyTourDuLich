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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); 
            $table->Integer('tour_id'); 
            $table->Integer('customer_id'); 
            $table->date('booking_date');
            $table->Integer('number_of_people'); 
            $table->float('total_price'); 
            $table->Integer('user_id'); 
            $table->Integer('tour_guide_id');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
