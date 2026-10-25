<?php

namespace App\Filament\Resources\Medicines\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MedicineForm
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
                TextInput::make('generic_name')
                    ->required(),
                TextInput::make('category')
                    ->required()
                    ->default('tablet'),
                TextInput::make('dosage_form')
                    ->required()
                    ->default('oral'),
                TextInput::make('strength'),
                TextInput::make('manufacturer'),
                TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('cost_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('reorder_level')
                    ->required()
                    ->numeric()
                    ->default(10),
                Toggle::make('requires_prescription')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
