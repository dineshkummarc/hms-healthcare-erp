<?php

namespace App\Filament\Resources\LabOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LabOrderForm
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
                    ->relationship('doctor', 'id'),
                Select::make('encounter_id')
                    ->relationship('encounter', 'id'),
                TextInput::make('order_number')
                    ->required(),
                TextInput::make('priority')
                    ->required()
                    ->default('routine'),
                TextInput::make('status')
                    ->required()
                    ->default('ordered'),
                Textarea::make('clinical_notes')
                    ->columnSpanFull(),
                DateTimePicker::make('sample_collected_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
