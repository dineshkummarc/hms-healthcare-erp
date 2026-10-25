<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\AttendanceRecord;
use App\Models\AuditEvent;
use App\Models\Bed;
use App\Models\Branch;
use App\Models\DentalRecord;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\EmrRecord;
use App\Models\Encounter;
use App\Models\Hospital;
use App\Models\InsuranceProvider;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\LabTest;
use App\Models\Medicine;
use App\Models\ModuleActivation;
use App\Models\NursingNote;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\PharmacyBatch;
use App\Models\PhysiotherapySession;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RadiologyOrder;
use App\Models\RadiologyService;
use App\Models\Room;
use App\Models\StaffProfile;
use App\Models\SubscriptionPlan;
use App\Models\Supplier;
use App\Models\Surgery;
use App\Models\TelemedicineSession;
use App\Models\User;
use App\Models\Ward;
use App\Services\ModuleRegistry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HealthcareDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Sync all 38 system modules
        ModuleRegistry::syncDatabase();

        // 2. Create SaaS Plans
        $starterPlan = SubscriptionPlan::create([
            'name' => 'Starter Practice',
            'slug' => 'starter-practice',
            'description' => 'Ideal for private chambers and single-doctor clinics',
            'price_monthly' => 49.00,
            'price_yearly' => 490.00,
            'max_branches' => 1,
            'max_staff' => 5,
            'max_patients' => 500,
            'storage_quota_mb' => 2048,
            'is_active' => true,
        ]);

        $growthPlan = SubscriptionPlan::create([
            'name' => 'Clinic Growth',
            'slug' => 'clinic-growth',
            'description' => 'Comprehensive OPD, IPD, and LIS for growing medical clinics',
            'price_monthly' => 149.00,
            'price_yearly' => 1490.00,
            'max_branches' => 3,
            'max_staff' => 25,
            'max_patients' => 5000,
            'storage_quota_mb' => 10240,
            'is_active' => true,
        ]);

        $enterprisePlan = SubscriptionPlan::create([
            'name' => 'Hospital Enterprise',
            'slug' => 'hospital-enterprise',
            'description' => 'Multi-branch hospital network with full clinical ERP, ICU, and surgical suite',
            'price_monthly' => 399.00,
            'price_yearly' => 3990.00,
            'max_branches' => 10,
            'max_staff' => 200,
            'max_patients' => 50000,
            'storage_quota_mb' => 51200,
            'is_active' => true,
        ]);

        // 3. Super Administrator
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@grandhealth.test',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // 4. Demo Organizations
        // Org 1: Grand City General Hospital
        $org1 = Organization::create([
            'name' => 'Grand City General Hospital',
            'slug' => 'grand-city-general-hospital',
            'code' => 'GCGH-01',
            'business_type' => 'hospital',
            'email' => 'contact@grandcityhospital.test',
            'phone' => '+1-555-0100',
            'website' => 'https://grandcityhospital.test',
            'address' => '100 Healthcare Boulevard, Suite 500',
            'city' => 'Metropolis',
            'country' => 'US',
            'currency' => 'USD',
            'timezone' => 'America/New_York',
            'primary_color' => '#0284c7',
            'is_active' => true,
        ]);

        // Org 2: CarePlus Family Clinic
        $org2 = Organization::create([
            'name' => 'CarePlus Family Clinic',
            'slug' => 'careplus-family-clinic',
            'code' => 'CPFC-02',
            'business_type' => 'clinic',
            'email' => 'info@careplusclinic.test',
            'phone' => '+1-555-0200',
            'website' => 'https://careplusclinic.test',
            'address' => '45 Community Avenue',
            'city' => 'Riverside',
            'country' => 'US',
            'currency' => 'USD',
            'timezone' => 'America/Chicago',
            'primary_color' => '#059669',
            'is_active' => true,
        ]);

        // Org 3: BrightCare Diagnostic Center
        $org3 = Organization::create([
            'name' => 'BrightCare Diagnostic Center',
            'slug' => 'brightcare-diagnostic-center',
            'code' => 'BCDC-03',
            'business_type' => 'diagnostic',
            'email' => 'lab@brightcarediag.test',
            'phone' => '+1-555-0300',
            'website' => 'https://brightcarediag.test',
            'address' => '88 Lab Parkway',
            'city' => 'Capital City',
            'country' => 'US',
            'currency' => 'USD',
            'timezone' => 'America/Chicago',
            'primary_color' => '#7c3aed',
            'is_active' => true,
        ]);

        // Enable all modules for Org 1
        foreach (ModuleRegistry::allDefinitions() as $key => $mod) {
            ModuleActivation::create([
                'organization_id' => $org1->id,
                'module_key' => $key,
                'is_enabled' => true,
                'activated_at' => now(),
            ]);
        }

        // 5. Branches (6+ branches across organizations)
        $branch1Main = Branch::create([
            'organization_id' => $org1->id,
            'name' => 'Central Hospital Campus',
            'slug' => 'central-hospital-campus',
            'code' => 'GCGH-MAIN',
            'is_main' => true,
            'phone' => '+1-555-0101',
            'email' => 'central@grandcityhospital.test',
            'address' => '100 Healthcare Boulevard',
            'city' => 'Metropolis',
            'currency' => 'USD',
            'tax_rate' => 5.00,
            'is_active' => true,
        ]);

        $branch1North = Branch::create([
            'organization_id' => $org1->id,
            'name' => 'North Medical Center',
            'slug' => 'north-medical-center',
            'code' => 'GCGH-NORTH',
            'is_main' => false,
            'phone' => '+1-555-0102',
            'email' => 'north@grandcityhospital.test',
            'address' => '220 North Ridge Road',
            'city' => 'Metropolis North',
            'currency' => 'USD',
            'tax_rate' => 5.00,
            'is_active' => true,
        ]);

        $branch1South = Branch::create([
            'organization_id' => $org1->id,
            'name' => 'South Specialist Clinic',
            'slug' => 'south-specialist-clinic',
            'code' => 'GCGH-SOUTH',
            'is_main' => false,
            'phone' => '+1-555-0103',
            'email' => 'south@grandcityhospital.test',
            'address' => '50 Bay View Drive',
            'city' => 'Metropolis South',
            'currency' => 'USD',
            'tax_rate' => 5.00,
            'is_active' => true,
        ]);

        $branch2Main = Branch::create([
            'organization_id' => $org2->id,
            'name' => 'Main Care Clinic',
            'slug' => 'main-care-clinic',
            'code' => 'CPFC-MAIN',
            'is_main' => true,
            'phone' => '+1-555-0201',
            'email' => 'main@careplusclinic.test',
            'address' => '45 Community Avenue',
            'city' => 'Riverside',
            'currency' => 'USD',
            'tax_rate' => 0.00,
            'is_active' => true,
        ]);

        $branch2Downtown = Branch::create([
            'organization_id' => $org2->id,
            'name' => 'Downtown Clinic',
            'slug' => 'downtown-clinic',
            'code' => 'CPFC-DTN',
            'is_main' => false,
            'phone' => '+1-555-0202',
            'email' => 'downtown@careplusclinic.test',
            'address' => '12 Commerce Way',
            'city' => 'Riverside Downtown',
            'currency' => 'USD',
            'tax_rate' => 0.00,
            'is_active' => true,
        ]);

        $branch3Main = Branch::create([
            'organization_id' => $org3->id,
            'name' => 'Main Diagnostic Center',
            'slug' => 'main-diagnostic-center',
            'code' => 'BCDC-MAIN',
            'is_main' => true,
            'phone' => '+1-555-0301',
            'email' => 'central@brightcarediag.test',
            'address' => '88 Lab Parkway',
            'city' => 'Capital City',
            'currency' => 'USD',
            'tax_rate' => 4.00,
            'is_active' => true,
        ]);

        $branch3East = Branch::create([
            'organization_id' => $org3->id,
            'name' => 'East Diagnostic Hub',
            'slug' => 'east-diagnostic-hub',
            'code' => 'BCDC-EAST',
            'is_main' => false,
            'phone' => '+1-555-0302',
            'email' => 'east@brightcarediag.test',
            'address' => '400 East Sector',
            'city' => 'Capital City East',
            'currency' => 'USD',
            'tax_rate' => 4.00,
            'is_active' => true,
        ]);

        // 6. Departments
        $deptNames = ['Cardiology', 'Orthopedics', 'Pediatrics', 'General Medicine', 'Radiology', 'Pathology', 'General Surgery', 'Dental Care', 'Physiotherapy'];
        $departments = [];
        foreach ($deptNames as $dName) {
            $departments[$dName] = Department::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'name' => $dName,
                'code' => strtoupper(substr($dName, 0, 4)),
                'is_clinical' => true,
                'is_active' => true,
            ]);
        }

        // 7. Role-Specific Demo User Accounts
        $roleUsers = [
            'owner' => ['name' => 'Arthur Vance', 'email' => 'owner@grandhealth.test', 'role' => 'organization_owner'],
            'hospital_admin' => ['name' => 'Helen Morris', 'email' => 'admin@grandhealth.test', 'role' => 'hospital_admin'],
            'branch_admin' => ['name' => 'Marcus Bell', 'email' => 'branch@grandhealth.test', 'role' => 'branch_admin'],
            'doctor' => ['name' => 'Dr. Robert Chen', 'email' => 'doctor@grandhealth.test', 'role' => 'doctor'],
            'nurse' => ['name' => 'Sarah Jenkins, RN', 'email' => 'nurse@grandhealth.test', 'role' => 'nurse'],
            'receptionist' => ['name' => 'Emma Watson', 'email' => 'reception@grandhealth.test', 'role' => 'receptionist'],
            'pharmacist' => ['name' => 'David Miller, RPh', 'email' => 'pharmacy@grandhealth.test', 'role' => 'pharmacist'],
            'lab_tech' => ['name' => 'Lisa Ray, MT', 'email' => 'lab@grandhealth.test', 'role' => 'lab_technician'],
            'accountant' => ['name' => 'Thomas Wright, CPA', 'email' => 'accountant@grandhealth.test', 'role' => 'accountant'],
            'hr_manager' => ['name' => 'Rachel Adams', 'email' => 'hr@grandhealth.test', 'role' => 'hr_manager'],
            'patient' => ['name' => 'James Wilson', 'email' => 'patient@grandhealth.test', 'role' => 'patient'],
        ];

        $createdUsers = [];
        foreach ($roleUsers as $key => $u) {
            $createdUsers[$key] = User::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'name' => $u['name'],
                'email' => $u['email'],
                'role' => $u['role'],
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        // 8. 20+ Doctors and Duty Schedules
        $specialties = [
            ['Cardiologist', 'Cardiology', 120.00],
            ['Orthopedic Surgeon', 'Orthopedics', 130.00],
            ['Pediatrician', 'Pediatrics', 90.00],
            ['Internal Medicine Specialist', 'General Medicine', 80.00],
            ['Diagnostic Radiologist', 'Radiology', 110.00],
            ['Clinical Pathologist', 'Pathology', 85.00],
            ['General Surgeon', 'General Surgery', 140.00],
            ['Dental Surgeon', 'Dental Care', 75.00],
            ['Consultant Physiotherapist', 'Physiotherapy', 65.00],
            ['Neurologist', 'General Medicine', 150.00],
            ['Dermatologist', 'General Medicine', 95.00],
            ['Gastroenterologist', 'General Medicine', 135.00],
            ['Endocrinologist', 'General Medicine', 115.00],
            ['ENT Specialist', 'General Surgery', 85.00],
            ['Ophthalmologist', 'General Surgery', 95.00],
            ['Urologist', 'General Surgery', 130.00],
            ['Nephrologist', 'General Medicine', 140.00],
            ['Pulmonologist', 'General Medicine', 110.00],
            ['Psychiatrist', 'General Medicine', 105.00],
            ['Rheumatologist', 'General Medicine', 100.00],
            ['Emergency Physician', 'General Medicine', 95.00],
        ];

        $doctors = [];
        // Connect Dr. Robert Chen (demo doctor)
        $docRobert = Doctor::create([
            'organization_id' => $org1->id,
            'branch_id' => $branch1Main->id,
            'user_id' => $createdUsers['doctor']->id,
            'department_id' => $departments['Cardiology']->id,
            'specialization' => 'Cardiologist',
            'qualification' => 'MD, FACC, Board Certified',
            'license_number' => 'MED-LIC-00101',
            'consultation_fee' => 120.00,
            'follow_up_fee' => 60.00,
            'room_number' => 'Suite 301',
            'bio' => 'Senior consultant in non-invasive clinical cardiology and cardiovascular imaging.',
            'is_available' => true,
        ]);
        $doctors[] = $docRobert;

        // Create remaining 20 doctors
        foreach ($specialties as $i => $s) {
            $docUser = User::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'name' => 'Dr. Specialist ' . ($i + 1),
                'email' => "doctor.spec{$i}@grandhealth.test",
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);

            $dept = $departments[$s[1]] ?? $departments['General Medicine'];

            $d = Doctor::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'user_id' => $docUser->id,
                'department_id' => $dept->id,
                'specialization' => $s[0],
                'qualification' => 'MBBS, MD, FCPS',
                'license_number' => 'MED-LIC-' . (10200 + $i),
                'consultation_fee' => $s[2],
                'follow_up_fee' => $s[2] * 0.5,
                'room_number' => 'Suite ' . (200 + $i),
                'bio' => "Experienced {$s[0]} providing patient-centered care.",
                'is_available' => true,
            ]);

            DoctorSchedule::create([
                'doctor_id' => $d->id,
                'branch_id' => $branch1Main->id,
                'day_of_week' => 'monday',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'slot_duration_minutes' => 15,
                'max_patients' => 25,
                'is_active' => true,
            ]);

            $doctors[] = $d;
        }

        // 9. 50+ Staff Profiles
        for ($sIdx = 1; $sIdx <= 52; $sIdx++) {
            $staffUser = User::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'name' => "Hospital Staff Member {$sIdx}",
                'email' => "staff{$sIdx}@grandhealth.test",
                'role' => $sIdx <= 20 ? 'nurse' : ($sIdx <= 30 ? 'receptionist' : ($sIdx <= 40 ? 'lab_technician' : 'pharmacist')),
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);

            StaffProfile::create([
                'user_id' => $staffUser->id,
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'employee_id' => 'EMP-' . str_pad((string) $sIdx, 4, '0', STR_PAD_LEFT),
                'designation' => $staffUser->role === 'nurse' ? 'Senior Staff Nurse' : ucfirst($staffUser->role),
                'qualification' => 'BSc / Diploma',
                'joining_date' => now()->subMonths(rand(3, 40))->toDateString(),
                'salary' => rand(3000, 7500),
                'status' => 'active',
            ]);

            // Seed attendance record for today
            AttendanceRecord::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'user_id' => $staffUser->id,
                'date' => today()->toDateString(),
                'check_in' => '08:52:00',
                'check_out' => '17:05:00',
                'status' => 'present',
                'verification_method' => 'biometric',
            ]);
        }

        // 10. 200+ Fictional Patients
        $patients = [];
        // Associate demo patient
        $demoPatient = Patient::create([
            'organization_id' => $org1->id,
            'branch_id' => $branch1Main->id,
            'user_id' => $createdUsers['patient']->id,
            'mrn' => 'MRN-100001',
            'first_name' => 'James',
            'last_name' => 'Wilson',
            'date_of_birth' => '1984-06-15',
            'gender' => 'male',
            'blood_group' => 'O+',
            'phone' => '+1-555-0901',
            'email' => 'patient@grandhealth.test',
            'address' => '742 Evergreen Terrace',
            'city' => 'Metropolis',
            'allergies' => 'Penicillin, NSAIDs',
            'chronic_conditions' => 'Mild Hypertension',
            'status' => 'active',
        ]);
        $patients[] = $demoPatient;

        $firstNames = ['Noah', 'Liam', 'Oliver', 'Elijah', 'Mateo', 'Lucas', 'Mason', 'Ethan', 'Logan', 'Aiden', 'Emma', 'Olivia', 'Amelia', 'Sophia', 'Isabella', 'Ava', 'Mia', 'Harper', 'Evelyn', 'Luna'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'];

        for ($p = 2; $p <= 205; $p++) {
            $f = $firstNames[($p * 7) % count($firstNames)];
            $l = $lastNames[($p * 11) % count($lastNames)];

            $patients[] = Patient::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'mrn' => 'MRN-' . (100000 + $p),
                'first_name' => $f,
                'last_name' => $l,
                'date_of_birth' => now()->subYears(rand(18, 75))->subDays(rand(1, 350))->toDateString(),
                'gender' => ($p % 2 === 0) ? 'female' : 'male',
                'blood_group' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+'][$p % 7],
                'phone' => '+1-555-' . str_pad((string) (1000 + $p), 4, '0', STR_PAD_LEFT),
                'email' => strtolower("{$f}.{$l}{$p}@patients.test"),
                'address' => "{$p} Healthcare Way, Sector " . ($p % 10),
                'city' => 'Metropolis',
                'allergies' => ($p % 5 === 0) ? 'Sulfa drugs, Dust mites' : null,
                'chronic_conditions' => ($p % 7 === 0) ? 'Type 2 Diabetes Mellitus' : null,
                'status' => 'active',
            ]);
        }

        // 11. Wards, Rooms, and Beds
        $wardGeneral = Ward::create([
            'organization_id' => $org1->id,
            'branch_id' => $branch1Main->id,
            'name' => 'General Medical Ward 3A',
            'type' => 'general',
            'floor' => '3rd Floor',
            'capacity' => 20,
            'status' => 'active',
        ]);

        $wardIcu = Ward::create([
            'organization_id' => $org1->id,
            'branch_id' => $branch1Main->id,
            'name' => 'Intensive Care Unit (ICU)',
            'type' => 'icu',
            'floor' => '4th Floor',
            'capacity' => 10,
            'status' => 'active',
        ]);

        $room101 = Room::create([
            'organization_id' => $org1->id,
            'branch_id' => $branch1Main->id,
            'ward_id' => $wardGeneral->id,
            'room_number' => '301',
            'type' => 'standard',
            'daily_rate' => 150.00,
            'status' => 'available',
        ]);

        $beds = [];
        for ($bIdx = 1; $bIdx <= 20; $bIdx++) {
            $beds[] = Bed::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'ward_id' => $wardGeneral->id,
                'room_id' => $room101->id,
                'bed_number' => 'BED-301-' . str_pad((string) $bIdx, 2, '0', STR_PAD_LEFT),
                'type' => 'standard',
                'daily_rate' => 120.00,
                'status' => $bIdx <= 6 ? 'occupied' : 'available',
            ]);
        }

        // Inpatient admissions for occupied beds
        for ($admIdx = 0; $admIdx < 6; $admIdx++) {
            Admission::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'patient_id' => $patients[$admIdx + 5]->id,
                'attending_doctor_id' => $doctors[0]->id,
                'bed_id' => $beds[$admIdx]->id,
                'admission_number' => 'ADM-' . (202600 + $admIdx),
                'admitted_at' => now()->subDays($admIdx + 1),
                'reason_for_admission' => 'Observation and inpatient clinical monitoring following acute exacerbation',
                'status' => 'admitted',
                'total_charges' => 600.00 + ($admIdx * 150),
            ]);
        }

        // 12. Medicines and Pharmacy Batches
        $meds = [
            ['MED-001', 'Paracetamol 500mg', 'Paracetamol', 'tablet', 0.25, 0.10],
            ['MED-002', 'Amoxicillin 500mg', 'Amoxicillin', 'capsule', 0.85, 0.40],
            ['MED-003', 'Omeprazole 20mg', 'Omeprazole', 'capsule', 0.60, 0.20],
            ['MED-004', 'Metformin 500mg', 'Metformin HCl', 'tablet', 0.35, 0.12],
            ['MED-005', 'Amlodipine 5mg', 'Amlodipine Besylate', 'tablet', 0.45, 0.15],
            ['MED-006', 'Atorvastatin 20mg', 'Atorvastatin Calcium', 'tablet', 0.95, 0.35],
            ['MED-007', 'Azithromycin 500mg', 'Azithromycin', 'tablet', 1.50, 0.70],
            ['MED-008', 'Ciprofloxacin 500mg', 'Ciprofloxacin', 'tablet', 1.10, 0.50],
            ['MED-009', 'Salbutamol Inhaler 100mcg', 'Salbutamol', 'inhaler', 8.50, 4.20],
            ['MED-010', 'Ceftriaxone 1g Vial', 'Ceftriaxone Sodium', 'injection', 6.00, 2.80],
        ];

        foreach ($meds as $m) {
            $createdMed = Medicine::create([
                'organization_id' => $org1->id,
                'code' => $m[0],
                'name' => $m[1],
                'generic_name' => $m[2],
                'category' => $m[3],
                'unit_price' => $m[4],
                'cost_price' => $m[5],
                'reorder_level' => 50,
                'requires_prescription' => true,
                'is_active' => true,
            ]);

            PharmacyBatch::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'medicine_id' => $createdMed->id,
                'batch_number' => 'BATCH-' . rand(1000, 9999),
                'expiry_date' => now()->addMonths(rand(12, 36))->toDateString(),
                'quantity' => rand(200, 1000),
                'purchase_price' => $m[5],
                'selling_price' => $m[4],
                'status' => 'available',
            ]);
        }

        // 13. Laboratory & Radiology Services
        $labTests = [
            ['LAB-CBC', 'Complete Blood Count (CBC)', 'haematology', 25.00, '4.5-11.0', '10^3/uL'],
            ['LAB-LIPID', 'Lipid Profile Comprehensive', 'biochemistry', 45.00, 'Optimal < 200', 'mg/dL'],
            ['LAB-LFT', 'Liver Function Tests (LFT)', 'biochemistry', 40.00, 'ALT: 7-56', 'U/L'],
            ['LAB-KFT', 'Kidney Function / Serum Creatinine', 'biochemistry', 30.00, '0.7-1.3', 'mg/dL'],
            ['LAB-HBA1C', 'HbA1c Glycated Hemoglobin', 'biochemistry', 35.00, '< 5.7', '%'],
            ['LAB-URINE', 'Urine Routine Examination', 'microbiology', 15.00, 'Normal', 'pH 6.0'],
        ];

        $createdLabs = [];
        foreach ($labTests as $lt) {
            $createdLabs[] = LabTest::create([
                'organization_id' => $org1->id,
                'code' => $lt[0],
                'name' => $lt[1],
                'category' => $lt[2],
                'price' => $lt[3],
                'normal_range' => $lt[4],
                'unit' => $lt[5],
                'turnaround_hours' => 24,
                'is_active' => true,
            ]);
        }

        RadiologyService::create([
            'organization_id' => $org1->id,
            'code' => 'RAD-CHEST',
            'name' => 'Chest X-Ray PA View',
            'modality' => 'x_ray',
            'price' => 50.00,
            'instructions' => 'Remove metallic jewelry before scan.',
            'is_active' => true,
        ]);

        RadiologyService::create([
            'organization_id' => $org1->id,
            'code' => 'RAD-USG-ABD',
            'name' => 'Ultrasound Whole Abdomen',
            'modality' => 'ultrasound',
            'price' => 75.00,
            'instructions' => 'Overnight fasting required.',
            'is_active' => true,
        ]);

        // 14. Appointments, Encounters, Prescriptions & Invoices
        for ($aptIdx = 0; $aptIdx < 30; $aptIdx++) {
            $pat = $patients[$aptIdx];
            $doc = $doctors[$aptIdx % count($doctors)];

            $aptDate = $aptIdx < 15 ? today()->toDateString() : today()->subDays($aptIdx - 14)->toDateString();
            $status = $aptIdx < 5 ? 'checked_in' : ($aptIdx < 15 ? 'scheduled' : 'completed');

            $apt = Appointment::create([
                'organization_id' => $org1->id,
                'branch_id' => $branch1Main->id,
                'patient_id' => $pat->id,
                'doctor_id' => $doc->id,
                'department_id' => $doc->department_id,
                'appointment_number' => 'APT-' . (300000 + $aptIdx),
                'appointment_date' => $aptDate,
                'start_time' => sprintf('%02d:00:00', 9 + ($aptIdx % 7)),
                'end_time' => sprintf('%02d:15:00', 9 + ($aptIdx % 7)),
                'token_number' => ($aptIdx % 15) + 1,
                'type' => 'consultation',
                'status' => $status,
                'fee' => $doc->consultation_fee,
                'payment_status' => $status === 'completed' ? 'paid' : 'unpaid',
                'reason' => 'Routine clinical consultation and health check',
            ]);

            if ($status === 'completed') {
                $enc = Encounter::create([
                    'organization_id' => $org1->id,
                    'branch_id' => $branch1Main->id,
                    'patient_id' => $pat->id,
                    'doctor_id' => $doc->id,
                    'appointment_id' => $apt->id,
                    'encounter_number' => 'ENC-' . (400000 + $aptIdx),
                    'type' => 'opd',
                    'systolic_bp' => 120,
                    'diastolic_bp' => 80,
                    'pulse_rate' => 74,
                    'temperature' => 98.4,
                    'chief_complaints' => 'Patient presented with intermittent chest tightness and mild fatigue on exertion.',
                    'clinical_notes' => 'Cardiovascular exam reveals normal S1/S2 heart sounds with no murmurs. Lungs clear to auscultation bilaterally.',
                    'diagnosis' => 'Essential Hypertension (Stage 1), Controlled',
                    'treatment_plan' => 'Lifestyle modifications, low sodium diet, prescription medication, and follow-up in 4 weeks.',
                    'status' => 'completed',
                ]);

                $presc = Prescription::create([
                    'organization_id' => $org1->id,
                    'branch_id' => $branch1Main->id,
                    'encounter_id' => $enc->id,
                    'patient_id' => $pat->id,
                    'doctor_id' => $doc->id,
                    'prescription_number' => 'RX-' . (500000 + $aptIdx),
                    'advice' => 'Adequate hydration, aerobic exercise 30 mins daily, avoid high-fat meals.',
                    'follow_up_date' => now()->addWeeks(4)->toDateString(),
                    'is_signed' => true,
                    'signed_at' => now(),
                    'status' => 'active',
                ]);

                PrescriptionItem::create([
                    'prescription_id' => $presc->id,
                    'medicine_name' => 'Amlodipine 5mg',
                    'generic_name' => 'Amlodipine Besylate',
                    'dosage' => '5mg',
                    'frequency' => '1+0+0 (Morning)',
                    'duration' => '30 Days',
                    'instructions' => 'Take daily in morning after breakfast',
                ]);

                // Create billing invoice
                $inv = Invoice::create([
                    'organization_id' => $org1->id,
                    'branch_id' => $branch1Main->id,
                    'patient_id' => $pat->id,
                    'appointment_id' => $apt->id,
                    'encounter_id' => $enc->id,
                    'invoice_number' => 'INV-' . (600000 + $aptIdx),
                    'invoice_date' => today(),
                    'subtotal' => $doc->consultation_fee,
                    'discount' => 0.00,
                    'tax' => $doc->consultation_fee * 0.05,
                    'total' => $doc->consultation_fee * 1.05,
                    'paid_amount' => $doc->consultation_fee * 1.05,
                    'balance_due' => 0.00,
                    'status' => 'paid',
                ]);

                InvoiceItem::create([
                    'invoice_id' => $inv->id,
                    'item_type' => 'consultation',
                    'item_id' => $doc->id,
                    'description' => "Doctor Consultation - Dr. {$doc->user->name}",
                    'quantity' => 1,
                    'unit_price' => $doc->consultation_fee,
                    'total' => $doc->consultation_fee,
                ]);

                Payment::create([
                    'organization_id' => $org1->id,
                    'branch_id' => $branch1Main->id,
                    'invoice_id' => $inv->id,
                    'patient_id' => $pat->id,
                    'received_by' => $createdUsers['receptionist']->id,
                    'payment_number' => 'REC-' . (700000 + $aptIdx),
                    'amount' => $inv->total,
                    'payment_method' => 'cash',
                    'status' => 'completed',
                ]);
            }
        }

        // 15. Financial Accounts (Double-Entry Chart of Accounts)
        $accCash = Account::create(['organization_id' => $org1->id, 'branch_id' => $branch1Main->id, 'code' => '1001', 'name' => 'Main Cash Drawer', 'type' => 'asset', 'balance' => 25000.00]);
        $accBank = Account::create(['organization_id' => $org1->id, 'branch_id' => $branch1Main->id, 'code' => '1002', 'name' => 'Operating Bank Account', 'type' => 'asset', 'balance' => 150000.00]);
        $accRevenue = Account::create(['organization_id' => $org1->id, 'branch_id' => $branch1Main->id, 'code' => '4001', 'name' => 'Patient Consultation Revenue', 'type' => 'revenue', 'balance' => 45000.00]);

        $jEntry = JournalEntry::create([
            'organization_id' => $org1->id,
            'branch_id' => $branch1Main->id,
            'created_by' => $createdUsers['accountant']->id,
            'entry_number' => 'JRN-2026-0001',
            'entry_date' => today(),
            'description' => 'Daily cashier reconciliation posting for outpatient collections',
            'total_debit' => 1500.00,
            'total_credit' => 1500.00,
            'status' => 'posted',
        ]);

        JournalLine::create(['journal_entry_id' => $jEntry->id, 'account_id' => $accCash->id, 'type' => 'debit', 'amount' => 1500.00, 'description' => 'Daily cash intake']);
        JournalLine::create(['journal_entry_id' => $jEntry->id, 'account_id' => $accRevenue->id, 'type' => 'credit', 'amount' => 1500.00, 'description' => 'Consultation services']);

        // 16. Audit event logs
        AuditEvent::log('system_initialized', null, null, ['environment' => 'production_demo', 'organizations' => 3, 'branches' => 7]);
    }
}
