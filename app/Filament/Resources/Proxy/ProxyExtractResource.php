<?php

namespace App\Filament\Resources\Proxy;

use App\Enums\Proxy\ProxyExtractPriorityEnum;
use App\Filament\Resources\Proxy\ProxyExtractResource\Pages;
use App\Models\Proxy\ProxyExtract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProxyExtractResource extends Resource
{
    protected static ?string $model = ProxyExtract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '账号管理';

    protected static ?string $navigationGroup = 'IP提取管理';

    protected static ?string $modelLabel = '账号';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('extract_priority')
                    ->options(ProxyExtractPriorityEnum::options())
                    ->default(ProxyExtractPriorityEnum::Pool->value)
                    ->columnSpanFull()
                    ->required()
                    ->label('获取优先级'),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('备注'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('remark')
                    ->searchable()
                    ->label('备注'),
                Tables\Columns\TextColumn::make('extract_priority')
                    ->formatStateUsing(fn(int $state): string => ProxyExtractPriorityEnum::tryFrom($state)->text())
                    ->label('代理优先级'),
                Tables\Columns\ToggleColumn::make('is_usable')
                    ->label('是否启用'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('删除时间'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('创建时间'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('更新时间'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\TextInput::make('extract_key')
                            ->formatStateUsing(function (string $state):string {
                                return env('APP_URL') . '/api/proxy/' . $state;
                            })
                            ->label('代理地址'),
                    ])->label('获取代理IP地址'),
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
            'index' => Pages\ManageProxyExtracts::route('/'),
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
