<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->year('year')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->string('pdf_file')->nullable();
            $table->integer('pages')->nullable();
            $table->integer('stock')->default(1);
            $table->integer('total_stock')->default(1);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
