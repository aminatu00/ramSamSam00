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
        Schema::create('mentorats', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); // Ajoutez autant de colonnes que nécessaire pour votre application
            $table->date('date');
            $table->time('time');
            $table->string('meeting_link');
            $table->unsignedBigInteger('mentor_id');
            $table->foreign('mentor_id')->references('id')->on('users');
            $table->string('domaine');
            $table->foreignId('sondage_id')->nullable()->constrained('sondages')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentorats');
    }
};
