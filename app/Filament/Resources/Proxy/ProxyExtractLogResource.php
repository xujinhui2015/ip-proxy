<?php

namespace App\Filament\Resources\Proxy;

use App\Enums\Proxy\ProxyExtractPriorityEnum;
use App\Filament\Resources\Proxy\ProxyExtractLogResource\Pages;
use App\Models\Proxy\ProxyExtractLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProxyExtractLogResource extends Resource
{
    protected static ?string $model = ProxyExtractLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '账号提取日志';

    protected static ?string $navigationGroup = 'IP提取管理';

    protected static ?string $modelLabel = '账号提取日志';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('extract.remark')
                    ->searchable()
                    ->label('账号备注'),
                Tables\Columns\TextColumn::make('extract_type')
                    ->formatStateUsing(fn(int $state): string => ProxyExtractPriorityEnum::tryFrom($state)->text())
                    ->label('提取类型'),
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable()
                    ->label('提取ip'),
                Tables\Columns\TextColumn::make('from_ip_address')
                    ->searchable()
                    ->label('客户端ip'),
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
            'index' => Pages\ManageProxyExtractLogs::route('/'),
        ];
    }
}
