<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('vehicle_number')->unique();
            $table->string('model');
            $table->string('type')->default('basic_life_support'); // basic_life_support, advanced_life_support, patient_transport
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('status')->default('available'); // available, dispatched, maintenance
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ambulance_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ambulance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->string('trip_number')->unique();
            $table->string('pickup_address');
            $table->string('drop_address');
            $table->decimal('fare', 10, 2)->default(0.00);
            $table->string('status')->default('dispatched'); // dispatched, arrived, completed, cancelled
            $table->timestamp('dispatched_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('telemedicine_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('room_id')->unique();
            $table->string('access_token')->nullable();
            $table->string('status')->default('waiting'); // waiting, in_call, ended, cancelled
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lead_surgeon_id')->constrained('doctors')->cascadeOnDelete();
            $table->string('case_number')->unique();
            $table->string('procedure_name');
            $table->string('ot_room')->default('OT-1');
            $table->timestamp('scheduled_at');
            $table->string('status')->default('scheduled'); // scheduled, in_progress, completed, cancelled
            $table->text('preoperative_notes')->nullable();
            $table->text('postoperative_notes')->nullable();
            $table->text('anesthesia_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dental_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->integer('tooth_number'); // Universal Numbering System 1-32
            $table->string('procedure_name');
            $table->text('findings');
            $table->text('treatment_plan')->nullable();
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->string('status')->default('planned'); // planned, in_progress, completed
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('physiotherapy_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('therapist_id')->constrained('users')->cascadeOnDelete();
            $table->date('session_date');
            $table->text('diagnosis');
            $table->text('treatment_protocol');
            $table->text('progress_notes')->nullable();
            $table->integer('pain_score_before')->nullable(); // 1-10
            $table->integer('pain_score_after')->nullable(); // 1-10
            $table->string('status')->default('completed'); // scheduled, completed, cancelled
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physiotherapy_sessions');
        Schema::dropIfExists('dental_records');
        Schema::dropIfExists('surgeries');
        Schema::dropIfExists('telemedicine_sessions');
        Schema::dropIfExists('ambulance_trips');
        Schema::dropIfExists('ambulances');
    }
};
