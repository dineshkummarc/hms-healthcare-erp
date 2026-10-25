<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('business_type')
                    ->required()
                    ->default('hospital'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('website')
                    ->url(),
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
                TextInput::make('logo_url')
                    ->url(),
                TextInput::make('favicon_url')
                    ->url(),
                TextInput::make('primary_color')
                    ->required()
                    ->default('#0284c7'),
                TextInput::make('secondary_color')
                    ->required()
                    ->default('#0f172a'),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('settings')
                    ->columnSpanFull(),
            ]);
    }
}
