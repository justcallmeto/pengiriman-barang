<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryStatus extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['delivery_status'];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'delivery_statuses_id');
    }

    public function deliveryEvents()
    {
        return $this->hasMany(DeliveryEvent::class, 'delivery_statuses_id');
    }
}
