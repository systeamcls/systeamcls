<?php

namespace App\Filament\Resources\TenantRentalResource\Pages;

use App\Filament\Resources\TenantRentalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTenantRental extends ViewRecord
{
    protected static string $resource = TenantRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}