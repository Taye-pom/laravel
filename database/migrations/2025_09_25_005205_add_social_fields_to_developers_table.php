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
        Schema::table('developers', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('bio');
            $table->string('github_url')->nullable()->after('avatar');
            $table->string('linkedin_url')->nullable()->after('github_url');
            $table->string('portfolio_url')->nullable()->after('linkedin_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'github_url', 'linkedin_url', 'portfolio_url']);
        });
    }
};
