<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 160)->unique()->comment('dipakai di URL: /universitas/{slug}');
            $table->string('logo_path', 255)->nullable();
            $table->text('description')->nullable();
            $table->char('primary_color', 7)->default('#8E1EA2')->comment('hex, jadi --university-primary');
            $table->char('secondary_color', 7)->default('#C654C3')->comment('hex, jadi --university-secondary');
            $table->string('city', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes()->comment('soft delete');

            $table->index('status');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};