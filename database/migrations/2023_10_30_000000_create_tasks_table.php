<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->date('deadline');
            $table->integer('total_slots')->default(1);
            $table->integer('completed_slots')->default(0);
            $table->string('form_link')->nullable();
            $table->string('drive_link')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
