<?php

namespace App\Filament\Resources\Surgeries;

use App\Filament\Resources\Surgeries\Pages\CreateSurgery;
use App\Filament\Resources\Surgeries\Pages\EditSurgery;
use App\Filament\Resources\Surgeries\Pages\ListSurgeries;
use App\Filament\Resources\Surgeries\Schemas\SurgeryForm;
use App\Filament\Resources\Surgeries\Tables\SurgeriesTable;
use App\Models\Surgery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurgeryResource extends Resource
{
    protected static ?string $model = Surgery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SurgeryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurgeriesTable::configure($table);
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
            'index' => ListSurgeries::route('/'),
            'create' => CreateSurgery::route('/create'),
            'edit' => EditSurgery::route('/{record}/edit'),
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
