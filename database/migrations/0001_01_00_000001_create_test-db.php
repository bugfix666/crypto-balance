<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $exists = DB::connection()->selectOne("SELECT 1 FROM pg_database WHERE datname = ?", ['database-test']);

        if (!$exists) {
            DB::connection()->statement('CREATE DATABASE "database-test"');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
