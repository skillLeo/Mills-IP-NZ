<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->text('trademark_description');
            $table->string('logo_file_path')->nullable();
            $table->text('business_description')->nullable();
            $table->string('legal_owner_name')->nullable();
            $table->enum('legal_owner_type', ['individual', 'company'])->nullable();
            $table->string('abn')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', [
                'Received', 'Reviewing', 'Quoted', 'Filed',
                'Completed', 'On Hold', 'Rejected',
            ])->default('Received');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
