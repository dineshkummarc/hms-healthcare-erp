<?php

namespace App\Filament\Resources\DentalRecords\Pages;

use App\Filament\Resources\DentalRecords\DentalRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDentalRecords extends ListRecords
{
    protected static string $resource = DentalRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
