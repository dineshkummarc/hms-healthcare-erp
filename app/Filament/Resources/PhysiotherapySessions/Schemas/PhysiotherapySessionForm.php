<?php

namespace App\Filament\Resources\PhysiotherapySessions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PhysiotherapySessionForm
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
                Select::make('therapist_id')
                    ->relationship('therapist', 'name')
                    ->required(),
                DatePicker::make('session_date')
                    ->required(),
                Textarea::make('diagnosis')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('treatment_protocol')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('progress_notes')
                    ->columnSpanFull(),
                TextInput::make('pain_score_before')
                    ->numeric(),
                TextInput::make('pain_score_after')
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('completed'),
            ]);
    }
}
