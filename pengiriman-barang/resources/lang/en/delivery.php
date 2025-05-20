<?php
return [
    'title' => 'Delivery',
    'group-desc' => 'Create a delivery form',
    'keys' => 'abcd',
    'form' => [
        'section' => 'Delivery Package',
        'description' => 'Create a new delivery record',
        'delivery_code' => 'Delivery Code',
        'recipient_name' => 'Recipient Name',
        'recipient_address' => 'Recipient Address',
        'delivery_items' => 'Delivery Items',
        'notes' => '📌 Note: Once submitted, this form cannot be edited.',
        'driver' => 'Driver',
    ],
    'table' => [
        'delivery_code' => 'Code',
        'recipient_name' => 'Recipient',
        'recipient_address' => 'Address',
        'latest_driver' => 'Driver',
        'latest_status' => 'Latest Status',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
];
