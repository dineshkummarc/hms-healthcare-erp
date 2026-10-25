<?php

namespace App\Filament\Resources\PharmacyBatches;

use App\Filament\Resources\PharmacyBatches\Pages\CreatePharmacyBatch;
use App\Filament\Resources\PharmacyBatches\Pages\EditPharmacyBatch;
use App\Filament\Resources\PharmacyBatches\Pages\ListPharmacyBatches;
use App\Filament\Resources\PharmacyBatches\Schemas\PharmacyBatchForm;
use App\Filament\Resources\PharmacyBatches\Tables\PharmacyBatchesTable;
use App\Models\PharmacyBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PharmacyBatchResource extends Resource
{
    protected static ?string $model = PharmacyBatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PharmacyBatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PharmacyBatchesTable::configure($table);
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
            'index' => ListPharmacyBatches::route('/'),
            'create' => CreatePharmacyBatch::route('/create'),
            'edit' => EditPharmacyBatch::route('/{record}/edit'),
        ];
    }
}
