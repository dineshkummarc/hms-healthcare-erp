<?php

namespace App\Filament\Resources\EmrRecords\Pages;

use App\Filament\Resources\EmrRecords\EmrRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditEmrRecord extends EditRecord
{
    protected static string $resource = EmrRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
