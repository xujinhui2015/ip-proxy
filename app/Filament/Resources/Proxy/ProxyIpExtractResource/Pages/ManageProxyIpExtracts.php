<?php

namespace App\Filament\Resources\Proxy\ProxyIpExtractResource\Pages;

use App\Filament\Resources\Proxy\ProxyIpExtractResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyIpExtracts extends ManageRecords
{
    protected static string $resource = ProxyIpExtractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
