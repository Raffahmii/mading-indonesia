<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->comment('scope utama: semua query admin difilter kolom ini')
                ->constrained('universities')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('author_id')
                ->comment('user yang membuat (university_admin / super_admin)')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->comment('super_admin yang mereview terakhir')
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('title', 255);
            $table->string('slug', 280);
            $table->string('excerpt', 500)->nullable();
            $table->longText('body');
            $table->string('cover_image_path', 255)->nullable();
            $table->dateTime('event_start')->nullable()->comment('opsional, untuk event/lomba/seminar');
            $table->dateTime('event_end')->nullable();
            $table->string('location', 200)->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'published', 'archived'])
                ->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes()->comment('soft delete');

            // slug unik per universitas
            $table->unique(['university_id', 'slug'], 'posts_university_slug_unique');
            $table->index(['university_id', 'status']);
            $table->index(['status', 'published_at']);
            $table->index('category_id');
            $table->index('author_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};