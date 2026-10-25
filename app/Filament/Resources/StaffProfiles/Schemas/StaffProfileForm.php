<?php

namespace App\Filament\Resources\StaffProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StaffProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('branch_id')
                    ->relationship('branch', 'name'),
                Select::make('department_id')
                    ->relationship('department', 'name'),
                TextInput::make('employee_id')
                    ->required(),
                TextInput::make('designation')
                    ->required(),
                TextInput::make('specialization'),
                TextInput::make('qualification'),
                TextInput::make('license_number'),
                DatePicker::make('joining_date'),
                TextInput::make('employment_type')
                    ->required()
                    ->default('full_time'),
                TextInput::make('salary')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('emergency_contact'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                Textarea::make('credentials')
                    ->columnSpanFull(),
            ]);
    }
}
