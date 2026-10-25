<?php

namespace App\Filament\Resources\PhysiotherapySessions;

use App\Filament\Resources\PhysiotherapySessions\Pages\CreatePhysiotherapySession;
use App\Filament\Resources\PhysiotherapySessions\Pages\EditPhysiotherapySession;
use App\Filament\Resources\PhysiotherapySessions\Pages\ListPhysiotherapySessions;
use App\Filament\Resources\PhysiotherapySessions\Schemas\PhysiotherapySessionForm;
use App\Filament\Resources\PhysiotherapySessions\Tables\PhysiotherapySessionsTable;
use App\Models\PhysiotherapySession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhysiotherapySessionResource extends Resource
{
    protected static ?string $model = PhysiotherapySession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PhysiotherapySessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PhysiotherapySessionsTable::configure($table);
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
            'index' => ListPhysiotherapySessions::route('/'),
            'create' => CreatePhysiotherapySession::route('/create'),
            'edit' => EditPhysiotherapySession::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
