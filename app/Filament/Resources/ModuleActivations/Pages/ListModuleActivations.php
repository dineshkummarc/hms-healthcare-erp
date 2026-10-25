<?php

namespace App\Filament\Resources\ModuleActivations\Pages;

use App\Filament\Resources\ModuleActivations\ModuleActivationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModuleActivations extends ListRecords
{
    protected static string $resource = ModuleActivationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
