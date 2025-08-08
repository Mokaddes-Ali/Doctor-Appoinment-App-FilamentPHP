<?php

namespace App\Filament\Doctor\Resources\AppoinmentResource\Pages;

use App\Filament\Doctor\Resources\AppoinmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppoinment extends ViewRecord
{
    protected static string $resource = AppoinmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
