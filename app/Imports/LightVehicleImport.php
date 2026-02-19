<?php

namespace App\Imports;

use App\Models\lightVehicleScoring;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');

class LightVehicleImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $row = array_change_key_case($row, CASE_LOWER);

          $date = is_numeric($row['startdate'])
                ? Date::excelToDateTimeObject($row['startdate'])
                : new \DateTime($row['startdate']);


            $row['startdate'] = $date->format('Y-m-d');


        return new lightVehicleScoring([
            'start_date' => $row['startdate'],
            'asset_name' => $row['assetname'] ?? 'Unknown',
            'site_name' => $row['sitename'] ?? null,
            'start_time' => $this->excelTimeToTime($row['starttime'] ?? null),
            'end_time' =>  $this->excelTimeToTime($row['endtime'] ?? null),
            'duration_seconds' => $this->toSeconds($row['duration'] ?? '0:00:00'),
            'distance_km' => $row['distance'] ?? 0,

            'overspeed_score' => $row['overspeedingscore'] ?? 0,
            'overspeed_occ' => $row['overspeedingoccurences'] ?? 0,
            'overspeed_max' => $row['overspeedingmax'] ?? 0,
            'overspeed_duration' => $this->toSeconds($row['overspeedingduration'] ?? '0:00:00'),

            'overrev_score' => $row['overrevvingscore'] ?? 0,
            'overrev_occ' => $row['overrevvingoccurences'] ?? 0,
            'overrev_max' => $row['overrevvingmax'] ?? 0,
            'overrev_duration' => $this->toSeconds($row['overrevvingduration'] ?? '0:00:00'),

            'harsh_acc_score' => $row['harshaccelerationscore'] ?? 0,
            'harsh_acc_occ' => $row['harshaccelerationoccurences'] ?? 0,
            'harsh_acc_max' => $row['harshaccelerationmax'] ?? 0,
            'harsh_acc_duration' => $this->toSeconds($row['harshaccelerationduration'] ?? '0:00:00'),

            'harsh_brake_score' => $row['harshbrakingscore'] ?? 0,
            'harsh_brake_occ' => $row['harshbrakingoccurences'] ?? 0,
            'harsh_brake_max' => $row['harshbrakingmax'] ?? 0,
            'harsh_brake_duration' => $this->toSeconds($row['harshbrakingduration'] ?? '0:00:00'),

            'idle_score' => $row['excessiveidlescore'] ?? 0,
            'idle_occ' => $row['excessiveidleoccurences'] ?? 0,
            'idle_duration' => $this->toSeconds($row['excessiveidleduration'] ?? '0:00:00'),

            'greenband_percentage' => $row['greenbanddrivingdurationpercentage'] ?? 0,
            'greenband_duration' => $this->toSeconds($row['greenbandduration'] ?? '0:00:00'),

            'overall_score' => $row['overallscore'] ?? 0,

        ]);
    }

    private function toSeconds($time)
    {

        // Converts "H:i:s" string to seconds
        if (empty($time)) return 0;
         if (is_numeric($time)) {
        return (int) round($time * 86400);
    }
        [$h, $m, $s] = array_pad(explode(':',$time), 3, 0);
        return ($h * 3600) + ($m * 60) + $s;
    }




  private function excelTimeToTime($value)
{
    if ($value === null || $value === '') {
        return null;
    }

    $seconds = round($value * 86400); // seconds in a day
    return Carbon::createFromTime(0, 0, 0)
        ->addSeconds($seconds)
        ->format('H:i:s');
}
}
