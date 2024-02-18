<?php

declare(strict_types=1);

namespace App\Common\Services;

class CsvService
{
    public function load(string $filePath, string $separator = ',', array|false $header = null): array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception(sprintf('File %s not found', $filePath));
        }
        $data = array();
        if (($handle = fopen($filePath, 'rb')) !== false) {
            while (($row = fgetcsv($handle, 1000, $separator)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
