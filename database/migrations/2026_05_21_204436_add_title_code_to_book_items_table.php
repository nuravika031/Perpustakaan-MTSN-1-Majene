<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('book_items', 'title_code')) {
            Schema::table('book_items', function (Blueprint $table) {
                $table->string('title_code')->after('author_code');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('book_items', 'title_code')) {
            Schema::table('book_items', function (Blueprint $table) {
                $table->dropColumn('title_code');
            });
        }
    }
};