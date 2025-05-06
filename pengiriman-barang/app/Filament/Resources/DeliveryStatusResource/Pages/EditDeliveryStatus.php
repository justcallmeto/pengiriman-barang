<?php

namespace App\Filament\Resources\DeliveryStatusResource\Pages;

use App\Filament\Resources\DeliveryStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryStatus extends EditRecord
{
    protected static string $resource = DeliveryStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
