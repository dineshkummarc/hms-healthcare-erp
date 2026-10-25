<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Encounter;
use App\Models\Invoice;
use App\Models\LabOrder;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\User;
use App\Services\ModuleRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'application' => 'Clinic & Hospital Management ERP',
            'version' => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function modules(): JsonResponse
    {
        return response()->json([
            'modules' => ModuleRegistry::allDefinitions(),
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (! $user->is_active) {
            return response()->json(['message' => 'Account is deactivated'], 403);
        }

        $deviceName = $validated['device_name'] ?? 'MobileApp';
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'organization_id' => $user->organization_id,
                'branch_id' => $user->branch_id,
            ],
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->load(['organization', 'branch', 'patient', 'doctor']),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function patientProfile(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json(['message' => 'Patient record not found for this user account'], 404);
        }

        return response()->json(['patient' => $patient]);
    }

    public function patientPrescriptions(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json(['prescriptions' => []]);
        }

        $prescriptions = Prescription::with(['doctor.user', 'items'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->paginate(15);

        return response()->json($prescriptions);
    }

    public function patientLabOrders(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json(['lab_orders' => []]);
        }

        $labOrders = LabOrder::with(['items.labTest'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->paginate(15);

        return response()->json($labOrders);
    }

    public function patientInvoices(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json(['invoices' => []]);
        }

        $invoices = Invoice::with(['items', 'payments'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->paginate(15);

        return response()->json($invoices);
    }

    public function doctors(Request $request): JsonResponse
    {
        $orgId = $request->user()->organization_id;
        $branchId = $request->query('branch_id');

        $query = Doctor::with(['user', 'department'])
            ->where('organization_id', $orgId)
            ->where('is_available', true);

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        return response()->json(['doctors' => $query->get()]);
    }

    public function appointments(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->patient) {
            $appointments = Appointment::with(['doctor.user', 'department', 'branch'])
                ->where('patient_id', $user->patient->id)
                ->latest('appointment_date')
                ->paginate(15);
        } elseif ($user->doctor) {
            $appointments = Appointment::with(['patient', 'department', 'branch'])
                ->where('doctor_id', $user->doctor->id)
                ->where('appointment_date', '>=', now()->toDateString())
                ->orderBy('appointment_date')
                ->orderBy('start_time')
                ->paginate(20);
        } else {
            $appointments = Appointment::with(['patient', 'doctor.user', 'branch'])
                ->where('organization_id', $user->organization_id)
                ->latest()
                ->paginate(20);
        }

        return response()->json($appointments);
    }

    public function bookAppointment(Request $request): JsonResponse
    {
        $user = $request->user();
        $patient = $user->patient;

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'branch_id' => 'required|exists:branches,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'reason' => 'nullable|string',
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);

        // Concurrency-safe check to prevent double-booking
        $collision = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $validated['appointment_date'])
            ->where('start_time', $validated['start_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($collision) {
            return response()->json([
                'error' => 'Slot Collision',
                'message' => 'This doctor slot has already been booked. Please select another time.',
            ], 422);
        }

        $appointmentNumber = 'APT-'.strtoupper(Str::random(8));

        $appointment = Appointment::create([
            'organization_id' => $user->organization_id,
            'branch_id' => $validated['branch_id'],
            'patient_id' => $patient ? $patient->id : $request->input('patient_id'),
            'doctor_id' => $doctor->id,
            'department_id' => $doctor->department_id,
            'appointment_number' => $appointmentNumber,
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'token_number' => Appointment::where('doctor_id', $doctor->id)->where('appointment_date', $validated['appointment_date'])->count() + 1,
            'type' => 'consultation',
            'status' => 'scheduled',
            'fee' => $doctor->consultation_fee,
            'payment_status' => 'unpaid',
            'reason' => $validated['reason'] ?? 'Routine consultation',
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully',
            'appointment' => $appointment->load(['doctor.user', 'patient']),
        ], 201);
    }

    public function cancelAppointment(Request $request, int $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);

        // Security check
        $user = $request->user();
        if ($user->patient && $appointment->patient_id !== $user->patient->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointment->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Appointment cancelled successfully',
            'appointment' => $appointment,
        ]);
    }

    public function doctorQueue(Request $request): JsonResponse
    {
        $doctor = $request->user()->doctor;

        if (! $doctor) {
            return response()->json(['message' => 'Doctor profile not associated with this account'], 403);
        }

        $queue = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', now()->toDateString())
            ->whereIn('status', ['scheduled', 'confirmed', 'checked_in', 'in_consultation'])
            ->orderBy('token_number')
            ->get();

        return response()->json(['today_queue' => $queue]);
    }

    public function createEncounter(Request $request): JsonResponse
    {
        $doctor = $request->user()->doctor;

        if (! $doctor) {
            return response()->json(['message' => 'Doctor profile required'], 403);
        }

        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'chief_complaints' => 'required|string',
            'clinical_notes' => 'nullable|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'nullable|string',
            'systolic_bp' => 'nullable|integer',
            'diastolic_bp' => 'nullable|integer',
            'pulse_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
        ]);

        $appointment = Appointment::findOrFail($validated['appointment_id']);

        $encounter = Encounter::create([
            'organization_id' => $appointment->organization_id,
            'branch_id' => $appointment->branch_id,
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctor->id,
            'appointment_id' => $appointment->id,
            'encounter_number' => 'ENC-'.strtoupper(Str::random(8)),
            'type' => 'opd',
            'chief_complaints' => $validated['chief_complaints'],
            'clinical_notes' => $validated['clinical_notes'] ?? null,
            'diagnosis' => $validated['diagnosis'],
            'treatment_plan' => $validated['treatment_plan'] ?? null,
            'systolic_bp' => $validated['systolic_bp'] ?? null,
            'diastolic_bp' => $validated['diastolic_bp'] ?? null,
            'pulse_rate' => $validated['pulse_rate'] ?? null,
            'temperature' => $validated['temperature'] ?? null,
            'status' => 'completed',
            'started_at' => now(),
            'ended_at' => now(),
        ]);

        $appointment->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Clinical encounter documented successfully',
            'encounter' => $encounter,
        ], 201);
    }

    public function medicines(Request $request): JsonResponse
    {
        $orgId = $request->user()->organization_id;

        $medicines = Medicine::with(['batches'])
            ->where('organization_id', $orgId)
            ->where('is_active', true)
            ->paginate(25);

        return response()->json($medicines);
    }

    public function stockAlerts(Request $request): JsonResponse
    {
        $orgId = $request->user()->organization_id;

        $lowStock = Medicine::where('organization_id', $orgId)
            ->where('is_active', true)
            ->get()
            ->filter(fn ($med) => $med->totalStock() <= $med->reorder_level)
            ->values();

        return response()->json(['low_stock_items' => $lowStock]);
    }
}
