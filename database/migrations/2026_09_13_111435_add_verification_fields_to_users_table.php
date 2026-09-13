<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])
                ->default('unverified')->after('role');
            $table->string('id_document_path')->nullable()->after('verification_status');
            $table->string('ownership_document_path')->nullable()->after('id_document_path');
            $table->text('verification_notes')->nullable()->after('ownership_document_path');
            $table->timestamp('verified_at')->nullable()->after('verification_notes');
            $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'verification_status', 'id_document_path', 'ownership_document_path',
                'verification_notes', 'verified_at', 'verified_by',
            ]);
        });
    }
};