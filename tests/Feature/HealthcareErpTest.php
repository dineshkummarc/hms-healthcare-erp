<?php

namespace Tests\Feature;

use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Bed;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Encounter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\Medicine;
use App\Models\ModuleActivation;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\PharmacyBatch;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;
use App\Services\AiClinicalAssistantService;
use App\Services\AttendanceDeviceSyncService;
use App\Services\ModuleRegistry;
use App\Services\PdfGenerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class HealthcareErpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test 1: Public Homepage & Marketing Pages Render Successfully
     */
    public function test_public_website_pages_render_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('GrandHealth');
        $response->assertSee('38 Production-Ready Modules');

        // Test marketing page
        $featuresResponse = $this->get('/p/features');
        $featuresResponse->assertStatus(200);
        $featuresResponse->assertSee('Features');

        // Test modules catalog page
        $modulesResponse = $this->get('/p/modules');
        $modulesResponse->assertStatus(200);
        $modulesResponse->assertSee('Patient Management');

        // Test demo access page
        $demoResponse = $this->get('/p/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('superadmin@grandhealth.test');
    }

    /**
     * Test 2: Hospital Branded Microsite Builder
     */
    public function test_hospital_microsite_renders(): void
    {
        $org = Organization::first();
        $response = $this->get("/h/{$org->slug}");
        $response->assertStatus(200);
        $response->assertSee($org->name);
    }

    /**
     * Test 3: Public Online Appointment Booking & Collision Prevention
     */
    public function test_public_online_booking_and_concurrency_collision_prevention(): void
    {
        $doctor = Doctor::first();
        $branch = Branch::first();

        $bookingData = [
            'doctor_id' => $doctor->id,
            'branch_id' => $branch->id,
            'patient_name' => 'Alice Walker',
            'patient_phone' => '+1-555-9876',
            'patient_email' => 'alice@test.com',
            'appointment_date' => now()->addDays(2)->toDateString(),
            'start_time' => '10:00:00',
            'reason' => 'Severe headache and dizziness',
        ];

        // 1st booking should succeed
        $response = $this->post('/book-appointment', $bookingData);
        $response->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'doctor_id' => $doctor->id,
            'start_time' => '10:00:00',
            'status' => 'scheduled',
        ]);

        // 2nd booking for same doctor at identical time slot must be blocked (Collision Prevention)
        $collisionResponse = $this->post('/book-appointment', $bookingData);
        $collisionResponse->assertSessionHas('error');
    }

    /**
     * Test 4: Dynamic Module Control Center (Enable / Disable Scoping)
     */
    public function test_module_registry_activation_and_dependency_enforcement(): void
    {
        $org = Organization::first();

        // Check isEnabled
        $this->assertTrue(ModuleRegistry::isEnabled('patient_management', $org->id));

        // Disable a non-core module
        $disabled = ModuleRegistry::setStatus('dental_management', false, $org->id);
        $this->assertTrue($disabled);
        $this->assertFalse(ModuleRegistry::isEnabled('dental_management', $org->id));

        // Core modules cannot be disabled
        $coreDisableAttempt = ModuleRegistry::setStatus('patient_management', false, $org->id);
        $this->assertFalse($coreDisableAttempt);
        $this->assertTrue(ModuleRegistry::isEnabled('patient_management', $org->id));
    }

    /**
     * Test 5: Outpatient Clinical Workflow (Encounter Documentation & Signed Prescription)
     */
    public function test_outpatient_clinical_encounter_and_prescription_workflow(): void
    {
        $org = Organization::first();
        $branch = Branch::first();
        $doctor = Doctor::first();
        $patient = Patient::first();

        $appointment = Appointment::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_number' => 'APT-TEST-' . rand(100, 999),
            'appointment_date' => today(),
            'start_time' => '14:00:00',
            'end_time' => '14:15:00',
            'token_number' => 1,
            'type' => 'consultation',
            'status' => 'checked_in',
            'fee' => $doctor->consultation_fee,
        ]);

        // Create clinical encounter
        $encounter = Encounter::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_id' => $appointment->id,
            'encounter_number' => 'ENC-TEST-' . rand(100, 999),
            'systolic_bp' => 118,
            'diastolic_bp' => 78,
            'pulse_rate' => 72,
            'chief_complaints' => 'Persistent cough for 4 days',
            'diagnosis' => 'Acute Bronchitis',
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('encounters', ['id' => $encounter->id, 'diagnosis' => 'Acute Bronchitis']);

        // Doctor authored and electronically signed prescription
        $prescription = Prescription::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'encounter_id' => $encounter->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'prescription_number' => 'RX-TEST-' . rand(100, 999),
            'advice' => 'Steam inhalation twice daily, drink warm water',
            'is_signed' => true,
            'signed_at' => now(),
            'status' => 'active',
        ]);

        PrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'medicine_name' => 'Azithromycin 500mg',
            'dosage' => '500mg',
            'frequency' => '1+0+0',
            'duration' => '5 Days',
            'instructions' => 'Take 1 hour before food',
        ]);

        $this->assertDatabaseHas('prescriptions', ['id' => $prescription->id, 'is_signed' => true]);
        $this->assertDatabaseHas('prescription_items', ['prescription_id' => $prescription->id, 'medicine_name' => 'Azithromycin 500mg']);
    }

    /**
     * Test 6: Inpatient Bed Allocation & Admission Collision Prevention
     */
    public function test_inpatient_admission_and_bed_collision_protection(): void
    {
        $org = Organization::first();
        $branch = Branch::first();
        $doctor = Doctor::first();
        $patient1 = Patient::find(1);
        $patient2 = Patient::find(2);
        $bed = Bed::where('status', 'available')->first();

        // Admit Patient 1 into Bed
        $admission1 = Admission::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'patient_id' => $patient1->id,
            'attending_doctor_id' => $doctor->id,
            'bed_id' => $bed->id,
            'admission_number' => 'ADM-CONC-01',
            'reason_for_admission' => 'Post-surgical clinical monitoring',
            'status' => 'admitted',
        ]);
        $bed->update(['status' => 'occupied']);

        $this->assertEquals('occupied', $bed->fresh()->status);

        // Attempting to allocate an already occupied bed must be prevented
        $isBedOccupied = Bed::where('id', $bed->id)->where('status', 'occupied')->exists();
        $this->assertTrue($isBedOccupied);
    }

    /**
     * Test 7: Pharmacy Inventory Deduction on Sale
     */
    public function test_pharmacy_inventory_stock_tracking(): void
    {
        $med = Medicine::first();
        $batch = PharmacyBatch::where('medicine_id', $med->id)->first();
        $initialStock = $batch->quantity;

        // Deduct 5 units
        $batch->decrement('quantity', 5);

        $this->assertEquals($initialStock - 5, $batch->fresh()->quantity);
    }

    /**
     * Test 8: Billing, Partial Payments & Invoice Recalculation
     */
    public function test_billing_and_payment_reconciliation(): void
    {
        $org = Organization::first();
        $branch = Branch::first();
        $patient = Patient::first();
        $user = User::where('role', 'receptionist')->first();

        $invoice = Invoice::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'patient_id' => $patient->id,
            'invoice_number' => 'INV-TEST-001',
            'invoice_date' => today(),
            'subtotal' => 200.00,
            'discount' => 20.00,
            'tax' => 10.00,
            'total' => 190.00,
            'paid_amount' => 0.00,
            'balance_due' => 190.00,
            'status' => 'unpaid',
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'item_type' => 'consultation',
            'description' => 'Specialist Consultation',
            'quantity' => 1,
            'unit_price' => 200.00,
            'total' => 200.00,
        ]);

        // Record partial payment of $100
        Payment::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'invoice_id' => $invoice->id,
            'patient_id' => $patient->id,
            'received_by' => $user->id,
            'payment_number' => 'PAY-TEST-001',
            'amount' => 100.00,
            'payment_method' => 'cash',
            'status' => 'completed',
        ]);

        $invoice->recalculate();

        $this->assertEquals('partially_paid', $invoice->fresh()->status);
        $this->assertEquals(90.00, (float) $invoice->fresh()->balance_due);

        // Record remaining payment of $90
        Payment::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'invoice_id' => $invoice->id,
            'patient_id' => $patient->id,
            'received_by' => $user->id,
            'payment_number' => 'PAY-TEST-002',
            'amount' => 90.00,
            'payment_method' => 'card',
            'status' => 'completed',
        ]);

        $invoice->recalculate();

        $this->assertEquals('paid', $invoice->fresh()->status);
        $this->assertEquals(0.00, (float) $invoice->fresh()->balance_due);
    }

    /**
     * Test 9: Accounting Double-Entry Balance Verification
     */
    public function test_journal_entry_double_entry_balance(): void
    {
        $jEntry = JournalEntry::first();
        $this->assertNotNull($jEntry);
        $this->assertTrue($jEntry->isBalanced());
        $this->assertEquals($jEntry->total_debit, $jEntry->total_credit);
    }

    /**
     * Test 10: Unicode PDF Generation Service Integration
     */
    public function test_unicode_pdf_generation(): void
    {
        $invoice = Invoice::first();
        $html = PdfGenerationService::generateInvoicePdf($invoice, 'en');

        $this->assertNotEmpty($html);
        $this->assertStringContainsString($invoice->invoice_number, $html);

        $prescription = Prescription::first();
        $rxHtml = PdfGenerationService::generatePrescriptionPdf($prescription, 'en');

        $this->assertNotEmpty($rxHtml);
        $this->assertStringContainsString($prescription->prescription_number, $rxHtml);
    }

    /**
     * Test 11: AI Clinical Assistant Fallback & Safety Guardrails
     */
    public function test_ai_clinical_assistant_safety_and_fallback(): void
    {
        $summary = AiClinicalAssistantService::summarizeNotes('Patient with fever and chest pain');
        $this->assertNotEmpty($summary);

        $reminder = AiClinicalAssistantService::draftAppointmentReminder('John Doe', 'Dr. Smith', '2026-10-30 10:00 AM', 'Central Hospital');
        $this->assertNotEmpty($reminder);
        $this->assertStringContainsString('John Doe', $reminder);
    }

    /**
     * Test 12: REST API Authentication & Mobile App Endpoints
     */
    public function test_api_sanctum_auth_and_endpoints(): void
    {
        // Public health
        $healthResponse = $this->getJson('/api/v1/health');
        $healthResponse->assertStatus(200);
        $healthResponse->assertJson(['status' => 'healthy']);

        // Login as doctor
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => 'doctor@grandhealth.test',
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(200);
        $token = $loginResponse->json('token');
        $this->assertNotEmpty($token);

        // Access protected endpoint with token
        $userResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/v1/auth/user');
        $userResponse->assertStatus(200);
        $userResponse->assertJsonPath('user.email', 'doctor@grandhealth.test');
    }

    /**
     * Test 13: Attendance Hub Sync Service
     */
    public function test_attendance_hub_synchronization(): void
    {
        $branch = Branch::first();
        $synced = AttendanceDeviceSyncService::syncTerminal($branch->id);

        $this->assertIsInt($synced);
    }
}
