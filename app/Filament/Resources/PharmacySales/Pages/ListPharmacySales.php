<?php

namespace App\Filament\Resources\PharmacySales\Pages;

use App\Filament\Resources\PharmacySales\PharmacySaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPharmacySales extends ListRecords
{
    protected static string $resource = PharmacySaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
