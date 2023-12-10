<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->unique();
            $table->string("cpf")->unique();
            $table->date("date_birth");
            $table->string("password");
            $table->timestamps();
        });
        Schema::create('address',function(Blueprint $table){

            $table->id();
            $table->string("cep");
            $table->integer("numero_endereco");
            $table->string("complemento")->nullable();
            $table->string("logradouro")->nullable();
            $table->string("bairro")->nullable();
            $table->string("localidade");
            $table->string("uf");
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('address');
    }
};
