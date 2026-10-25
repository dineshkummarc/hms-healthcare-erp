<?php

namespace App\Filament\Resources\ModuleActivations;

use App\Filament\Resources\ModuleActivations\Pages\CreateModuleActivation;
use App\Filament\Resources\ModuleActivations\Pages\EditModuleActivation;
use App\Filament\Resources\ModuleActivations\Pages\ListModuleActivations;
use App\Filament\Resources\ModuleActivations\Schemas\ModuleActivationForm;
use App\Filament\Resources\ModuleActivations\Tables\ModuleActivationsTable;
use App\Models\ModuleActivation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ModuleActivationResource extends Resource
{
    protected static ?string $model = ModuleActivation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ModuleActivationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModuleActivationsTable::configure($table);
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
            'index' => ListModuleActivations::route('/'),
            'create' => CreateModuleActivation::route('/create'),
            'edit' => EditModuleActivation::route('/{record}/edit'),
        ];
    }
}
