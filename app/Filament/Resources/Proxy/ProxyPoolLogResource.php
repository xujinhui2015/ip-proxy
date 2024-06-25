<?php

namespace App\Filament\Resources\Proxy;

use App\Filament\Resources\Proxy\ProxyPoolLogResource\Pages;
use App\Filament\Resources\Proxy\ProxyPoolLogResource\RelationManagers;
use App\Models\Proxy\ProxyPoolLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProxyPoolLogResource extends Resource
{
    protected static ?string $model = ProxyPoolLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '代理池请求日志';

    protected static ?string $navigationGroup = '代理池';

    protected static ?string $modelLabel = '代理池请求日志';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pool.pool_name')
                    ->searchable()
                    ->label('代理池名称'),
                Tables\Columns\TextColumn::make('response_code')
                    ->label('响应状态码'),
                Tables\Columns\TextColumn::make('response_data')
                    ->label('响应数据'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('创建时间'),
            ])
            ->filters([
                //
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProxyPoolLogs::route('/'),
        ];
    }
}
