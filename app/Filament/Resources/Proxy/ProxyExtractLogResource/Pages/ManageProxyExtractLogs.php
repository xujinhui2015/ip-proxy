<?php

namespace App\Filament\Resources\Proxy\ProxyExtractLogResource\Pages;

use App\Filament\Resources\Proxy\ProxyExtractLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyExtractLogs extends ManageRecords
{
    protected static string $resource = ProxyExtractLogResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
