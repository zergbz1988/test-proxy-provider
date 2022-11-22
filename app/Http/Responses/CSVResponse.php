<?php

declare(strict_types=1);

namespace App\Http\Responses;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CSVResponse extends StreamedResponse
{
    public function __construct(array $rows, string $fileName = 'default.csv')
    {
        if (empty($rows)) {
            throw new InvalidArgumentException('Al least one row must be provided.');
        }

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = array_shift($rows);
        if (!is_array($columns)) {
            $columns = [$columns];
        }

        $callback = function () use ($rows, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($rows as $row) {
                if (!is_array($row)) {
                    $row = [$row];
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        parent::__construct($callback, 200, $headers);
    }

    public static function make(array $rows, string $fileName = 'default.csv'): static
    {
        return new static($rows, $fileName);
    }
}
