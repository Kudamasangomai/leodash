<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel as ExcelService;
use App\Imports\LightVehicleImport;
use App\Models\Lightvehiclescoring;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class LightvehiclescoringController extends Controller
{
     public function index(Request $request)
    {
        $report = Lightvehiclescoring::select(
            'asset_name',
            DB::raw('SUM(distance_km) as total_distance'),
            DB::raw('SUM(duration_seconds) as total_duration'),


            DB::raw('MAX(overspeed_max) as overspeed_max'),
            DB::raw('SUM(overspeed_occ) as overspeed_occ'),
            DB::raw('CAST(AVG(overspeed_score) AS DECIMAL(5,2)) as overspeed_score'),

            DB::raw('MAX(overrev_max) as overrev_max'),
            DB::raw('SUM(overrev_occ) as overrev_occ'),
            DB::raw('CAST(AVG(overrev_score) AS DECIMAL(5,2)) as overrev_score'),

            DB::raw('MAX(harsh_acc_max) as harsh_acc_max'),
            DB::raw('SUM(harsh_acc_occ) as harsh_acc_occ'),
            DB::raw('CAST(AVG(harsh_acc_score) AS DECIMAL(5,2)) as harsh_acc_score'),

            DB::raw('MAX(harsh_brake_max) as harsh_brake_max'),
            DB::raw('SUM(harsh_brake_occ) as harsh_brake_occ'),
            DB::raw('CAST(AVG(harsh_brake_score) AS DECIMAL(5,2)) as harsh_brake_score'),

            DB::raw('SUM(idle_occ) as idle_occ'),
            DB::raw('CAST(AVG(idle_score) AS DECIMAL(5,2)) as idle_score'),
            DB::raw('SUM(idle_duration) as idle_duration'),


            DB::raw('CAST(AVG(greenband_percentage) AS DECIMAL(5,2)) as greenband_percentage'),
            DB::raw('SUM(greenband_duration) as greenband_duration'),


            DB::raw('CAST(AVG(overall_score) AS DECIMAL(5,2)) as overall_score'),
        )
            ->groupBy('asset_name')
            ->get();

        return Inertia::render('Lightvehiclescoring/lightvehiclescoring', [

            'report' => $report,
            'trucks' => Truck::all(),
        ]);
    }

    public function upload(Request $request, ExcelService $excel)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);
        DB::table('lightvehiclescorings')->truncate();
        $excel->import(new LightVehicleImport, $request->file('file'));
        return back()->with('success', 'File uploaded successfully');
    }

}
