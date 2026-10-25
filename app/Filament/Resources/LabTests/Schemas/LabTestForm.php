<?php

namespace App\Filament\Resources\LabTests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LabTestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('category')
                    ->required()
                    ->default('haematology'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('sample_type')
                    ->required()
                    ->default('blood'),
                TextInput::make('normal_range'),
                TextInput::make('unit'),
                TextInput::make('turnaround_hours')
                    ->required()
                    ->numeric()
                    ->default(24),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
