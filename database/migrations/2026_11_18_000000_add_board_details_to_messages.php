<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('display_name', 60)->nullable();
            $table->string('ornament', 16)->nullable();
            $table->decimal('x', 5, 2)->nullable();
            $table->decimal('y', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'ornament', 'x', 'y']);
        });
    }
};
