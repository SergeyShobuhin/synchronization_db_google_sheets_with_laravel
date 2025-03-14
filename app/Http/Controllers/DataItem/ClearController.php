<?php

namespace App\Http\Controllers\DataItem;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClearController extends Controller
{
    public function clear()
    {
//        dd('aaaaaaaa');
        DB::table('data_items')->truncate();
        return redirect()->route('dataitem.index');
    }
}
