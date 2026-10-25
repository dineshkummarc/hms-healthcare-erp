<?php

namespace App\Filament\Resources\Wards\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WardForm
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
                TextInput::make('name')
                    ->required(),
                TextInput::make('code'),
                TextInput::make('type')
                    ->required()
                    ->default('general'),
                TextInput::make('floor'),
                TextInput::make('capacity')
                    ->required()
                    ->numeric()
                    ->default(10),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
