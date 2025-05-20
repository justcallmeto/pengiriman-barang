<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Filament\Resources\DeliveryResource\RelationManagers\DeliveryEventsRelationManager;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Delivery;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryResource extends Resource
{
    protected static ?string $title = 'Delivery';
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Deliveries';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Deliveries')
                    ->description(__('delivery.group-desc'))
                    ->schema([
                        TextInput::make('delivery_code')
                            ->label(__('delivery.table.delivery_code'))
                            ->default(function () {
                                $last = Delivery::latest('id')->first();
                                $lastNumber = 1;

                                if ($last && preg_match('/TJ-(\d+)/', $last->delivery_code, $matches)) {
                                    $lastNumber = (int) $matches[1] + 1;
                                    // dd(__('delivery.table.delivery_code'), app()->getLocale());
                                }

                                return 'TJ-' . str_pad($lastNumber, 13, '0', STR_PAD_LEFT);
                            })
                            ->disabled(fn($livewire) => filled($livewire->record))
                            ->dehydrated(),
                        TextInput::make('recipient_name')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255)
                            ->disabled(fn($livewire) => filled($livewire->record)),
                        TextInput::make('recipient_address')
                            ->required()
                            ->columnSpanFull()
                            ->disabled(fn($livewire) => filled($livewire->record)),
                        // Toggle::make('is_pickup')
                        //     ->reactive(),
                        TextInput::make('delivery_items')
                            ->required()
                            ->columnSpanFull()
                            ->disabled(fn($livewire) => filled($livewire->record)),
                        // TextInput::make('users_id')
                        //     ->label('Driver')
                        //     // ->readOnly()
                        //     ->formatStateUsing(function ($record) {
                        //         if (!$record) {
                        //             return null;
                        //         }
                        //         if ($record->deliveryEvents->isEmpty()) {
                        //             return null;  // Tampilkan nilai default jika tidak ada event
                        //         }
                        //         // Ambil event terbaru berdasarkan created_at
                        //         $latestUserOnEvent = $record->deliveryEvents->sortByDesc('created_at')->first();

                        //         // Kembalikan status terbaru jika ada, jika tidak tampilkan '-'
                        //         return optional($latestUserOnEvent?->users)->name ?? null;
                        //     }),
                        Placeholder::make('note')
                            ->label('Notes')
                            ->content('📌 Notes: After this form submitted , deliveries form cannot be edited')

                            ->visible(
                                fn(Component $component): bool =>
                                $component->getLivewire() instanceof \Filament\Resources\Pages\CreateRecord
                            ),
                        Select::make('users_id')
                            ->label('Driver')
                            ->relationship('users', 'name')
                            ->preload()
                            ->searchable()
                            //disable ketika role nya bukan admin
                            ->disabled(function (Component $component): bool {
                                $user = Filament::auth()->user();
                                $isEdit = $component->getLivewire() instanceof \Filament\Resources\Pages\EditRecord;

                                return $isEdit && !$user->hasAnyRole(['super_admin', 'admin']);
                            })
                            ->hidden(function (Component $component): bool {
                                return $component->getLivewire() instanceof \Filament\Resources\Pages\CreateRecord;
                            }),

                        // ->hidden(fn($get) => !$get('is_pickup')),
                        // Select::make('checkpoints_id')
                        //     ->relationship('checkpoints', 'checkpoint_name')
                        //     ->searchable()
                        //     ->preload()
                        //     ->required(),
                        // Select::make('delivery_statuses_id')
                        //     ->relationship('deliveryStatus', 'delivery_status')
                        //     ->searchable()
                        //     ->preload()
                        //     ->required(),

                        // TextInput::make('delivery_photo')
                        //     ->maxLength(255)
                        //     ->default(null),
                    ]),
                // Group::make()->schema([
                //     Section::make('test')->schema([
                //         Select::make('checkpoints_id') // pastikan field-nya sesuai kolom foreign key
                //             ->label('District')
                //             ->options(function () {
                //                 return \App\Models\Checkpoint::with('districts')
                //                     ->get()
                //                     ->mapWithKeys(function ($checkpoint) {
                //                         $districtName = $checkpoint->districts->district_name ?? 'Select a district';
                //                         return [$checkpoint->id => "{$districtName} - {$checkpoint->checkpoint_name}"];
                //                     });
                //             })
                //     ])
                // ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('delivery_code')
                    ->searchable(),
                TextColumn::make('recipient_name')
                    ->searchable(),
                TextColumn::make('recipient_address')
                    ->searchable(),
                TextColumn::make('deliveryEvents.users.name')
                    ->formatStateUsing(function ($record) {
                        // Ambil event terbaru berdasarkan created_at
                        $latestUserOnEvent = $record->deliveryEvents->sortByDesc('created_at')->first();

                        // Kembalikan status terbaru jika ada, jika tidak tampilkan '-'
                        return optional($latestUserOnEvent?->users)->name ?? '-';
                    })
                    ->sortable(),

                // TextColumn::make('checkpoints_id')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('delivery_status')
                //     ->label('Status')
                //     ->formatStateUsing(function ($state, $record) {
                //         $latestEvent = $record->deliveryEvents->sortByDesc('created_at')->first();
                //         if (!$latestEvent) {
                //             return '-'; // Menangani jika tidak ada event
                //         }
                //     })
                //     ->searchable(),
                // TextColumn::make('delivery_statuses_id')
                //     ->label('Status')
                //     ->formatStateUsing(function ($state, $record) {
                //         $latestEvent = $record->deliveryEvents->sortByDesc('id')->first();
                //         return $latestEvent?->deliveryStatus?->delivery_status ?? '-';
                //     })
                //     ->searchable(),
                // TextColumn::make('delivery_photo')
                //     ->searchable(),
                TextColumn::make('latest_status')
                    ->label('Latest Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $latestEvent = $record->deliveryEvents->sortByDesc('created_at')->first();
                        return optional($latestEvent?->deliveryStatus)->delivery_status ?? '-';
                    })
                    ->formatStateUsing(fn(string $state) => $state)
                    ->color(fn(string $state) => match ($state) {
                        'Sedang Dipickup' => 'warning',
                        'Sedang Dikirim' => 'warning',
                        'Telah Tiba' => 'success',
                        'Menunggu Persetujuan' => 'info',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(function ($record) {
                        $user = Filament::auth()->user();
                        $latestStatus = optional($record->deliveryEvents->sortByDesc('created_at')->first()?->deliveryStatus)->delivery_status;

                        // Sembunyikan Edit jika bukan admin & status Menunggu Persetujuan
                        if (!$user->hasAnyRole(['admin', 'super_admin']) && $latestStatus === 'Menunggu Persetujuan') {
                            return false;
                        }

                        return true;
                    }),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(function (Delivery $record): bool {
                        $user = Filament::auth()->user();

                        // hanya jika user tidak punya role admin/super_admin
                        return !$user->hasAnyRole(['admin', 'super_admin']) &&
                            optional($record->deliveryEvents->sortByDesc('created_at')->first()?->deliveryStatus)->delivery_status === 'Menunggu Persetujuan';
                    })
                    ->action(function (Delivery $record): void {
                        // Contoh logika approve-nya
                        $menungguStatus = \App\Models\DeliveryStatus::where('delivery_status', 'Sedang Dipickup')->first();

                        if ($menungguStatus) {
                            $record->deliveryEvents()->create([
                                'delivery_statuses_id' => $menungguStatus->id,
                                'users_id' => Filament::auth()->id(),
                            ]);
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Approve Delivery')
                    ->modalDescription('Are you sure you want to approve this delivery?')
                    ->modalSubmitActionLabel('Approve')


                // Tables\Actions\CreateAction::make(),
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
            DeliveryEventsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        // ->withoutGlobalScopes([
        //     SoftDeletingScope::class,
        // ])
        // ->with([
        //     'deliveryEvents.deliveryStatus', // <-- relasi berantai
        //     'deliveryEvents.checkpoints',     // <-- jika ada checkpoint juga
        // ]);
        // if(!Filament::auth()->user()->hasAnyRole('super_admin'))
        if (!Filament::auth()->user()->hasRole('super_admin')) {
            $query->withoutGlobalScopes([SoftDeletingScope::class,])->with([
                'deliveryEvents.deliveryStatus', // <-- relasi berantai
                'deliveryEvents.checkpoints',     // <-- jika ada checkpoint juga
            ])->where('users_id', Filament::auth()->id());
        } else {
            $query->withoutGlobalScopes([SoftDeletingScope::class,])->with([
                'deliveryEvents.deliveryStatus', // <-- relasi berantai
                'deliveryEvents.checkpoints',     // <-- jika ada checkpoint juga
            ]);
        }
        return $query;
    }

    //buat hilangin di sidebar 
    // public static function shouldRegisterNavigation(): bool
    // {
    //     return false;
    // }

    // public static function getLabel(): string
    // {
    //     return __(static::$title); // pastikan diterjemahkan
    // }
}
