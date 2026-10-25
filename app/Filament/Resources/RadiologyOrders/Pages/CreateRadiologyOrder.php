<?php

namespace App\Filament\Resources\RadiologyOrders\Pages;

use App\Filament\Resources\RadiologyOrders\RadiologyOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRadiologyOrder extends CreateRecord
{
    protected static string $resource = RadiologyOrderResource::class;
}
