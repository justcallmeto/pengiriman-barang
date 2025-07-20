<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Delivery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .report-info div {
            flex: 1;
        }
        
        .report-info strong {
            color: #2563eb;
        }
        
        .statistics {
            margin-bottom: 25px;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .statistics h3 {
            background-color: #2563eb;
            color: white;
            margin: 0;
            padding: 12px 15px;
            font-size: 16px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }
        
        .stat-item {
            padding: 15px;
            text-align: center;
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .stat-item:last-child {
            border-right: none;
        }
        
        .stat-item .number {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            display: block;
        }
        
        .stat-item .label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .data-table th {
            background-color: #374151;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            border-bottom: 2px solid #1f2937;
        }
        
        .data-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            vertical-align: top;
        }
        
        .data-table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }
        
        .status-menunggu { background-color: #dbeafe; color: #1d4ed8; }
        .status-pickup { background-color: #fef3c7; color: #d97706; }
        .status-kirim { background-color: #fed7aa; color: #ea580c; }
        .status-tiba { background-color: #dcfce7; color: #16a34a; }
        .status-default { background-color: #f3f4f6; color: #374151; }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        @media print {
            body { margin: 0; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DELIVERY</h1>
        <h2>Tunas Jaya</h2>
        <!-- <div class="company-name">Tunas Jaya </div> -->
        <div class="company-info">
            Jl Brigjen Slamet Riyadi 64, Lumajang<br>
            Phone: +62 331-881476 | Email: tunasjaya@example.com

        </div>
        <p>Periode: {{ \Carbon\Carbon::parse($date_from)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($date_to)->format('d/m/Y') }}</p>
    </div>

    <div class="report-info">
        <div>
            <strong>Total Data:</strong> {{ $total_deliveries }} delivery<br>
            <strong>Status Filter:</strong> {{ $status_filter === 'all' ? 'Semua Status' : $status_filter }}<br>
            <strong>Driver Filter:</strong> {{ $driver_filter === 'all' ? 'Semua Driver' : \App\Models\User::find($driver_filter)?->name ?? 'Tidak ditemukan' }}
        </div>
        <div style="text-align: right;">
            <strong>Dibuat oleh:</strong> {{ $generated_by }}<br>
            <strong>Tanggal Generate:</strong> {{ $generated_at }}<br>
            <strong>Sistem:</strong> Delivery Management
        </div>
    </div>

    @if($total_deliveries > 0)
        <div class="statistics">
            <h3>📊 Statistik Berdasarkan Status</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="number">{{ $statistics['menunggu_kurir'] }}</span>
                    <div class="label">Menunggu Kurir</div>
                </div>
                <div class="stat-item">
                    <span class="number">{{ $statistics['sedang_dipickup'] }}</span>
                    <div class="label">Sedang Dipickup</div>
                </div>
                <div class="stat-item">
                    <span class="number">{{ $statistics['sedang_dikirim'] }}</span>
                    <div class="label">Sedang Dikirim</div>
                </div>
                <div class="stat-item">
                    <span class="number">{{ $statistics['telah_tiba'] }}</span>
                    <div class="label">Telah Tiba</div>
                </div>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 12%;">Kode Delivery</th>
                    <th style="width: 15%;">Penerima</th>
                    <th style="width: 20%;">Alamat</th>
                    <th style="width: 15%;">Barang</th>
                    <th style="width: 10%;">Driver</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 8%;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveries as $index => $delivery)
                    @php
                        $latestEvent = $delivery->deliveryEvents->sortByDesc('created_at')->first();
                        $status = optional($latestEvent?->deliveryStatus)->delivery_status ?? '-';
                        $driver = optional($latestEvent?->users)->name ?? optional($delivery->users)->name ?? '-';
                        
                        $statusClass = match($status) {
                            'Menunggu Kurir' => 'status-menunggu',
                            'Sedang Dipickup' => 'status-pickup',
                            'Sedang Dikirim' => 'status-kirim',
                            'Telah Tiba' => 'status-tiba',
                            default => 'status-default'
                        };
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $delivery->delivery_code }}</strong></td>
                        <td>{{ $delivery->recipient_name }}</td>
                        <td>{{ Str::limit($delivery->recipient_address, 50) }}</td>
                        <td>{{ Str::limit($delivery->delivery_items, 40) }}</td>
                        <td>{{ $driver }}</td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td>{{ $delivery->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>📭 Tidak ada data delivery</h3>
            <p>Tidak ditemukan data delivery untuk periode dan filter yang dipilih.</p>
        </div>
    @endif

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem Delivery Management</p>
        <p>© {{ date('Y') }} - Delivery Management System</p>
    </div>
</body>
</html>