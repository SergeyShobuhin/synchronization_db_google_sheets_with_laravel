<?php

namespace App\Service\DataItem;

use App\Models\DataItem;
use Database\Factories\DataItemFactory;
use Illuminate\Support\Facades\DB;

class Service
{
    public function generateData(): void
    {
        DataItem::factory(1000)->create();
    }

    public function clearData(): void
    {
        DB::table('data_items')->truncate();
    }

}
