<?php

namespace App\Filament\Resources\TelemedicineSessions;

use App\Filament\Resources\TelemedicineSessions\Pages\CreateTelemedicineSession;
use App\Filament\Resources\TelemedicineSessions\Pages\EditTelemedicineSession;
use App\Filament\Resources\TelemedicineSessions\Pages\ListTelemedicineSessions;
use App\Filament\Resources\TelemedicineSessions\Schemas\TelemedicineSessionForm;
use App\Filament\Resources\TelemedicineSessions\Tables\TelemedicineSessionsTable;
use App\Models\TelemedicineSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TelemedicineSessionResource extends Resource
{
    protected static ?string $model = TelemedicineSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TelemedicineSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TelemedicineSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTelemedicineSessions::route('/'),
            'create' => CreateTelemedicineSession::route('/create'),
            'edit' => EditTelemedicineSession::route('/{record}/edit'),
        ];
    }
}
