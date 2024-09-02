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
        Schema::create('pull_requests', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('api_number');
            $table->string('state');
            $table->string('title');
            $table->datetime('api_created_at');
            $table->datetime('api_updated_at');
            $table->datetime('api_closed_at')->nullable();
            $table->datetime('api_merged_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pull_requests');
    }
};
