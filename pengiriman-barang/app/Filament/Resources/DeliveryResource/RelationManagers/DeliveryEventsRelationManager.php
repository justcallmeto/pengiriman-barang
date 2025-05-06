<?php

namespace App\Filament\Resources\DeliveryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'deliveryEvents';
    protected static ?string $recordTitleAttribute = 'id';
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['deliveryStatus', 'checkpoints', 'users']);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('id')
                //     ->required()
                //     ->maxLength(255),
                Select::make('delivery_statuses_id')
                ->relationship('deliveryStatus', 'delivery_status')
                ->preload(),
                Select::make('checkpoint_id')
                ->label('Checkpoints')
                ->relationship('checkpoints', 'checkpoint_name'),
                Select::make('users_id')
                ->label('Driver')
                ->relationship('users', 'name')
                ->preload(),
                // Select::make('checkpoints_id') // pastikan field-nya sesuai kolom foreign key
                //     ->label('District')
                //     ->options(function () {
                //         return \App\Models\Checkpoint::with('districts')
                //             ->get()
                //             ->mapWithKeys(function ($checkpoint) {
                //                 $districtName = $checkpoint->districts->district_name ?? 'Select a district';
                //                 return [$checkpoint->id => "{$districtName} - {$checkpoint->checkpoint_name}"];
                //             });
                //     }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('checkpoints.checkpoint_name')->label('Checkpoint'),
                TextColumn::make('users.name')->label('Handled By'),
                TextColumn::make('deliveryStatus.delivery_status'),
                TextColumn::make('created_at')->label('Event Time')->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
