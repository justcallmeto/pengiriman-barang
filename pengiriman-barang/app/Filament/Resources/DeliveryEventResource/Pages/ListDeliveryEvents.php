<?php

namespace App\Filament\Resources\DeliveryEventResource\Pages;

use App\Filament\Resources\DeliveryEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryEvents extends ListRecords
{
    protected static string $resource = DeliveryEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
