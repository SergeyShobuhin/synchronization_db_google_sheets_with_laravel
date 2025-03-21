<?php

namespace App\Services\DataItem;

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

    public function getDataToStatusAllowed($dataItems): array
    {
        $data = [];
        foreach ($dataItems as $item) {

            $id = $item->id;
            $name = $item->name;
            $description = $item->description;
            if ($item->status === 'allowed') {
                $status = $item->status;
            } else {
                continue;
            }
            $comment = $item->comment;

            $data[] = [$id, $name, $description, $status, $comment];
        }

        return $data;
    }
}
