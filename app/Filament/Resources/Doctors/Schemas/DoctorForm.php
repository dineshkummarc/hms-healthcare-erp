<?php

namespace App\Filament\Resources\Doctors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('branch_id')
                    ->relationship('branch', 'name'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('department_id')
                    ->relationship('department', 'name'),
                TextInput::make('specialization')
                    ->required(),
                TextInput::make('qualification')
                    ->required(),
                TextInput::make('license_number')
                    ->required(),
                TextInput::make('consultation_fee')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('follow_up_fee')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('room_number'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                Toggle::make('is_available')
                    ->required(),
            ]);
    }
}
