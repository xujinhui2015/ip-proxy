<?php

namespace App\Filament\Resources\Proxy;

use App\Filament\Resources\Proxy\ProxyIpExtractLogResource\Pages;
use App\Filament\Resources\Proxy\ProxyIpExtractLogResource\RelationManagers;
use App\Models\Proxy\ProxyIpExtractLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProxyIpExtractLogResource extends Resource
{
    protected static ?string $model = ProxyIpExtractLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '账号提取日志';

    protected static ?string $navigationGroup = 'IP提取管理';

    protected static ?string $modelLabel = '账号提取日志';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('proxy_ip_extract_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('extract_relation_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('extract_type')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ip_address')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('from_ip_address')
                    ->maxLength(45),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proxy_ip_extract_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('extract_relation_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('extract_type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('from_ip_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProxyIpExtractLogs::route('/'),
        ];
    }
}
