<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->with(['patient', 'doctor.user', 'branch'])
                    ->latest()
                    ->limit(10)
            )
            ->heading('Recent Clinical Appointments & Encounters')
            ->columns([
                TextColumn::make('appointment_number')
                    ->label('Token / ID')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),
                TextColumn::make('doctor.user.name')
                    ->label('Consultant Doctor'),
                TextColumn::make('branch.name')
                    ->label('Branch / Facility'),
                TextColumn::make('appointment_date')
                    ->label('Date')
                    ->date(),
                TextColumn::make('start_time')
                    ->label('Time'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'scheduled' => 'info',
                        'checked_in' => 'warning',
                        'in_consultation' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'partially_paid' => 'warning',
                        'unpaid' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}
