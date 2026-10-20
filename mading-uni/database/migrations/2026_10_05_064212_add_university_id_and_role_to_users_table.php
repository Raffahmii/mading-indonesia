<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('university_id')
                ->nullable()
                ->after('id')
                ->comment('NULL untuk super_admin & member; WAJIB terisi untuk university_admin')
                ->constrained('universities')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->enum('role', ['super_admin', 'university_admin', 'member'])
                ->default('member')
                ->after('password');

            $table->enum('status', ['active', 'suspended'])
                ->default('active')
                ->after('role');

            $table->string('avatar_path', 255)->nullable()->after('status');
            $table->softDeletes()->comment('soft delete');

            $table->index(['role', 'status']);
            $table->index('university_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['university_id']);
            $table->dropSoftDeletes();
            $table->dropColumn(['university_id', 'role', 'status', 'avatar_path']);
        });
    }
};