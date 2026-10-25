<?php

namespace App\Filament\Resources\RadiologyOrders\Pages;

use App\Filament\Resources\RadiologyOrders\RadiologyOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRadiologyOrders extends ListRecords
{
    protected static string $resource = RadiologyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
