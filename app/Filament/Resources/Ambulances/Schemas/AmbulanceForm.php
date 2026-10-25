<?php

namespace App\Filament\Resources\Ambulances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AmbulanceForm
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
                TextInput::make('vehicle_number')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('basic_life_support'),
                TextInput::make('driver_name')
                    ->required(),
                TextInput::make('driver_phone')
                    ->tel()
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('available'),
            ]);
    }
}
