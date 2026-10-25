<?php

namespace App\Filament\Resources\PharmacyBatches\Pages;

use App\Filament\Resources\PharmacyBatches\PharmacyBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPharmacyBatches extends ListRecords
{
    protected static string $resource = PharmacyBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
