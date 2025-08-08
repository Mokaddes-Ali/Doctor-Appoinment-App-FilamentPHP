<?php

namespace App\Filament\Doctor\Resources\AppoinmentResource\Pages;

use App\Filament\Doctor\Resources\AppoinmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppoinment extends EditRecord
{
    protected static string $resource = AppoinmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
