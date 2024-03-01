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
        Schema::create('logs_table_properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('table_id');
            $table->string('instance_id', 45)->index();
            $table->string('property', 145)->index();
            $table->text('previous_value')->nullable();
            $table->text('current_value');
            $table->string('log_by', 145)->index();
            $table->dateTime('log_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreign('table_id')->references('id')->on('logs_tables')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_table_attributes');
    }
};
