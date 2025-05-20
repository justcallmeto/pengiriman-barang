<?php

namespace App\Filament\Resources\DeliveryResource\RelationManagers;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\ImageColumn;
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
                            ->columnSpanFull()
                            ->reactive(),
                        Select::make('checkpoint_id')
                            ->label('Checkpoints')
                            ->relationship('checkpoints', 'checkpoint_name')
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->checkpoint_id)
                            // ->placeholder('Menunggu')
                            ->hidden(function ($get) {
                                $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;
                                return in_array($status, ['Telah Tiba', 'Sedang Dipickup', 'Menunggu Persetujuan']);
                            })
                            ->afterStateHydrated(function ($set, $get) {
                                $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;

                                if ($status === 'Telah Tiba' || $status == 'Sedang Dipickup') {
                                    $set('checkpoint_id', null); // atau '' jika ingin string kosong
                                }
                            })
                            ->columnSpanFull()
                            ->reactive(),
                        Select::make('users_id')
                            ->label('Driver')
                            ->relationship('users', 'name')
                            ->preload()
                            ->formatStateUsing(fn($state, $record) => $record?->users_id)
                            ->hidden(fn($get) => !in_array(
                                \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status,
                                ['Sedang Dipickup', 'Menunggu Persetujuan']
                            ))
                            ->afterStateHydrated(function ($set, $get, $livewire) {
                                $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;
                        
                                // Jika hidden (berarti status bukan 'Sedang Dipickup' atau 'Menunggu Persetujuan')
                                if (in_array($status, ['Sedang Dipickup', 'Menunggu Persetujuan'])) {
                                    // Ambil record terakhir dari relasi deliveryEvents (atau sesuaikan dengan relasi/logic milikmu)
                                    $lastUserId = $livewire->getOwnerRecord()?->deliveryEvents()->latest('created_at')->first()?->users_id;
                                    
                                    // Jika ada, set sebagai nilai default
                                    if ($lastUserId) {
                                        $set('users_id', $lastUserId);
                                    }
                                }
                            }),
                        FileUpload::make('photos')
                            ->label('Photos')
                            ->image()
                            ->directory('delivery-photos')
                            ->hidden(fn($get) => \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status !== 'Telah Tiba')
                            ->required()
                            ->columnSpanFull(),
                        // Select::make('users_id')
                        //     ->label('Driver')
                        //     ->relationship('users', 'name')
                        //     ->preload()
                        //     ->formatStateUsing(fn($state, $record) => $record?->users_id),
                        // Select::make('users_id')
                        //     ->label('Driver')
                        //     ->relationship('users', 'name')
                        //     ->preload()
                        //     ->default(fn($livewire) => $livewire->getOwnerRecord()?->users_id)
                        //     ->disabled()
                        //     ->dehydrated(true)
                        //     ->columnSpanFull(),
                        Forms\Components\Hidden::make('users_id')
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->users_id),
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
                TextColumn::make('users_id')->label('User ID'),
                TextColumn::make('checkpoints.checkpoint_name')->label('Checkpoint'),
                TextColumn::make('users.name')->label('Handled By'),
                TextColumn::make('deliveryStatus.delivery_status')
                    ->badge()
                    ->color(fn(String $state): string => match ($state) {
                        'Sedang Dipickup' => 'warning',
                        'Sedang Dikirim' => 'warning',
                        'Telah Tiba' => 'success',
                        default => 'secondary,'
                    }),
                TextColumn::make('created_at')->label('Event Time')->dateTime(),
                ImageColumn::make('image')->translateLabel(),
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
