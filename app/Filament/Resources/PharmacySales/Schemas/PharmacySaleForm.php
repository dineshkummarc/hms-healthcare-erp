<?php

namespace App\Filament\Resources\PharmacySales\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PharmacySaleForm
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
                    ->relationship('patient', 'id'),
                Select::make('prescription_id')
                    ->relationship('prescription', 'id'),
                Select::make('pharmacist_id')
                    ->relationship('pharmacist', 'name')
                    ->required(),
                TextInput::make('sale_number')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('tax')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('payment_status')
                    ->required()
                    ->default('paid'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
