<?php

namespace App\Filament\Resources\Beds\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BedForm
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
                Select::make('ward_id')
                    ->relationship('ward', 'name')
                    ->required(),
                Select::make('room_id')
                    ->relationship('room', 'id'),
                TextInput::make('bed_number')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('standard'),
                TextInput::make('daily_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->default('available'),
            ]);
    }
}
