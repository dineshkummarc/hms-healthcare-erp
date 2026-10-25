<?php

namespace App\Filament\Resources\RadiologyOrders\Pages;

use App\Filament\Resources\RadiologyOrders\RadiologyOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditRadiologyOrder extends EditRecord
{
    protected static string $resource = RadiologyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
