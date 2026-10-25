<?php

namespace App\Filament\Resources\ModuleActivations\Pages;

use App\Filament\Resources\ModuleActivations\ModuleActivationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModuleActivation extends EditRecord
{
    protected static string $resource = ModuleActivationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
