<?php

namespace App\Imports;

use App\Models\Violation;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');
class EventsReportImport implements ToCollection, WithHeadingRow
{
    /**
     *  Collection $collection
     */
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new Exception('Excel file is empty');
        }


          //Validate required headers

        $requiredHeaders = [
            'AssetName',
            'EventDescription',
            'EventStartDate',
            'EventValue',
            'TotalDuration',
        ];

        $excelHeaders = array_keys($rows->first()->toArray());


        foreach ($requiredHeaders as $header) {
            if (!in_array($header, $excelHeaders)) {
                throw new Exception("Missing required column: {$header}");
            }
        }

        // 1️⃣ Filter rows that have required fields
        // $rows = $rows->filter(
        //     fn($row) =>
        //     isset($row['AssetName'], $row['EventType'], $row['EventStartDate'], $row['EventValue'])
        // );

        // 2️⃣ Convert Excel numeric dates & EventValue
        $rows = $rows->map(function ($row, $index) {

            if (
                empty($row['AssetName']) ||
                empty($row['EventDescription']) ||
                empty($row['EventStartDate']) ||
                !is_numeric($row['EventValue']) ||
                !is_numeric($row['TotalDuration'])
            ) {
                throw new Exception("Invalid data found at row " . ($index + 2));
            }

            $row['EventValue'] = (float) $row['EventValue'];

            $totalSeconds = $row['TotalDuration'] * 24 * 60 * 60;
            $hours   = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = round($totalSeconds % 60);
            $row['Duration_HMS'] = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

            $date = is_numeric($row['EventStartDate'])
                ? Date::excelToDateTimeObject($row['EventStartDate'])
                : new \DateTime($row['EventStartDate']);

            $row['date'] = $date->format('Y-m-d');

            return $row;
        });

        // 3️⃣ Group by truck + EventType and get the highest EventValue row only
        $maxEvents = $rows
            ->groupBy(fn($row) => $row['AssetName'] . '_' . $row['EventDescription'])
            ->map(function ($events) {
                return $events->sortByDesc('EventValue')->first();
            });

        // 4️⃣ Insert/update the max events into the DB
        DB::transaction(function () use ($maxEvents) {
            foreach ($maxEvents as $row) {
                Violation::updateOrCreate(
                    [
                        'date'       => $row['date'],
                        'asset'      => $row['AssetName'],
                        'event_type' => $row['EventDescription'],
                    ],
                    [
                        'driver'      => $row['AssetName2'] ?? 'Unknown',
                        'location'    => $row['StartLocation'] ?? null,
                        'duration'    =>  $row['Duration_HMS'] ?? null,
                        'max_speed'   => $row['EventValue'],
                        'destination' => null,
                        'coordinates' => $row['StartLatLong'] ?? null,
                    ]
                );
            }
        });
    }
}
