<?php

namespace App\Filament\Resources\DeliveryStatusResource\Pages;

use App\Filament\Resources\DeliveryStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryStatuses extends ListRecords
{
    protected static string $resource = DeliveryStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
