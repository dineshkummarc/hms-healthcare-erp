<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('category')->default('haematology'); // haematology, biochemistry, microbiology, serology, histopathology
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('sample_type')->default('blood'); // blood, urine, stool, swab, sputum
            $table->string('normal_range')->nullable();
            $table->string('unit')->nullable();
            $table->integer('turnaround_hours')->default(24);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lab_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->string('priority')->default('routine'); // routine, urgent, stat
            $table->string('status')->default('ordered'); // ordered, sample_collected, in_progress, completed, cancelled
            $table->text('clinical_notes')->nullable();
            $table->timestamp('sample_collected_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lab_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('result_value')->nullable();
            $table->string('reference_range')->nullable();
            $table->string('flag')->default('normal'); // normal, high, low, critical
            $table->text('technician_notes')->nullable();
            $table->string('status')->default('pending'); // pending, completed
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('radiology_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('modality')->default('x_ray'); // x_ray, ultrasound, ct_scan, mri, ecg, endoscopy
            $table->decimal('price', 10, 2)->default(0.00);
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('radiology_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->constrained('radiology_services')->cascadeOnDelete();
            $table->foreignId('radiologist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('order_number')->unique();
            $table->string('modality');
            $table->text('clinical_indication')->nullable();
            $table->longText('findings')->nullable();
            $table->text('impression')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, in_progress, reported, approved, cancelled
            $table->timestamp('performed_at')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_orders');
        Schema::dropIfExists('radiology_services');
        Schema::dropIfExists('lab_order_items');
        Schema::dropIfExists('lab_orders');
        Schema::dropIfExists('lab_tests');
    }
};
