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
            $table->enum('gender', ['Male', 'Female']);
            $table->string('marital_status', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number', 20)->unique()->nullable();
            $table->string('emergency', 20)->nullable();
            $table->string('bank', 50)->nullable();
            $table->date('hire_date');
            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('photo')->nullable();

            // --- Kolom Jadwal & Cuti ---
            $table->time('schedule_start_time')->default('08:00:00'); // Jam masuk
            $table->time('schedule_end_time')->default('16:00:00');   // Jam pulang

            // 0: Full-time, 1: Contract, 2: Intern
            $table->unsignedTinyInteger('contract_type')->default(0);
            $table->unsignedTinyInteger('annual_leave_days')->nullable(); 

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
