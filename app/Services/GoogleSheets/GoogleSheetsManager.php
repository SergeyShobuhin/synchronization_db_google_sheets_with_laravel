<?php

namespace App\Services\GoogleSheets;

class GoogleSheetsManager
{
    protected ?GoogleSheetsService $service = null;

    public function connect(string $url): void
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('URL Google Sheets не указан.');
        }

        session(['google_sheet.url' => $url]);

        $this->service = GoogleSheetsService::createFromUrl($url);
    }

    public function getService(): GoogleSheetsService
    {
        if (!$this->service) {
            $url = session('google_sheet.url');
            if (empty($url)) {
                throw new \RuntimeException('GoogleSheetsService не подключен. Сначала установите соединение.');
            }

            $this->service = GoogleSheetsService::createFromUrl($url);
        }

        return $this->service;
    }

    public function disconnect(): void
    {
        $this->service = null;
        session()->forget('google_sheet.url');
    }

}
