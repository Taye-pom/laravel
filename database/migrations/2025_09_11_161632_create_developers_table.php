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
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
             $table->string('title')->nullable();
            $table->enum('experience_level', ['Junior', 'Mid-Level', 'Senior', 'Lead'])->default('Junior');
            $table->string('skills')->nullable();
             $table->text('bio')->nullable();
            $table->integer('rating',3,1)->default(0.0);
             $table->integer('active_tasks')->default(0);
            $table->integer('completed_projects')->default(0);
            $table->integer('hours_logged')->default(0);
            $table->timestamps();

             $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('developers');
    }
};
