<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkpoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function districts()
    {
        return $this->belongsTo(District::class, 'districts_id');
    }
    public function deliveryEvents()
    {
        return $this->hasMany(DeliveryEvent::class, 'checkpoint_id');
    }
}
