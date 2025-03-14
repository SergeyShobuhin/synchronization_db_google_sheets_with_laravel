<?php

namespace App\Models;

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

//    public function getRouteKeyName()
//    {
//        return 'name'; // Указываем, что нужно использовать поле 'id'
//    }
}
