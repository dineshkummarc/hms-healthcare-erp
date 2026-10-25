<?php

namespace App\Filament\Resources\DentalRecords;

use App\Filament\Resources\DentalRecords\Pages\CreateDentalRecord;
use App\Filament\Resources\DentalRecords\Pages\EditDentalRecord;
use App\Filament\Resources\DentalRecords\Pages\ListDentalRecords;
use App\Filament\Resources\DentalRecords\Schemas\DentalRecordForm;
use App\Filament\Resources\DentalRecords\Tables\DentalRecordsTable;
use App\Models\DentalRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DentalRecordResource extends Resource
{
    protected static ?string $model = DentalRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DentalRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DentalRecordsTable::configure($table);
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
            'index' => ListDentalRecords::route('/'),
            'create' => CreateDentalRecord::route('/create'),
            'edit' => EditDentalRecord::route('/{record}/edit'),
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
