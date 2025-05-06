<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    // public $table = 'tablename';
    public $table = 'districts';

    public function checkpoints()
    {
        return $this->hasMany(Checkpoint::class, 'districts_id');
    }
}
