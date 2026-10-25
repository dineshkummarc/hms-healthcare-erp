<?php

namespace App\Filament\Widgets;

use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\LabOrder;
use App\Models\Medicine;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HospitalStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = auth()->user();
        $orgId = $user?->organization_id;

        // Appointments today
        $appointmentsToday = Appointment::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->whereDate('appointment_date', today())
            ->count();

        // Patients waiting in queue
        $patientsWaiting = Appointment::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->whereDate('appointment_date', today())
            ->whereIn('status', ['scheduled', 'checked_in'])
            ->count();

        // Doctors on duty / available
        $doctorsAvailable = Doctor::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->where('is_available', true)
            ->count();

        // Currently admitted patients
        $admittedPatients = Admission::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->where('status', 'admitted')
            ->count();

        // Bed occupancy
        $totalBeds = Bed::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->count();
        $availableBeds = Bed::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->where('status', 'available')
            ->count();

        // Pending lab orders
        $pendingLabs = LabOrder::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->whereIn('status', ['ordered', 'sample_collected', 'in_progress'])
            ->count();

        // Today's revenue collections
        $todayCollections = Payment::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->whereDate('payment_date', today())
            ->where('status', 'completed')
            ->sum('amount');

        // Total outstanding dues
        $outstandingDues = Invoice::query()
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->sum('balance_due');

        return [
            Stat::make("Today's Appointments", $appointmentsToday)
                ->description("{$patientsWaiting} patients waiting in queue")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Doctors On Duty', $doctorsAvailable)
                ->description('Active clinician privileges')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Admitted Inpatients', $admittedPatients)
                ->description("{$availableBeds} of {$totalBeds} beds available")
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('warning'),

            Stat::make('Pending Lab Tests', $pendingLabs)
                ->description('Specimens awaiting technician review')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('danger'),

            Stat::make("Today's Collections", '$'.number_format($todayCollections, 2))
                ->description('Verified payments recorded')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Outstanding Invoices', '$'.number_format($outstandingDues, 2))
                ->description('Receivables balance due')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
        ];
    }
}
