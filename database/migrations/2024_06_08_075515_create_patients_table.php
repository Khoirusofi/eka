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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('no_registrasi')->unique();
            $table->string('nik')->unique();
            $table->string('phone')->unique();
            $table->string('address');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
