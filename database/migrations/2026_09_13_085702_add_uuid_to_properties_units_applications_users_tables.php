<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['properties', 'units', 'applications', 'users'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->uuid('uuid')->nullable()->unique()->after('id');
            });
        }

        // Backfill UUIDs for any rows that already exist (your test data)
        foreach ($tables as $table) {
            DB::table($table)->whereNull('uuid')->orderBy('id')->get()->each(function ($row) use ($table) {
                DB::table($table)->where('id', $row->id)->update(['uuid' => (string) Str::uuid()]);
            });
        }

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->uuid('uuid')->nullable(false)->change();
            });
        }
    }

    public function down(): void
    {
        foreach (['properties', 'units', 'applications', 'users'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('uuid');
            });
        }
    }
};