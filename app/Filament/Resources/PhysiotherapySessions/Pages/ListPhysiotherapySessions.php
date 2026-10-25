<?php

namespace App\Filament\Resources\PhysiotherapySessions\Pages;

use App\Filament\Resources\PhysiotherapySessions\PhysiotherapySessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPhysiotherapySessions extends ListRecords
{
    protected static string $resource = PhysiotherapySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
