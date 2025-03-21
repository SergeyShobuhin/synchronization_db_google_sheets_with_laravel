<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheets\GoogleSheetsManager;
use Illuminate\Http\Request;

class UploadTableController extends Controller
{
    public function uploadTable(Request $request, GoogleSheetsManager $manager)
    {
        $url = $request->input('urlSheet');

        if (empty($url)) {
            return back()->withErrors(['urlSheet' => 'URL Google Sheets не указан.']);
        }

        try {
            $manager->connect($url);

            return back()->with('success', "Google Таблица подключена!");
        } catch (\Exception $e) {

            return back()->withErrors(['urlSheet' => $e->getMessage()]);
        }
    }
}
