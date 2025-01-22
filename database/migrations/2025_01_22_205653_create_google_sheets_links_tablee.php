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
        Schema::create('google_sheet_links', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID como clave primaria
            $table->uuid('user_id'); // Relación con usuarios
            $table->string('url_sheet'); // Enlace de Google Sheets
            $table->timestamps(); // created_at y updated_at

            // Relación foránea con usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_sheet_links');
    }
};
