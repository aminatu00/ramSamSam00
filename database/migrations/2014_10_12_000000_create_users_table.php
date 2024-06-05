<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('niveau')->nullable();
            $table->enum('user_type', ['admin', 'student' , 'mentor','technoPedaguogue', 'allumni'])->default('student');
            $table->json('interests')->nullable();
            $table->json('expertise')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'), // N'oubliez pas de hasher le mot de passe
            'user_type' => 'admin',
           
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
