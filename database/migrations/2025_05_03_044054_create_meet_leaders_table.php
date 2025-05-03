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
        Schema::create('meet_leaders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meet_leaders');
    }
};
