<?php

namespace App\Filament\Resources\DentalRecords\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DentalRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->required(),
                Select::make('doctor_id')
                    ->relationship('doctor', 'id')
                    ->required(),
                TextInput::make('tooth_number')
                    ->required()
                    ->numeric(),
                TextInput::make('procedure_name')
                    ->required(),
                Textarea::make('findings')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('treatment_plan')
                    ->columnSpanFull(),
                TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('status')
                    ->required()
                    ->default('planned'),
            ]);
    }
}
