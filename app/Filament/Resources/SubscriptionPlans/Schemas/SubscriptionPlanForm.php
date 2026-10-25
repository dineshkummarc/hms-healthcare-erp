<?php

namespace App\Filament\Resources\SubscriptionPlans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SubscriptionPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price_monthly')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price_yearly')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('max_branches')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('max_staff')
                    ->required()
                    ->numeric()
                    ->default(10),
                TextInput::make('max_patients')
                    ->required()
                    ->numeric()
                    ->default(500),
                TextInput::make('storage_quota_mb')
                    ->required()
                    ->numeric()
                    ->default(5120),
                Textarea::make('features')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
