<?php

namespace App\Filament\Resources\DentalRecords\Pages;

use App\Filament\Resources\DentalRecords\DentalRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDentalRecord extends EditRecord
{
    protected static string $resource = DentalRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
