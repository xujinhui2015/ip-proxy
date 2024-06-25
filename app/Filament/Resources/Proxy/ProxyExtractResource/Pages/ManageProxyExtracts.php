<?php

namespace App\Filament\Resources\Proxy\ProxyExtractResource\Pages;

use App\Filament\Resources\Proxy\ProxyExtractResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProxyExtracts extends ManageRecords
{
    protected static string $resource = ProxyExtractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
