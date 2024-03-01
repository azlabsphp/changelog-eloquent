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
        Schema::create('logs_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 145)->index()->comment('Nom de la table impactée par les changements, de préférence utiliser une comibinaison non de base de données + nom table');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_table');
    }
};
