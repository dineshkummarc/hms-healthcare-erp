<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('hospital_id')
                    ->relationship('hospital', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                Toggle::make('is_main')
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('city'),
                TextInput::make('country')
                    ->required()
                    ->default('US'),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                TextInput::make('timezone')
                    ->required()
                    ->default('UTC'),
                TextInput::make('tax_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('invoice_prefix')
                    ->required()
                    ->default('INV-'),
                TextInput::make('appointment_prefix')
                    ->required()
                    ->default('APT-'),
                TextInput::make('mrn_prefix')
                    ->required()
                    ->default('MRN-'),
                Textarea::make('opening_hours')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('settings')
                    ->columnSpanFull(),
            ]);
    }
}
