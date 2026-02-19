<?php

namespace App\Exports;

use App\Models\Repair;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RepairsExport implements FromQuery, WithHeadings, WithMapping
{
    private $fromDate;
    private $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function query()
    {
        return Repair::query()
            // ->whereBetween('created_at', [$this->fromDate , $this->toDate])
            ->WhereBetween('repairedondate', [$this->fromDate, $this->toDate])
            ->with(['truck', 'fault', 'user', 'doneBy'])
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date Created',
            'Truck',
            'Fault',
            'Status',
            'Location',
            'Last Reported At',
            'Last Checked At',
            'Created By',
            'Repaired By',
            'Repaired On',
            'Comments',
        ];
    }

    public function map($repair): array
    {
        return [
            $repair->created_at,
            $repair->truck->unitname,
            $repair->fault->name,
            $repair->status,
            $repair->location ?? 'N/A',
            $repair->last_reported_at,
            $repair->last_check_at ?? 'N/A',
            $repair->user->name,
            $repair->doneBy?->name ?? 'N/A',
            $repair->repairedondate ?? 'N/A',
            $repair->comments,
        ];
    }
}