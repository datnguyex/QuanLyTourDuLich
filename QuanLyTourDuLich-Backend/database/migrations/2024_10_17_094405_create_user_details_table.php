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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id(); 
            $table->Integer('user_id')->notNull();
            $table->string('phone', 20)->notNull(); 
            $table->string('address', 100)->notNull(); 
            $table->string('profile_picture', 100)->notNull(); 
            $table->date('dob')->notNull(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
