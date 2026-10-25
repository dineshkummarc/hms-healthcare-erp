<?php

namespace App\Filament\Resources\Admissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AdmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->required(),
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->required(),
                Select::make('attending_doctor_id')
                    ->relationship('attendingDoctor', 'id')
                    ->required(),
                Select::make('bed_id')
                    ->relationship('bed', 'id')
                    ->required(),
                TextInput::make('admission_number')
                    ->required(),
                DateTimePicker::make('admitted_at')
                    ->required(),
                Textarea::make('reason_for_admission')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('admitted'),
                DateTimePicker::make('discharged_at'),
                Textarea::make('discharge_summary')
                    ->columnSpanFull(),
                TextInput::make('discharge_type'),
                TextInput::make('total_charges')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
