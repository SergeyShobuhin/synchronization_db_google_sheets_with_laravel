<?php

namespace App\Http\Controllers\DataItem;

use App\Http\Controllers\Controller;
use App\Models\DataItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataItemController extends Controller
{
    public function index()
    {
        $dataItems = DataItem::paginate(5);

        return view('dataitem.index', compact('dataItems'));
    }

    public function create()
    {
        return view('dataitem.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=> 'string',
            'description' =>'string',
            'status'=> '',
        ]);
        DataItem::create($data);

        return redirect()->route('dataitem.index');
    }

    public function show(DataItem $dataitem)
    {

        return view('dataitem.show', compact('dataitem'));
    }

    public function edit(DataItem $dataitem)
    {
        return view('dataitem.edit', compact('dataitem'));
    }

    public function update(Request $request, DataItem $dataitem)
    {
        $data = $request->validate([
            'name'=> 'string',
            'description' =>'string',
            'status'=> '',
        ]);
        $dataitem->update($data);

        return redirect()->route('dataitem.show', $dataitem->id);
    }

    public function destroy(DataItem $dataitem)
    {
        $dataitem->delete();

        return redirect()->route('dataitem.index');
    }

}
