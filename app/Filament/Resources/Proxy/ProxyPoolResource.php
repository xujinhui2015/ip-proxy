<?php

namespace App\Filament\Resources\Proxy;

use App\Filament\Resources\Proxy\ProxyPoolResource\Pages;
use App\Filament\Resources\Proxy\ProxyPoolResource\RelationManagers;
use App\Models\Proxy\ProxyPool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProxyPoolResource extends Resource
{
    protected static ?string $model = ProxyPool::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '代理池管理';

    protected static ?string $navigationGroup = '代理池';

    protected static ?string $modelLabel = '代理池管理';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pool_name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('代理池名称'),
                Forms\Components\TextInput::make('request_url')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('请求代理地址'),
                Forms\Components\TextInput::make('remark')
                    ->columnSpanFull()
                    ->maxLength(255)
                    ->label('备注'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pool_name')
                    ->searchable()
                    ->label('代理池名称'),
                Tables\Columns\ToggleColumn::make('is_usable')
                    ->label('是否启用'),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable()
                    ->label('备注'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('删除时间'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('创建时间'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('更新时间'),
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
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProxyPools::route('/'),
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
