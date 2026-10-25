<?php

namespace App\Filament\Resources\TelemedicineSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TelemedicineSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('appointment_id')
                    ->relationship('appointment', 'id')
                    ->required(),
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->required(),
                Select::make('doctor_id')
                    ->relationship('doctor', 'id')
                    ->required(),
                TextInput::make('room_id')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('waiting'),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('ended_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
