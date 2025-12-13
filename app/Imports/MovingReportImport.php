<?php

namespace App\Imports;

use App\Models\MovingReport;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class MovingReportImport implements ToModel , WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //  dd($row);
        //  dd(array_keys($row));
        // $row = array_combine(array_map('trim', array_keys($row)), $row);


        $event = $row['Event '];
        $stationaryMinutes = null;

        if (str_contains($event, 'Stationary Time')) {

            // Initialize all time units
            $days = $hours = $minutes = $seconds = 0;

            // Extract days
            if (preg_match('/(\d+)\s*day/', $event, $d)) {
                $days = (int) $d[1];
            }

            // Extract hours
            if (preg_match('/(\d+)\s*hours?/', $event, $h)) {
                $hours = (int) $h[1];
            }

            // Extract minutes
            if (preg_match('/(\d+)\s*minutes?/', $event, $m)) {
                $minutes = (int) $m[1];
            }

            // Extract seconds
            if (preg_match('/(\d+)\s*seconds?/', $event, $s)) {
                $seconds = (int) $s[1];
            }

            // Convert to total minutes
            $stationaryMinutes =
                ($days * 24 * 60) +
                ($hours * 60) +
                $minutes +
                intval($seconds / 60);
        }

        return new MovingReport([
            'asset_name'        => $row['Asset Name'],
            'event'             => $event,
            'time_sent'         => Carbon::parse($row['Time Sent']),
            'location'          => $row['Location'],
            'stationary_minutes' => $stationaryMinutes,
        ]);
    }
}
