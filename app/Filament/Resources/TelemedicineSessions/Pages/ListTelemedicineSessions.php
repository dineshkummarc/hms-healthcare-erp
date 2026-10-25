<?php

namespace App\Filament\Resources\TelemedicineSessions\Pages;

use App\Filament\Resources\TelemedicineSessions\TelemedicineSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTelemedicineSessions extends ListRecords
{
    protected static string $resource = TelemedicineSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
