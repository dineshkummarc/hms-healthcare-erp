<?php

namespace App\Filament\Resources\PharmacySales\Pages;

use App\Filament\Resources\PharmacySales\PharmacySaleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPharmacySale extends EditRecord
{
    protected static string $resource = PharmacySaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
