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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('path');                             // Полный путь, например /root/finance/reports
            $table->integer('order_index')->default(0);   // Порядок отображения
            $table->tinyInteger('status')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->integer('retention_period')->nullable();    // Срок хранения в днях
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // Кто создал
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // Кто обновил
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); //Кто создал
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
