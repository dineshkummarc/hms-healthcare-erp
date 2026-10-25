<?php

namespace App\Filament\Resources\TelemedicineSessions\Pages;

use App\Filament\Resources\TelemedicineSessions\TelemedicineSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTelemedicineSession extends EditRecord
{
    protected static string $resource = TelemedicineSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
