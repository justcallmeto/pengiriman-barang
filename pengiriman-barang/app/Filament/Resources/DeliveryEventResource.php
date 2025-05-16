<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryEventResource\Pages;
use App\Models\DeliveryEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryEventResource extends Resource
{
    protected static ?string $model = DeliveryEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function canCreate(): bool
    {
        return auth()->user()->hasRole(['admin', 'super_admin', 'user']);
    }
    
    // Perbaikan disini: Menggunakan Model sebagai tipe parameter dan menambahkan return type bool
    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasRole(['admin', 'super_admin', 'user']);
    }
    
    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasRole(['admin', 'super_admin','user']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('delivery_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('checkpoint_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('delivery_statuses_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('users_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('photos')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('delivery_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('checkpoint_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_statuses_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('photos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListDeliveryEvents::route('/'),
            'create' => Pages\CreateDeliveryEvent::route('/create'),
            'edit' => Pages\EditDeliveryEvent::route('/{record}/edit'),
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
