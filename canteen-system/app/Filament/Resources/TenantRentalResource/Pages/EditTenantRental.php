<?php

namespace App\Filament\Resources\TenantRentalResource\Pages;

use App\Filament\Resources\TenantRentalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenantRental extends EditRecord
{
    protected static string $resource = TenantRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}