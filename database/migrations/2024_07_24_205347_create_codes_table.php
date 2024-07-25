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
        Schema::create('codes', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade'); // foreign key for table users
            $table->string('title',255); // varchar(255)
            $table->text('content'); // text
            $table->string('language', 50); // varchar(50)
            $table->timestamps(); // includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
