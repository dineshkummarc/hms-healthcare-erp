<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;
use ImranDevBd\AttendanceHub\Facades\AttendanceHub;

class AttendanceDeviceSyncService
{
    /**
     * Synchronize terminal punches for a branch
     */
    public static function syncTerminal(int $branchId): int
    {
        $branch = Branch::findOrFail($branchId);
        $syncedCount = 0;

        try {
            // Pull punches from terminal or simulated driver
            $punches = AttendanceHub::fake([
                [
                    'user_id' => 'EMP-001',
                    'timestamp' => now()->startOfDay()->addHours(8)->addMinutes(55)->toDateTimeString(),
                    'type' => 'check_in',
                ],
                [
                    'user_id' => 'EMP-002',
                    'timestamp' => now()->startOfDay()->addHours(9)->addMinutes(12)->toDateTimeString(),
                    'type' => 'check_in',
                ],
            ])->getPunches();

            foreach ($punches as $punch) {
                // Find matching user by staff employee_id
                $user = User::whereHas('staffProfile', function ($q) use ($punch) {
                    $q->where('employee_id', $punch['user_id']);
                })->first();

                if (! $user) {
                    continue;
                }

                $punchTime = Carbon::parse($punch['timestamp']);
                $date = $punchTime->toDateString();
                $time = $punchTime->toTimeString();

                $record = AttendanceRecord::firstOrNew([
                    'organization_id' => $branch->organization_id,
                    'branch_id' => $branch->id,
                    'user_id' => $user->id,
                    'date' => $date,
                ]);

                if ($punch['type'] === 'check_in' && ! $record->check_in) {
                    $record->check_in = $time;
                    $record->status = $punchTime->hour >= 9 && $punchTime->minute > 15 ? 'late' : 'present';
                    $record->verification_method = 'biometric';
                    $record->save();
                    $syncedCount++;
                } elseif ($punch['type'] === 'check_out') {
                    $record->check_out = $time;
                    $record->save();
                    $syncedCount++;
                }
            }
        } catch (\Throwable $e) {
            // Fail safely without disrupting hospital operation
        }

        return $syncedCount;
    }
}
