<?php

namespace App\Filament\Resources\PharmacySales;

use App\Filament\Resources\PharmacySales\Pages\CreatePharmacySale;
use App\Filament\Resources\PharmacySales\Pages\EditPharmacySale;
use App\Filament\Resources\PharmacySales\Pages\ListPharmacySales;
use App\Filament\Resources\PharmacySales\Schemas\PharmacySaleForm;
use App\Filament\Resources\PharmacySales\Tables\PharmacySalesTable;
use App\Models\PharmacySale;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PharmacySaleResource extends Resource
{
    protected static ?string $model = PharmacySale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PharmacySaleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PharmacySalesTable::configure($table);
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
            'index' => ListPharmacySales::route('/'),
            'create' => CreatePharmacySale::route('/create'),
            'edit' => EditPharmacySale::route('/{record}/edit'),
        ];
    }
}
