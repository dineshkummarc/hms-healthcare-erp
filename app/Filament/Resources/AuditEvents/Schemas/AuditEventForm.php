<?php

namespace App\Filament\Resources\AuditEvents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AuditEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name'),
                Select::make('branch_id')
                    ->relationship('branch', 'name'),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('event_type')
                    ->required(),
                TextInput::make('auditable_type'),
                TextInput::make('auditable_id')
                    ->numeric(),
                Textarea::make('old_values')
                    ->columnSpanFull(),
                Textarea::make('new_values')
                    ->columnSpanFull(),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                Textarea::make('justification')
                    ->columnSpanFull(),
            ]);
    }
}
