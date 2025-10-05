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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nik', 50)->unique()->nullable();
            $table->string('full_name');
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth');
            $table->string('gender', 20);
            $table->string('marital_status', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number', 20)->unique()->nullable();
            $table->date('hire_date');
            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('photo')->nullable();
            $table->string('status', 50)->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
