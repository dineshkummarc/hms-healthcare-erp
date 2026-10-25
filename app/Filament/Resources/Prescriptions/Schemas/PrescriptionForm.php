<?php

namespace App\Filament\Resources\Prescriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PrescriptionForm
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
                Select::make('encounter_id')
                    ->relationship('encounter', 'id'),
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->required(),
                Select::make('doctor_id')
                    ->relationship('doctor', 'id')
                    ->required(),
                TextInput::make('prescription_number')
                    ->required(),
                Textarea::make('advice')
                    ->columnSpanFull(),
                DatePicker::make('follow_up_date'),
                Toggle::make('is_signed')
                    ->required(),
                DateTimePicker::make('signed_at'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
