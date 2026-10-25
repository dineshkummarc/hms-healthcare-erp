<?php

namespace App\Filament\Resources\PhysiotherapySessions\Pages;

use App\Filament\Resources\PhysiotherapySessions\PhysiotherapySessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPhysiotherapySession extends EditRecord
{
    protected static string $resource = PhysiotherapySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
