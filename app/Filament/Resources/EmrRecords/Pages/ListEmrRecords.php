<?php

namespace App\Filament\Resources\EmrRecords\Pages;

use App\Filament\Resources\EmrRecords\EmrRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmrRecords extends ListRecords
{
    protected static string $resource = EmrRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
