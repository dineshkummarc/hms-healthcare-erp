<?php

namespace App\Filament\Resources\RadiologyOrders;

use App\Filament\Resources\RadiologyOrders\Pages\CreateRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Pages\EditRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Pages\ListRadiologyOrders;
use App\Filament\Resources\RadiologyOrders\Schemas\RadiologyOrderForm;
use App\Filament\Resources\RadiologyOrders\Tables\RadiologyOrdersTable;
use App\Models\RadiologyOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RadiologyOrderResource extends Resource
{
    protected static ?string $model = RadiologyOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RadiologyOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RadiologyOrdersTable::configure($table);
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
            'index' => ListRadiologyOrders::route('/'),
            'create' => CreateRadiologyOrder::route('/create'),
            'edit' => EditRadiologyOrder::route('/{record}/edit'),
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
