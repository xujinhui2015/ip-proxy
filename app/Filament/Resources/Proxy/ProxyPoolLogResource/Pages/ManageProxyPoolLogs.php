<?php

namespace App\Filament\Resources\Proxy\ProxyPoolLogResource\Pages;

use App\Filament\Resources\Proxy\ProxyPoolLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyPoolLogs extends ManageRecords
{
    protected static string $resource = ProxyPoolLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
