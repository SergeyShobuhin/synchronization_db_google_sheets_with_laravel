<?php

namespace App\Services\GoogleSheets;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\AppendDimensionRequest;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\BatchUpdateValuesRequest;
use Google\Service\Sheets\CellData;
use Google\Service\Sheets\ClearValuesRequest;
use Google\Service\Sheets\DeleteDimensionRequest;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\RowData;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsService
{
    protected Client $client;
    protected Sheets $service;
    protected ?string $spreadsheetId = null;
    protected ?string $gid = null;
    protected string $sheetName;

    public function __construct(string $spreadsheetId, ?string $gid = null)
    {
//        $this->spreadsheetId = config('services.google.spreadsheet_id');
        $this->spreadsheetId = $spreadsheetId;
        $this->gid = $gid;
        $this->sheetName = 'Sheet1';

        $this->client = new Client();
        $this->client->setApplicationName('google-api-laravel');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('app/google_sheets_credentials.json'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
    }

    public function appendData(array $values, string $range = null): void
    {
        if (empty($this->spreadsheetId)) {
            throw new \Exception('GOOGLE_SHEET_ID не настроен в .env');
        }

        if (empty($values)) {
            return;
        }
        if (!$range) {
            $range = $this->sheetName . '!A1';
        }

        $body = new ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'USER_ENTERED'];  //RAW - вставляет данные как есть(просто текст) // Или 'USER_ENTERED' - будет пытаться вставить формулой

        try {
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
        } catch (\Exception $e) {
            \Log::error('Google Sheets API Error (appendData): ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateData(array $values, string $range = null): void
    {
        if (empty($this->spreadsheetId)) {
            throw new \Exception('GOOGLE_SHEET_ID не настроен в .env');
        }

        if (!$range) {
            $range = $this->sheetName . '!A1'; // Используем имя листа и начинаем с A1
        }
        $data = [
            new ValueRange([
                'range' => $range,
                'values' => $values,
            ]),
        ];

        $body = new BatchUpdateValuesRequest([
            'valueInputOption' => 'USER_ENTERED', // RAW - вставляет данные как есть(просто текст) // Или 'USER_ENTERED' - будет пытаться вставить формулой
            'data' => $data,
        ]);

        try {
            $this->service->spreadsheets_values->batchUpdate($this->spreadsheetId, $body);

        } catch (\Exception $e) {
            \Log::error('Google Sheets API Error (updateData):: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getData(string $range = null): array
    {
        if (empty($this->spreadsheetId)) {
            throw new \Exception('GOOGLE_SHEET_ID не настроен в .env');
        }
        if (!$range) {
            $range = $this->sheetName . '!A1:ZZ'; // get all data from sheet
        }

        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            return $response->getValues() ?? [];
        } catch (\Exception $e) {
            \Log::error('Google Sheets API Error (getData): ' . $e->getMessage());
            throw $e;
        }
    }

    private function getSheetId(): int
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() == $this->sheetName) {
                return $sheet->getProperties()->getSheetId();
            }
        }

        throw new \Exception("Sheet with name '{$this->sheetName}' not found.");
    }

    public function clearRange(string $range = null): void
    {
        if (empty($this->spreadsheetId)) {
            throw new \Exception('GOOGLE_SHEET_ID не настроен в .env');
        }
        if (!$range) {
            $range = $this->sheetName . '!A:Z';  // clear all data
        }

        try {
            $this->service->spreadsheets_values->clear(
                $this->spreadsheetId,
                $range,
                new ClearValuesRequest()
            );
        } catch (\Exception $e) {
            \Log::error('Google Sheets API Error (Clear Range): ' . $e->getMessage());
            throw $e;
        }
    }

    public function appendRow($idsToAppend): void
    {
        $sheetData = $this->getData();

        sort($idsToAppend);

        $lastIndex = -1; // Индекс последней обработанной строки
        foreach ($sheetData as $index => $row) {
            if (isset($row[0])) {
                $lastIndex = (int) $row[0];
            }
        }

        foreach ($idsToAppend as $idToAppend) {
            $inserted = false;
            for ($i = 0; $i < count($sheetData); $i++) {

                $currentRowId = (int) $sheetData[$i][0];

                if ($currentRowId > $idToAppend) {
                    // Создаем пустую строку с нужным количеством столбцов
                    $emptyRow = array_fill(0, count($sheetData[$i]), '');

                    // Вставляем пустую строку
                    array_splice($sheetData, $i, 0, [$emptyRow]);

                    $inserted = true;
                    break;
                }
            }

            // Если вставить не удалось, добавляем в конец
            if (!$inserted) {
                //Создаем пустую строку
                $emptyRow = [];
                if (!empty($sheetData)) {
                    $emptyRow = array_fill(0, count($sheetData[0]), '');// Заполняем в соответствии с длинной первой строки
                }

                $sheetData[] = $emptyRow;
                $inserted = true;

            }
        }

        // Обновляем Google Sheet
        $range = $this->sheetName;
        $body = new ValueRange([
            'values' => $sheetData,
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED', // Или 'RAW'
        ];

        try {
            $result = $this->service->spreadsheets_values->update(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );
            printf("%d cells updated.\n", $result->getUpdatedCells());
        } catch (\Exception $e) {
            \Log::error('Google Sheets API Error (appendRow): ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteRow($idsToDelete): void
    {
        $sheetData = $this->getData();
        foreach ($idsToDelete as $itemId) {
            foreach ($sheetData as $rowIndex => $row) {
                if (isset($row[0]) && $row[0] === $itemId) {

                    $startIndex = $rowIndex;
                    $endIndex = $rowIndex + 1;

                    $deleteRequest = new Request([
                        'deleteDimension' => new DeleteDimensionRequest([
                            'range' => [
//                    'sheetId' => getSheetIdByName($this->service, $this->spreadsheetId, $this->sheetName),
                                'dimension' => 'ROWS',
                                'startIndex' => $startIndex,
                                'endIndex' => $endIndex
                            ]
                        ])
                    ]);

                    $batchUpdateRequest = new BatchUpdateSpreadsheetRequest([
                        'requests' => [$deleteRequest]
                    ]);

                    try {
                        $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
                    } catch (\Exception $e) {
                        \Log::error('Google Sheets API Error (deleteRows): ' . $e->getMessage());
                        throw $e;
                    }
                }
            }
        }
    }

    public function compareDataToSheet($itemsStatus): void
    {
        $sheetData = $this->getData();
        $arrSheetData = [];

        foreach ($sheetData as $item) {
            if (!empty($item)) {
                $arrSheetData[] = $item[0];
            }
        }

        $idsToAppend = array_diff($itemsStatus,$arrSheetData);

        $idsToDelete = array_diff($arrSheetData, $itemsStatus);


        if (!empty($idsToAppend)) {
            $this->appendRow($idsToAppend);
        }

        if (!empty($idsToDelete)) {
            $this->deleteRow($idsToDelete);
        }
    }

    public function getSpreadsheetId(): string
    {
        return $this->spreadsheetId;
    }

    public function setSpreadsheetId(string $spreadsheetId): self
    {
        $this->spreadsheetId = $spreadsheetId;
        return $this;
    }

    public function getGid(): string
    {
        return $this->gid;
    }

    public function setGid(?string $gid): self
    {
        $this->gid = $gid;
        return $this;
    }

    public static function createFromUrl(string $url): self
    {
        if (empty($url)) {
            throw new \Exception('URL Google Sheets не указан.');
        }

        $parsed = GoogleSheetsUrlParser::parse($url);
        return new self($parsed['spreadsheetId'], $parsed['gid']);
    }
}
