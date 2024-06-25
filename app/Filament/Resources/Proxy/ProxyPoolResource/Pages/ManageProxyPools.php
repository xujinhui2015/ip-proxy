<?php

namespace App\Filament\Resources\Proxy\ProxyPoolResource\Pages;

use App\Filament\Resources\Proxy\ProxyPoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyPools extends ManageRecords
{
    protected static string $resource = ProxyPoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
