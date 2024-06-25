<?php

namespace App\Filament\Resources\Proxy\ProxyIpResource\Pages;

use App\Filament\Resources\Proxy\ProxyIpResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyIps extends ManageRecords
{
    protected static string $resource = ProxyIpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
