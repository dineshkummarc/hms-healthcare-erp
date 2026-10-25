<?php

namespace App\Filament\Resources\EmrRecords;

use App\Filament\Resources\EmrRecords\Pages\CreateEmrRecord;
use App\Filament\Resources\EmrRecords\Pages\EditEmrRecord;
use App\Filament\Resources\EmrRecords\Pages\ListEmrRecords;
use App\Filament\Resources\EmrRecords\Schemas\EmrRecordForm;
use App\Filament\Resources\EmrRecords\Tables\EmrRecordsTable;
use App\Models\EmrRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmrRecordResource extends Resource
{
    protected static ?string $model = EmrRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return EmrRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmrRecordsTable::configure($table);
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
            'index' => ListEmrRecords::route('/'),
            'create' => CreateEmrRecord::route('/create'),
            'edit' => EditEmrRecord::route('/{record}/edit'),
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
