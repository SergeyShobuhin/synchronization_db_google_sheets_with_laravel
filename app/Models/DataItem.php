<?php

namespace App\Models;

use App\Enums\DataItemStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataItem extends Model
{
    use HasFactory;

    protected $table = 'data_items';

//    protected $fillable = [
//        'name',
//        'description',
//        'status',
//    ];
    protected $guarded = [];

    public function scopeAllowed($query)
    {
        return $query->where('status', DataItemStatus::Allowed);
    }
}
