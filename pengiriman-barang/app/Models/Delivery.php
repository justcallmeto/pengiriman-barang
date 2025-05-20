<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;
    // protected $fillable = ['recipient_name', 'recipient_address', 'checkpoints_id', 'users_id', 'delivery_statuses_id', 'is_pickup', 'is_done', 'is_send'];

    protected $fillable = ['delivery_code', 'recipient_name', 'recipient_address', 'delivery_items', 'users_id', 'checkpoint_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // public function checkpoints()
    // {
    //     return $this->belongsTo(Checkpoint::class, 'checkpoints_id');
    // }
    // public function deliveryStatus()
    // {
    //     return $this->belongsTo(DeliveryStatus::class, 'delivery_statuses_id');
    // }

    public function deliveryEvents()
    {
        return $this->hasMany(DeliveryEvent::class, 'delivery_id');
    }
}
