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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DeliveryResource extends Resource
{
    protected static ?string $title = 'Delivery';
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Deliveries';

    protected static ?string $activeNavigationIcon = 'heroicon-o-truck';

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
                                $today = now()->format('ymd'); // yymmdd
                                $prefix = 'TJ-' . $today;

                                // Cari delivery terakhir dengan prefix hari ini
                                $last = Delivery::where('delivery_code', 'like', "{$prefix}%")
                                    ->latest('delivery_code')
                                    ->first();

                                $lastNumber = 1;

                                if ($last && preg_match("/{$prefix}(\d{3})/", $last->delivery_code, $matches)) {
                                    $lastNumber = (int) $matches[1] + 1;
                                }

                                return $prefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
                            })
                            // ->disabled(fn($livewire) => is_null($livewire->record?->id)) // disable saat create
                            ->disabled()
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
                    ->searchable()
                    ->sortable(),
                TextColumn::make('recipient_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('recipient_address')
                    ->searchable(),
                TextColumn::make('deliveryEvents.users.name')
                    ->formatStateUsing(function ($record) {
                        // Ambil event terbaru berdasarkan created_at
                        $latestUserOnEvent = $record->deliveryEvents->sortByDesc('created_at')->first();

                        // Kembalikan status terbaru jika ada, jika tidak tampilkan '-'
                        return optional($latestUserOnEvent?->users)->name ?? '-';
                    }),
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
                    ->label(__('delivery.table.latest_status'))
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
                        'Menunggu Kurir' => 'info',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                // Filter berdasarkan tanggal dibuat (created_at)
                Filter::make('created_date')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Dari Tanggal')
                            ->placeholder('Pilih tanggal mulai')
                            ->maxDate(today()),
                        DatePicker::make('created_until')
                            ->label('Sampai Tanggal')
                            ->placeholder('Pilih tanggal akhir')
                            ->maxDate(today()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Dibuat dari: ' . Carbon::parse($data['created_from'])->toDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Dibuat sampai: ' . Carbon::parse($data['created_until'])->toDateString();
                        }

                        return $indicators;
                    }),

                // Filter berdasarkan tanggal diupdate (updated_at)
                Filter::make('updated_date')
                    ->form([
                        DatePicker::make('updated_from')
                            ->label('Diupdate Dari Tanggal')
                            ->placeholder('Pilih tanggal mulai')
                            ->maxDate(today()),
                        DatePicker::make('updated_until')
                            ->label('Diupdate Sampai Tanggal')
                            ->placeholder('Pilih tanggal akhir')
                            ->maxDate(today()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['updated_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('updated_at', '>=', $date),
                            )
                            ->when(
                                $data['updated_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('updated_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['updated_from'] ?? null) {
                            $indicators['updated_from'] = 'Diupdate dari: ' . Carbon::parse($data['updated_from'])->toDateString();
                        }

                        if ($data['updated_until'] ?? null) {
                            $indicators['updated_until'] = 'Diupdate sampai: ' . Carbon::parse($data['updated_until'])->toDateString();
                        }

                        return $indicators;
                    }),

                // Filter berdasarkan hari ini
                Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn(Builder $query): Builder => $query->whereDate('created_at', today()))
                    ->toggle(),

                // Filter berdasarkan minggu ini
                Filter::make('this_week')
                    ->label('Minggu Ini')
                    ->query(fn(Builder $query): Builder => $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]))
                    ->toggle(),

                // Filter berdasarkan bulan ini
                Filter::make('this_month')
                    ->label('Bulan Ini')
                    ->query(fn(Builder $query): Builder => $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(function ($record) {
                        $user = Filament::auth()->user();
                        $latestStatus = optional($record->deliveryEvents->sortByDesc('created_at')->first()?->deliveryStatus)->delivery_status;

                        // Sembunyikan Edit jika bukan admin & status Menunggu Kurir
                        if (!$user->hasAnyRole(['admin', 'super_admin']) && $latestStatus === 'Menunggu Kurir') {
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
                            optional($record->deliveryEvents->sortByDesc('created_at')->first()?->deliveryStatus)->delivery_status === 'Menunggu Kurir';
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
                    ->modalSubmitActionLabel('Approve'),

                // Print Invoice Action - Using DomPDF
                Tables\Actions\Action::make('print_invoice')
                    ->label('Print Invoice')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->action(function ($record) {
                        $pdf = Pdf::loadView('invoice', ['record' => $record])
                            ->setPaper('a4', 'portrait')
                            ->setOptions(['defaultFont' => 'sans-serif']);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'invoice-' . $record->delivery_code . '.pdf');
                    }),

                // View Invoice in Browser
                Tables\Actions\Action::make('view_invoice')
                    ->label('View Invoice')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn($record): string => route('delivery.invoice.view', $record->id))
                    ->openUrlInNewTab(),

                // Tables\Actions\CreateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                // Action untuk print laporan
                Tables\Actions\Action::make('print_report')
                    ->label('Print Laporan')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->form([
                        Section::make('Filter Laporan')
                            ->schema([
                                DatePicker::make('report_date_from')
                                    ->label('Dari Tanggal')
                                    ->required()
                                    ->maxDate(today())
                                    ->default(today()->subMonth()),
                                DatePicker::make('report_date_to')
                                    ->label('Sampai Tanggal')
                                    ->required()
                                    ->maxDate(today())
                                    ->default(today()),
                                Select::make('report_status')
                                    ->label('Status')
                                    ->options([
                                        'all' => 'Semua Status',
                                        'Menunggu Kurir' => 'Menunggu Kurir',
                                        'Sedang Dipickup' => 'Sedang Dipickup',
                                        'Sedang Dikirim' => 'Sedang Dikirim',
                                        'Telah Tiba' => 'Telah Tiba',
                                    ])
                                    ->default('all'),
                                Select::make('report_driver')
                                    ->label('Driver')
                                    ->options(function () {
                                        $currentUser = Filament::auth()->user();

                                        if (!$currentUser->hasRole('super_admin')) {
                                            return [$currentUser->id => $currentUser->name];
                                        }

                                        // Untuk super_admin, tampilkan semua driver
                                        $drivers = \App\Models\User::whereHas('roles', function ($query) {
                                            $query->whereIn('name', ['driver', 'admin', 'super_admin']);
                                        })->orderBy('name')->get();

                                        $options = ['all' => 'Semua Driver'];
                                        foreach ($drivers as $driver) {
                                            $options[$driver->id] = $driver->name;
                                        }

                                        return $options;
                                    })
                                    ->getSearchResultsUsing(function (string $search) {
                                        $currentUser = Filament::auth()->user();

                                        if (!$currentUser->hasRole('super_admin')) {
                                            return [$currentUser->id => $currentUser->name];
                                        }

                                        // Custom search logic
                                        $drivers = \App\Models\User::whereHas('roles', function ($query) {
                                            $query->whereIn('name', ['kurir', 'admin', 'super_admin']);
                                        })
                                            ->where('name', 'like', "%{$search}%")
                                            ->orderBy('name')
                                            ->limit(50)
                                            ->get();

                                        $options = [];
                                        if (str_contains(strtolower('Semua Driver'), strtolower($search))) {
                                            $options['all'] = 'Semua Driver';
                                        }

                                        foreach ($drivers as $driver) {
                                            $options[$driver->id] = $driver->name;
                                        }

                                        return $options;
                                    })
                                    ->searchable(fn() => Filament::auth()->user()->hasRole('super_admin'))
                                    ->default(function () {
                                        $currentUser = Filament::auth()->user();
                                        return $currentUser->hasRole('super_admin') ? 'all' : $currentUser->id;
                                    })
                                    ->disabled(fn() => !Filament::auth()->user()->hasRole('super_admin')),
                            ])
                    ])
                    ->action(function (array $data) {
                        $query = Delivery::with(['deliveryEvents.deliveryStatus', 'deliveryEvents.users', 'users'])
                            ->whereBetween('created_at', [
                                $data['report_date_from'] . ' 00:00:00',
                                $data['report_date_to'] . ' 23:59:59'
                            ]);

                        $currentUser = Filament::auth()->user();

                        // Pastikan report_driver ada, jika tidak set default
                        $reportDriver = $data['report_driver'] ?? ($currentUser->hasRole('super_admin') ? 'all' : $currentUser->id);

                        // Filter berdasarkan user role
                        if (!$currentUser->hasRole('super_admin')) {
                            // Jika bukan super_admin, hanya bisa melihat delivery milik sendiri
                            $query->where('users_id', $currentUser->id);
                        } else {
                            // Jika super_admin dan pilih driver tertentu
                            if ($reportDriver !== 'all') {
                                $query->where('users_id', $reportDriver);
                            }
                        }

                        $deliveries = $query->get();

                        // Filter berdasarkan status jika bukan 'all'
                        if (($data['report_status'] ?? 'all') !== 'all') {
                            $deliveries = $deliveries->filter(function ($delivery) use ($data) {
                                $latestEvent = $delivery->deliveryEvents->sortByDesc('created_at')->first();
                                $status = optional($latestEvent?->deliveryStatus)->delivery_status;
                                return $status === $data['report_status'];
                            });
                        }

                        // Determine driver name for report
                        $driverName = 'Semua Driver';
                        if (!$currentUser->hasRole('super_admin')) {
                            $driverName = $currentUser->name;
                        } elseif ($reportDriver !== 'all') {
                            $driver = \App\Models\User::find($reportDriver);
                            $driverName = $driver ? $driver->name : 'Driver Tidak Ditemukan';
                        }

                        $reportData = [
                            'deliveries' => $deliveries,
                            'date_from' => $data['report_date_from'],
                            'date_to' => $data['report_date_to'],
                            'status_filter' => $data['report_status'] ?? 'all',
                            'driver_filter' => $reportDriver,
                            'driver_name' => $driverName,
                            'generated_by' => $currentUser->name,
                            'generated_at' => now()->format('d/m/Y H:i:s'),
                            'total_deliveries' => $deliveries->count(),
                        ];

                        // Statistik tambahan
                        $reportData['statistics'] = [
                            'menunggu_kurir' => $deliveries->filter(function ($d) {
                                $latest = $d->deliveryEvents->sortByDesc('created_at')->first();
                                return optional($latest?->deliveryStatus)->delivery_status === 'Menunggu Kurir';
                            })->count(),
                            'sedang_dipickup' => $deliveries->filter(function ($d) {
                                $latest = $d->deliveryEvents->sortByDesc('created_at')->first();
                                return optional($latest?->deliveryStatus)->delivery_status === 'Sedang Dipickup';
                            })->count(),
                            'sedang_dikirim' => $deliveries->filter(function ($d) {
                                $latest = $d->deliveryEvents->sortByDesc('created_at')->first();
                                return optional($latest?->deliveryStatus)->delivery_status === 'Sedang Dikirim';
                            })->count(),
                            'telah_tiba' => $deliveries->filter(function ($d) {
                                $latest = $d->deliveryEvents->sortByDesc('created_at')->first();
                                return optional($latest?->deliveryStatus)->delivery_status === 'Telah Tiba';
                            })->count(),
                        ];

                        $pdf = Pdf::loadView('reports.delivery-report', $reportData)
                            ->setPaper('a4', 'landscape')
                            ->setOptions(['defaultFont' => 'sans-serif']);

                        $filename = 'laporan-delivery-' . $data['report_date_from'] . '-to-' . $data['report_date_to'] . '.pdf';

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, $filename);
                    })
                    ->modalHeading('Generate Laporan Delivery')
                    ->modalSubmitActionLabel('Generate PDF')
                    ->modalWidth('md'),
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
