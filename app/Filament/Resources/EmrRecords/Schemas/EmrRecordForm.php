<?php

namespace App\Filament\Resources\EmrRecords\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmrRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('patient_id')
                    ->relationship('patient', 'id')
                    ->required(),
                Select::make('encounter_id')
                    ->relationship('encounter', 'id'),
                TextInput::make('recorded_by')
                    ->required()
                    ->numeric(),
                TextInput::make('category')
                    ->required()
                    ->default('general'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_confidential')
                    ->required(),
                Textarea::make('attachments')
                    ->columnSpanFull(),
            ]);
    }
}
