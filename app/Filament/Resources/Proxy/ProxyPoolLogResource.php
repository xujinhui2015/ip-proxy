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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('proxy_pool_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('request_url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('response_code')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('response_data')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proxy_pool_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('response_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProxyPoolLogs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
