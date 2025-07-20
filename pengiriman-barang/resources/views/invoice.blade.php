<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $record->delivery_code }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 11px;
            color: #666;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
            margin: 20px 0 10px 0;
        }
        
        .invoice-code {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        
        .content {
            margin: 30px 0;
        }
        
        .info-section {
            margin-bottom: 30px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }
        
        .info-value {
            flex: 1;
            color: #555;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-success {
            background-color: #27ae60;
            color: white;
        }
        
        .status-warning {
            background-color: #f39c12;
            color: white;
        }
        
        .status-info {
            background-color: #3498db;
            color: white;
        }
        
        .status-secondary {
            background-color: #95a5a6;
            color: white;
        }
        
        .delivery-events {
            margin-top: 30px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .event-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
        }
        
        .event-status {
            font-weight: bold;
            color: #333;
        }
        
        .event-date {
            font-size: 10px;
            color: #666;
        }
        
        .event-user {
            font-size: 11px;
            color: #555;
            font-style: italic;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Tunas Jaya </div>
        <div class="company-info">
            Jl Brigjen Slamet Riyadi 64, Lumajang<br>
            Phone: +62 331-881476 | Email: tunasjaya@example.com

        </div>
        <div class="invoice-title">DELIVERY INVOICE</div>
        <div class="invoice-code"># {{ $record->delivery_code }}</div>
    </div>

    <div class="content">
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Invoice Code:</div>
                <div class="info-value">{{ $record->delivery_code }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Recipient Name:</div>
                <div class="info-value">{{ $record->recipient_name }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Delivery Address:</div>
                <div class="info-value">{{ $record->recipient_address }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Delivery Items:</div>
                <div class="info-value">{{ $record->delivery_items }}</div>
            </div>
            
            <!-- @if($record->users)
            <div class="info-row">
                <div class="info-label">Assigned Driver:</div>
                <div class="info-value">{{ $record->users->name }}</div>
            </div>
            @endif
             -->
            <!-- <div class="info-row">
                <div class="info-label">Current Status:</div>
                <div class="info-value">
                    @php
                        $latestEvent = $record->deliveryEvents->sortByDesc('created_at')->first();
                        $status = optional($latestEvent?->deliveryStatus)->delivery_status ?? 'Unknown';
                        $statusClass = match($status) {
                            'Telah Tiba' => 'status-success',
                            'Sedang Dipickup', 'Sedang Dikirim' => 'status-warning',
                            'Menunggu Kurir' => 'status-info',
                            default => 'status-secondary'
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $status }}</span>
                </div>
            </div> -->
            
            <div class="info-row">
                <div class="info-label">Created Date:</div>
                <div class="info-value">{{ $record->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- @if($record->deliveryEvents->isNotEmpty())
        <div class="delivery-events">
            <div class="section-title">Delivery Timeline</div>
            @foreach($record->deliveryEvents->sortBy('created_at') as $event)
            <div class="event-item">
                <div class="event-status">{{ optional($event->deliveryStatus)->delivery_status ?? 'Unknown Status' }}</div>
                <div class="event-date">{{ $event->created_at->format('d F Y, H:i') }} WIB</div>
                @if($event->users)
                <div class="event-user">Updated by: {{ $event->users->name }}</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif -->
    </div>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
        <p>Generated on {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>