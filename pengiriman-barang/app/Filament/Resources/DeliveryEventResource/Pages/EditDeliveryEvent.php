<?php

namespace App\Filament\Resources\DeliveryEventResource\Pages;

use App\Filament\Resources\DeliveryEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryEvent extends EditRecord
{
    protected static string $resource = DeliveryEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
