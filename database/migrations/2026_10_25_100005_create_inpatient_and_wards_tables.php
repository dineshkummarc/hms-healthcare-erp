<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('type')->default('general'); // general, private, icu, hdu, maternity, pediatric, post_op
            $table->string('floor')->nullable();
            $table->integer('capacity')->default(10);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->string('room_number');
            $table->string('type')->default('standard'); // standard, deluxe, vip, isolation
            $table->decimal('daily_rate', 10, 2)->default(0.00);
            $table->string('status')->default('available'); // available, occupied, maintenance, cleaning
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('bed_number');
            $table->string('type')->default('standard'); // standard, electric, icu, pediatric
            $table->decimal('daily_rate', 10, 2)->default(0.00);
            $table->string('status')->default('available'); // available, occupied, reserved, maintenance, cleaning
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'bed_number']);
        });

        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('attending_doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained()->cascadeOnDelete();
            $table->string('admission_number')->unique();
            $table->timestamp('admitted_at')->useCurrent();
            $table->text('reason_for_admission');
            $table->string('status')->default('admitted'); // admitted, discharged, transferred
            $table->timestamp('discharged_at')->nullable();
            $table->text('discharge_summary')->nullable();
            $table->string('discharge_type')->nullable(); // recovered, referred, against_medical_advice, deceased
            $table->decimal('total_charges', 12, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nursing_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nurse_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('recorded_at')->useCurrent();
            $table->json('vital_signs')->nullable();
            $table->text('observations');
            $table->text('care_plan')->nullable();
            $table->text('medications_administered')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nursing_notes');
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('beds');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('wards');
    }
};
