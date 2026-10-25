<?php

namespace App\Filament\Resources\InsuranceClaims\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InsuranceClaimForm
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
                Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->required(),
                Select::make('invoice_id')
                    ->relationship('invoice', 'id')
                    ->required(),
                TextInput::make('claim_number')
                    ->required(),
                TextInput::make('policy_number')
                    ->required(),
                TextInput::make('amount_claimed')
                    ->required()
                    ->numeric(),
                TextInput::make('amount_approved')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->default('submitted'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('settled_at'),
            ]);
    }
}
