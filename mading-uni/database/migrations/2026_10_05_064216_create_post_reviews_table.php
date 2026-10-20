<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                ->constrained('posts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('actor_id')
                ->comment('user yang melakukan aksi')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->enum('action', ['submitted', 'approved', 'rejected', 'published', 'archived']);
            $table->text('note')->nullable()->comment('alasan penolakan / catatan revisi');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['post_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_reviews');
    }
};