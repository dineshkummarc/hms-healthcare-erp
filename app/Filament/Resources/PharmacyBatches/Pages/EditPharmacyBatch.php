<?php

namespace App\Filament\Resources\PharmacyBatches\Pages;

use App\Filament\Resources\PharmacyBatches\PharmacyBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPharmacyBatch extends EditRecord
{
    protected static string $resource = PharmacyBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
