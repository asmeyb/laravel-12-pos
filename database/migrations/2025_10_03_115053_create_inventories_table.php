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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            // Correct way to handle nullable foreign keys with set null
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
