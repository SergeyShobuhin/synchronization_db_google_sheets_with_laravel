<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Models\DataItem;
use App\Services\DataItem\Service;
use App\Services\GoogleSheets\GoogleSheetsManager;

class DataExportController extends Controller
{
    public function exportSheet(GoogleSheetsManager $manager,)
    {
        try {
            $googleSheetsService = $manager->getService();

            $dataItems = DataItem::allowed()->get();
            $itemsStatus = $dataItems->pluck('id')->toArray();
            $data = (new Service())->getDataToStatusAllowed($dataItems);

            if ($googleSheetsService->getData() == null) {
                $googleSheetsService->appendData($data);
            } else {
                $googleSheetsService->compareDataToSheet($itemsStatus);
                $googleSheetsService->updateData($data);
            }

            return back()->with('success', 'Данные успешно экспортированы в Google Sheet!');

        } catch (\Exception $e) {

            return back()->withErrors(['export' => $e->getMessage()]);
        }
    }

    public function clearSheet(GoogleSheetsManager $manager)
    {
        try {
            $googleSheetsService = $manager->getService();
            $googleSheetsService->clearRange();

            return back()->with('success', 'Таблица очищена в Google Sheet!');
        } catch (\Exception $e) {

            return back()->withErrors(['clear' => $e->getMessage()]);
        }
    }
}
