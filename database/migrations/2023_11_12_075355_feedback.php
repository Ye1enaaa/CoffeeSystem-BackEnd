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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('companyName');
            $table->string('phoneNum');
            $table->boolean('coffee_bean_ai_sorter')->default(false); // Checkbox for "Coffee Bean AI Sorter Machine"
            $table->boolean('website')->default(false); // Checkbox for "Website"
            $table->string('message');
            $table->string('email')->unique();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};