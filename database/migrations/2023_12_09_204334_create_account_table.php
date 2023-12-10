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
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string("user_cpf");
            $table->double("balance",8,2);
            $table->timestamps();
            $table->foreign('user_cpf')->references('cpf')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
