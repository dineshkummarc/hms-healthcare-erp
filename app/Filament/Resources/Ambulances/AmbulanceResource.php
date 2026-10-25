<?php

namespace App\Filament\Resources\Ambulances;

use App\Filament\Resources\Ambulances\Pages\CreateAmbulance;
use App\Filament\Resources\Ambulances\Pages\EditAmbulance;
use App\Filament\Resources\Ambulances\Pages\ListAmbulances;
use App\Filament\Resources\Ambulances\Schemas\AmbulanceForm;
use App\Filament\Resources\Ambulances\Tables\AmbulancesTable;
use App\Models\Ambulance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmbulanceResource extends Resource
{
    protected static ?string $model = Ambulance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AmbulanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AmbulancesTable::configure($table);
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
            'index' => ListAmbulances::route('/'),
            'create' => CreateAmbulance::route('/create'),
            'edit' => EditAmbulance::route('/{record}/edit'),
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
