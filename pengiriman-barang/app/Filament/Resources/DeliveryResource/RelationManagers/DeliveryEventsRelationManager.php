<?php

namespace App\Filament\Resources\DeliveryResource\RelationManagers;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model; // tambahkan ini jika belum
use Illuminate\Support\Facades\Log;

class DeliveryEventsRelationManager extends RelationManager
{
    protected static ?string $title = 'Delivery History';
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
                Section::make('Delivery Events')
                    ->schema([

                        Select::make('delivery_statuses_id')
                            ->relationship('deliveryStatus', 'delivery_status')
                            ->preload()
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->delivery_statuses_id)
                            ->columnSpanFull(),
                        Select::make('checkpoint_id')
                            ->label('Checkpoints')
                            ->relationship('checkpoints', 'checkpoint_name')
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->checkpoint_id)
                            ->columnSpanFull(),
                        // Select::make('users_id')
                        //     ->label('Driver')
                        //     ->relationship('users', 'name')
                        //     ->preload()
                        //     ->formatStateUsing(fn($state, $record) => $record?->users_id),
                        Select::make('users_id')
                            ->label('Driver')
                            ->relationship('users', 'name')
                            ->preload()
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->users_id)
                            ->disabled()
                            ->columnSpanFull(),
                        Placeholder::make('note')
                            ->content('📌 Setelah pengiriman dibuat, data tidak dapat diubah.'),
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
                    ]),

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
    // public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    // {
    //     return Filament::auth()->user()->hasRole('super_admin') || $ownerRecord->users_id === Filament::auth()->id();
    //     // return true;
    // }

    // public static function canUpdate(Model $ownerRecord): bool
    // {
    //         Log::info('Checking if user can edit', [
    //     'user_id' => auth()->id(),
    //     'record_owner' => $record->users_id,
    // ]);
    //     return auth()->user()->hasRole('super_admin') || $ownerRecord->users_id === auth()->id();
    // }

    // public function canCreateRecord(Model $owerRecord)

    // {
    //     return true;
    // }

    // public function canEdit(Model $record)
    // {
    //     return true; // Allow all roles to edit
    // }
    // public static function canView(Model $record): bool
    // {
    //     return auth()->user()->hasRole('super_admin') ||
    //         $record->users_id === auth()->id();
    // }
}
