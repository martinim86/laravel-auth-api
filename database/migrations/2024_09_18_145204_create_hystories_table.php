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
        Schema::create('hystories', function (Blueprint $table) {
            $table->id('uuid');
            $table->uuid('model_id')->unique();
            $table->string('model_name', 250);
            $table->json('before');
            $table->json('after');
            $table->enum('action', ['Y', 'N']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hystories');
    }
};
