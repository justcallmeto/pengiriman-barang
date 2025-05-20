<?php
return [
    'title' => 'Pengiriman',
    'keys' => 'abcd',
    'form' => [
        'section' => 'Pengiriman Barang',
        'description' => 'Buat data pengiriman baru',
        'delivery_code' => 'Kode Pengiriman',
        'recipient_name' => 'Nama Penerima',
        'recipient_address' => 'Alamat Penerima',
        'delivery_items' => 'Barang Dikirim',
        'notes' => '📌 Catatan: Setelah formulir dikirim, tidak dapat diedit.',
        'driver' => 'Sopir',
    ],
    'table' => [
        'delivery_code' => 'Kode',
        'recipient_name' => 'Penerima',
        'recipient_address' => 'Alamat',
        'latest_driver' => 'Sopir',
        'latest_status' => 'Status Terakhir',
        'created_at' => 'Dibuat Pada',
        'updated_at' => 'Diperbarui Pada',
    ],
];