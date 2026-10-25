<?php

namespace App\Filament\Resources\Encounters\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EncounterForm
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
                Select::make('doctor_id')
                    ->relationship('doctor', 'id')
                    ->required(),
                Select::make('appointment_id')
                    ->relationship('appointment', 'id'),
                TextInput::make('encounter_number')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('opd'),
                TextInput::make('triage_priority')
                    ->required()
                    ->default('normal'),
                TextInput::make('systolic_bp')
                    ->numeric(),
                TextInput::make('diastolic_bp')
                    ->numeric(),
                TextInput::make('pulse_rate')
                    ->numeric(),
                TextInput::make('temperature')
                    ->numeric(),
                TextInput::make('respiratory_rate')
                    ->numeric(),
                TextInput::make('spo2')
                    ->numeric(),
                TextInput::make('height_cm')
                    ->numeric(),
                TextInput::make('weight_kg')
                    ->numeric(),
                TextInput::make('bmi')
                    ->numeric(),
                Textarea::make('chief_complaints')
                    ->columnSpanFull(),
                Textarea::make('clinical_notes')
                    ->columnSpanFull(),
                Textarea::make('diagnosis')
                    ->columnSpanFull(),
                Textarea::make('treatment_plan')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('in_progress'),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('ended_at'),
            ]);
    }
}
