<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\SubscriptionPlan;
use App\Services\ModuleRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicWebsiteController extends Controller
{
    public function home()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $modules = ModuleRegistry::allDefinitions();
        $organizations = Organization::with('branches')->where('is_active', true)->take(3)->get();

        return view('pages.home', compact('plans', 'modules', 'organizations'));
    }

    public function page(string $slug)
    {
        $validPages = [
            'features',
            'modules',
            'clinic-management',
            'hospital-management',
            'appointment-management',
            'emr',
            'prescriptions',
            'pharmacy',
            'laboratory',
            'radiology',
            'billing-accounting',
            'multi-branch',
            'ai-capabilities',
            'security-privacy',
            'integrations',
            'pricing',
            'demo',
            'about',
            'contact',
            'faq',
            'blog',
            'help-center',
            'documentation',
            'terms',
            'privacy',
            'cookie-policy',
            'register-organization',
            'support',
        ];

        if (! in_array($slug, $validPages, true)) {
            abort(404);
        }

        $plans = SubscriptionPlan::where('is_active', true)->get();
        $modules = ModuleRegistry::allDefinitions();
        $doctors = Doctor::with(['user', 'department', 'organization'])->where('is_available', true)->take(6)->get();

        return view('pages.standard', [
            'slug' => $slug,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'plans' => $plans,
            'modules' => $modules,
            'doctors' => $doctors,
        ]);
    }

    public function hospitalMicrosite(string $slug)
    {
        $organization = Organization::with(['branches.departments', 'doctors.user', 'doctors.department'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.microsite', compact('organization'));
    }

    public function bookAppointmentForm(Request $request)
    {
        $organizations = Organization::with('branches')->where('is_active', true)->get();
        $doctors = Doctor::with(['user', 'department', 'branch'])->where('is_available', true)->get();

        return view('pages.book-appointment', compact('organizations', 'doctors'));
    }

    public function submitPublicAppointment(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'branch_id' => 'required|exists:branches,id',
            'patient_name' => 'required|string|max:100',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'reason' => 'nullable|string',
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $branch = Branch::findOrFail($validated['branch_id']);

        // Prevent double booking
        $collision = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('start_time', 'like', substr($validated['start_time'], 0, 5) . '%')
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($collision) {
            return redirect()->route('booking.form')->withInput()->with('error', 'This appointment slot is already occupied. Please select an alternate time.');
        }

        // Find or create patient record
        $nameParts = explode(' ', $validated['patient_name'], 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? 'Patient';

        $patient = Patient::firstOrCreate(
            ['phone' => $validated['patient_phone'], 'organization_id' => $branch->organization_id],
            [
                'branch_id' => $branch->id,
                'mrn' => 'MRN-' . strtoupper(Str::random(7)),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'date_of_birth' => '1990-01-01',
                'gender' => 'other',
                'email' => $validated['patient_email'] ?? null,
                'status' => 'active',
            ]
        );

        $endTime = date('H:i:s', strtotime($validated['start_time'] . ' + 15 minutes'));
        $tokenNumber = Appointment::where('doctor_id', $doctor->id)->where('appointment_date', $validated['appointment_date'])->count() + 1;

        $appointment = Appointment::create([
            'organization_id' => $branch->organization_id,
            'branch_id' => $branch->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $doctor->department_id,
            'appointment_number' => 'APT-' . strtoupper(Str::random(8)),
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $endTime,
            'token_number' => $tokenNumber,
            'type' => 'online',
            'status' => 'scheduled',
            'fee' => $doctor->consultation_fee,
            'payment_status' => 'unpaid',
            'reason' => $validated['reason'] ?? 'Public Online Booking',
        ]);

        return redirect()->route('booking.success', ['token' => $appointment->appointment_number]);
    }

    public function bookingSuccess(string $token)
    {
        $appointment = Appointment::with(['doctor.user', 'patient', 'branch', 'organization'])
            ->where('appointment_number', $token)
            ->firstOrFail();

        return view('pages.booking-success', compact('appointment'));
    }

    public function setupWizard()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        return view('pages.setup-wizard', compact('plans'));
    }

    public function completeSetupWizard(Request $request)
    {
        $validated = $request->validate([
            'business_type' => 'required',
            'organization_name' => 'required|string|max:100',
            'branch_name' => 'required|string|max:100',
            'currency' => 'required|string|max:5',
            'admin_name' => 'required|string|max:100',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:8',
        ]);

        $slug = Str::slug($validated['organization_name']) . '-' . Str::random(4);

        $org = Organization::create([
            'name' => $validated['organization_name'],
            'slug' => $slug,
            'code' => 'ORG-' . strtoupper(Str::random(6)),
            'business_type' => $validated['business_type'],
            'currency' => $validated['currency'],
            'country' => 'US',
            'timezone' => 'UTC',
            'is_active' => true,
        ]);

        $branch = Branch::create([
            'organization_id' => $org->id,
            'name' => $validated['branch_name'],
            'slug' => 'main-branch',
            'code' => 'BR-' . strtoupper(Str::random(6)),
            'is_main' => true,
            'currency' => $validated['currency'],
            'is_active' => true,
        ]);

        $user = \App\Models\User::create([
            'organization_id' => $org->id,
            'branch_id' => $branch->id,
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'role' => 'organization_owner',
            'password' => bcrypt($validated['admin_password']),
            'is_active' => true,
        ]);

        return redirect('/admin/login')->with('status', 'Organization created! You can now log into your Admin Panel.');
    }
}
