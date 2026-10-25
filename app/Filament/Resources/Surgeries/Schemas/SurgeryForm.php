<?php

namespace App\Filament\Resources\Surgeries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SurgeryForm
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
                Select::make('lead_surgeon_id')
                    ->relationship('leadSurgeon', 'id')
                    ->required(),
                TextInput::make('case_number')
                    ->required(),
                TextInput::make('procedure_name')
                    ->required(),
                TextInput::make('ot_room')
                    ->required()
                    ->default('OT-1'),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('scheduled'),
                Textarea::make('preoperative_notes')
                    ->columnSpanFull(),
                Textarea::make('postoperative_notes')
                    ->columnSpanFull(),
                Textarea::make('anesthesia_notes')
                    ->columnSpanFull(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
