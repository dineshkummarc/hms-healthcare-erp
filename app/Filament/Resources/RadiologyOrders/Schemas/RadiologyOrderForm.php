<?php

namespace App\Filament\Resources\RadiologyOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RadiologyOrderForm
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
                Select::make('service_id')
                    ->relationship('service', 'name')
                    ->required(),
                Select::make('radiologist_id')
                    ->relationship('radiologist', 'name'),
                TextInput::make('order_number')
                    ->required(),
                TextInput::make('modality')
                    ->required(),
                Textarea::make('clinical_indication')
                    ->columnSpanFull(),
                Textarea::make('findings')
                    ->columnSpanFull(),
                Textarea::make('impression')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('scheduled'),
                DateTimePicker::make('performed_at'),
                DateTimePicker::make('reported_at'),
                Textarea::make('attachments')
                    ->columnSpanFull(),
            ]);
    }
}
