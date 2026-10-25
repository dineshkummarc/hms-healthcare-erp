<?php

namespace App\Filament\Resources\PayrollRuns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PayrollRunForm
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
                TextInput::make('period_month')
                    ->required()
                    ->numeric(),
                TextInput::make('period_year')
                    ->required()
                    ->numeric(),
                TextInput::make('total_gross')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_deductions')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_net')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                TextInput::make('approved_by')
                    ->numeric(),
                DateTimePicker::make('paid_at'),
            ]);
    }
}
