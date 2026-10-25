<?php

namespace App\Filament\Resources\ModuleActivations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ModuleActivationForm
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
                TextInput::make('module_key')
                    ->required(),
                Toggle::make('is_enabled')
                    ->required(),
                Textarea::make('settings')
                    ->columnSpanFull(),
                DateTimePicker::make('activated_at'),
            ]);
    }
}
