<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryEvent extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['delivery_id', 'checkpoint_id', 'delivery_statuses_id', 'users_id', 'note', 'photos'];
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function deliveryStatus()
    {
        return $this->belongsTo(DeliveryStatus::class, 'delivery_statuses_id');
    }

    public function checkpoints()
    {
        return $this->belongsTo(Checkpoint::class, 'checkpoint_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    protected static function booted()
    {
        static::saved(function ($deliveryEvent) {
            $latestEvent = $deliveryEvent->delivery
                ->deliveryEvents()
                ->orderByDesc('created_at')
                ->first();

            // Jika event ini adalah yang terbaru, update delivery.users_id
            if ($latestEvent && $latestEvent->id === $deliveryEvent->id) {
                $deliveryEvent->delivery->update([
                    'users_id' => $deliveryEvent->users_id,
                ]);
            }
        });
    }
}
