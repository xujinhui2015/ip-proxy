<?php

namespace App\Filament\Resources\Proxy\ProxyIpExtractLogResource\Pages;

use App\Filament\Resources\Proxy\ProxyIpExtractLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyIpExtractLogs extends ManageRecords
{
    protected static string $resource = ProxyIpExtractLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
