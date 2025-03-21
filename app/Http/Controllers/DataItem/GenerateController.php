<?php

namespace App\Http\Controllers\DataItem;

use App\Http\Controllers\Controller;
use App\Models\DataItem;

class GenerateController extends Controller
{
    public function generate()
    {
        DataItem::factory(100)->create();
        return redirect()->route('dataitem.index');
    }

}
