<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryStatusResource\Pages;
use App\Filament\Resources\DeliveryStatusResource\RelationManagers;
use App\Models\DeliveryStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryStatusResource extends Resource
{
    protected static ?string $model = DeliveryStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Deliveries';
    protected static ?string $activeNavigationIcon = 'heroicon-o-bell';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('delivery_status')
                ->required()
                ->maxLength(255)
                ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('delivery_status')
                ->label(__('Delivery Status'))
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryStatuses::route('/'),
            'create' => Pages\CreateDeliveryStatus::route('/create'),
            'edit' => Pages\EditDeliveryStatus::route('/{record}/edit'),
        ];
    }

    // public static function getLabel(): ?string
    // {
    //     $locale = app()->getLocale();
    //     if($locale == 'id')
    //     {
    //         return 'Status Pengiriman';
    //     }
    // }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
