<?php

namespace App\Filament\Resources\DeliveryResource\RelationManagers;

use App\Models\Checkpoint;
use App\Models\DeliveryStatus;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
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
// use Illuminate\Database\Eloquent\Model; // tambahkan ini jika belum
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
                        // Select::make('checkpoint_id')
                        //     ->label('Checkpoints')
                        //     ->relationship('checkpoints', 'checkpoint_name')
                        //     ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->checkpoint_id)
                        //     // ->placeholder('Menunggu')
                        //     ->hidden(function ($get) {
                        //         $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;
                        //         return in_array($status, ['Telah Tiba', 'Sedang Dipickup', 'Menunggu Kurir']);
                        //     })
                        //     ->afterStateHydrated(function ($set, $get) {
                        //         $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;

                        //         if ($status === 'Telah Tiba' || $status == 'Sedang Dipickup') {
                        //             $set('checkpoint_id', null); // atau '' jika ingin string kosong
                        //         }
                        //     })
                        //     ->columnSpanFull()
                        //     ->reactive(),
                        Select::make('checkpoint_id')
                            ->label('Checkpoints')
                            ->relationship('checkpoints', 'checkpoint_name')
                            ->options(function () {
                                return Checkpoint::with('districts')
                                    ->get()
                                    ->mapWithKeys(function ($checkpoint) {
                                        $districtName = $checkpoint->districts->district_name ?? 'Select a district';
                                        return [$checkpoint->id => "{$districtName} - {$checkpoint->checkpoint_name}"];
                                    });
                            })
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->checkpoint_id)
                            // ->placeholder('Menunggu')
                            ->hidden(function ($get) {
                                $status = DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;
                                return in_array($status, ['Telah Tiba', 'Sedang Dipickup', 'Menunggu Kurir']);
                            })
                            ->afterStateHydrated(function ($set, $get) {
                                $status = DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;

                                if ($status === 'Telah Tiba' || $status == 'Sedang Dipickup') {
                                    $set('checkpoint_id', null); // atau '' jika ingin string kosong
                                }
                            }),
                        Select::make('users_id')
                            ->label('Driver')
                            ->relationship('users', 'name')
                            ->preload()
                            ->default(function ($livewire) {
                                // Default sederhana dari event terakhir atau owner
                                $lastUserId = $livewire->getOwnerRecord()?->deliveryEvents()->latest('created_at')->first()?->users_id;
                                return $lastUserId ?: $livewire->getOwnerRecord()?->users_id;
                            })
                            ->hidden(fn($get) => !in_array(
                                DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status,
                                ['Sedang Dipickup', 'Menunggu Kurir']
                            ))
                            ->reactive()
                            ->dehydrated(true)
                            ->afterStateUpdated(function ($set, $get, $state, $livewire, $component) {
                                $status = DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;

                                // Jika field menjadi hidden, set users_id dari record terakhir
                                if (!in_array($status, ['Sedang Dipickup', 'Menunggu Kurir'])) {
                                    $lastUserId = $livewire->getOwnerRecord()?->deliveryEvents()->latest('created_at')->first()?->users_id;
                                    if ($lastUserId) {
                                        $set('users_id', $lastUserId);
                                    }
                                }
                            })
                            // Tambahan: pastikan nilai di-set saat delivery_statuses_id berubah
                            ->live()
                            ->afterStateHydrated(function ($set, $get, $state, $livewire) {
                                $status = DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;

                                // Jika field hidden dan belum ada nilai, set dari record terakhir
                                if (!in_array($status, ['Sedang Dipickup', 'Menunggu Kurir']) && !$state) {
                                    $lastUserId = $livewire->getOwnerRecord()?->deliveryEvents()->latest('created_at')->first()?->users_id;
                                    if ($lastUserId) {
                                        $set('users_id', $lastUserId);
                                    }
                                }
                            }),
                        Hidden::make('users_id')
                            ->default(fn($livewire) => $livewire->getOwnerRecord()?->users_id),

                        //buat debug aja 

                        // Placeholder::make('debug_info')
                        //     ->content(function ($livewire, $get) {
                        //         $ownerUserId = $livewire->getOwnerRecord()?->users_id;
                        //         $currentUserId = $get('users_id');
                        //         $lastEventUserId = $livewire->getOwnerRecord()?->deliveryEvents()->latest('created_at')->first()?->users_id;

                        //         return "Owner User ID: {$ownerUserId}<br>Current User ID: {$currentUserId}<br>Last Event User ID: {$lastEventUserId}";
                        //     })
                        //     ->columnSpanFull(),
                        FileUpload::make('photos')
                            ->label('Photos')
                            ->image()
                            ->directory('delivery-photos')
                            // ->directory('qr_code') // Direktori penyimpanan
                            ->disk('public')
                            ->hidden(fn($get) => DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status !== 'Telah Tiba')
                            ->required()
                            ->default(function ($record) {
                                return $record->barcodes->image ?? null;
                            })
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
                        //     })
                        //     ->default(fn($livewire) => $livewire->getOwnerRecord()?->deliveryEvents->sortByDesc('created_at')->first()?->checkpoint_id)
                        //     // ->placeholder('Menunggu')
                        //     ->hidden(function ($get) {
                        //         $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;
                        //         return in_array($status, ['Telah Tiba', 'Sedang Dipickup', 'Menunggu Kurir']);
                        //     })
                        //     ->afterStateHydrated(function ($set, $get) {
                        //         $status = \App\Models\DeliveryStatus::find($get('delivery_statuses_id'))?->delivery_status;

                        //         if ($status === 'Telah Tiba' || $status == 'Sedang Dipickup') {
                        //             $set('checkpoint_id', null); // atau '' jika ingin string kosong
                        //         }
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
                TextColumn::make('users.name')
                    ->label('Handled By'),
                // ->sortable(false),
                TextColumn::make('deliveryStatus.delivery_status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'Sedang Dipickup' => 'warning',
                        'Sedang Dikirim' => 'warning',
                        'Telah Tiba' => 'success',
                        'Menunggu Kurir' => 'info',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')->label('Event Time')->dateTime(),
                ImageColumn::make('photos')
                    ->translateLabel()
                    ->label('Image')
                    ->disk('public')
                    ->height(50),
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
