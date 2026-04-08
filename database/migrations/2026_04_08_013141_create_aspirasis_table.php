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
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->string('lokasi')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('status',['Draft','Pending','Rejected','InProgress','Completed'])->default('Draft');
            $table->timestamps();
            $table->foreignId('deleted_by')->constrained('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};