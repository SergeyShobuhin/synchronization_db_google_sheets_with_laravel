<?php

namespace App\Services\GoogleSheets;

class GoogleSheetsUrlParser
{
    public static function parse(string $url): array
    {
        if (!preg_match('/\/spreadsheets\/d\/([a-zA-Z0-9-_]+)/', $url, $matches)) {
            throw new \InvalidArgumentException('Неверный формат ссылки на Google Sheets.');
        }

        $spreadsheetId = $matches[1];

        $queryParams = [];
        $urlParts = parse_url($url);
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $queryParams);
        }

        return [
            'spreadsheetId' => $spreadsheetId,
            'gid' => $queryParams['gid'] ?? null,
        ];
    }

}
