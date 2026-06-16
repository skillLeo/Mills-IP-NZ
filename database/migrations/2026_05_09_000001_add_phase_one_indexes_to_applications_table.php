<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->index('status');
            $table->index('submitted_at');
            $table->index('contact_email');
            $table->index('legal_owner_name');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['submitted_at']);
            $table->dropIndex(['contact_email']);
            $table->dropIndex(['legal_owner_name']);
        });
    }
};
