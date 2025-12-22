<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel as ExcelService;
use App\Imports\LightVehicleImport;
use App\Models\lightvehiclescoring;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class LightvehiclescoringController extends Controller
{
     public function index(Request $request)
    {
        $data = LightVehicleScoring::query()->select(
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


           // Filter by truck if selected
    if ($request->filled('truck_id')) {
        $truck = Truck::find($request->truck_id);
        if ($truck) {
            $data->where('asset_name', $truck->unitname);
        }
    }

     // Filter by datetime range
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $data->where(function ($q) use ($request) {
            $q->whereRaw("CONCAT(start_date, ' ', start_time) <= ?", [$request->end_date])
              ->whereRaw("CONCAT(start_date, ' ', end_time) >= ?", [$request->start_date]);
        });
    }

        // Execute query
    $report = $data;

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



    public function store(Request $request)
    {
        // $data = lightvehiclescoring::whereBetween('start_date', [
        //     $request->from_date,
        //     $request->to_date
        // ])
        //     ->whereBetween('start_time', [
        //         $request->from_time,
        //         $request->to_time
        //     ]);

        // return [
        //     'total_duration' => gmdate('H:i:s', $data->sum('duration_seconds')),
        //     'overspeed_score' => round($data->avg('overspeed_score'), 2),
        //     'overspeed_occ' => $data->sum('overspeed_occ'),
        //     'overspeed_max' => $data->max('overspeed_max'),
        //     'overall_score' => round($data->avg('overall_score'), 2),
        // ];
    }

    public function scoringReport(Request $request)
    {

        // dd($request);

        // $truck = Truck::where('id',$request->truck_id)->first();

        // $request->validate([
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date',
        //     'asset_name' => 'nullable|string',
        // ]);

        // $data = LightVehicleScoring::query()
        //     ->whereBetween('start_date', [
        //         // Carbon::parse($request->start_date)->startOfDay(),
        //         // Carbon::parse($request->end_date)->endOfDay()

        //         $request->start_date,
        //         $request->end_date
        //     ]);

        // if ($request->truck_id) {
        //     $data->where('asset_name', $truck->unitname);

        //      return [
        //         // 'total_duration' => gmdate('H:i:s', $data->sum('duration_seconds')),
        //         'overspeed_score' => round($data->avg('overspeed_score'), 2),
        //         'overspeed_occ' => $data->sum('overspeed_occ'),
        //         'overspeed_max' => $data->max('overspeed_max'),
        //         'overall_score' => round($data->avg('overall_score'), 2),
        //     ];
        // }


        // // Group by truck if no specific truck is selected
        // $report = LightVehicleScoring::select(
        //     'asset_name',
        //     DB::raw('SUM(distance_km) as total_distance'),
        //     DB::raw('SUM(duration_seconds) as total_duration'),
        //     DB::raw('SUM(overspeed_score) as overspeed_score'),
        //     DB::raw('SUM(overspeed_occ) as overspeed_occ'),
        //     DB::raw('MAX(overspeed_max) as overspeed_max'),
        //     DB::raw('SUM(overspeed_duration) as overspeed_duration'),
        //     DB::raw('SUM(overrev_score) as overrev_score'),
        //     DB::raw('SUM(overrev_occ) as overrev_occ'),
        //     DB::raw('MAX(overrev_max) as overrev_max'),
        //     DB::raw('SUM(overrev_duration) as overrev_duration'),
        //     DB::raw('SUM(harsh_acc_score) as harsh_acc_score'),
        //     DB::raw('SUM(harsh_acc_occ) as harsh_acc_occ'),
        //     DB::raw('MAX(harsh_acc_max) as harsh_acc_max'),
        //     DB::raw('SUM(harsh_acc_duration) as harsh_acc_duration'),
        //     DB::raw('SUM(harsh_brake_score) as harsh_brake_score'),
        //     DB::raw('SUM(harsh_brake_occ) as harsh_brake_occ'),
        //     DB::raw('MAX(harsh_brake_max) as harsh_brake_max'),
        //     DB::raw('SUM(harsh_brake_duration) as harsh_brake_duration'),
        //     DB::raw('SUM(idle_score) as idle_score'),
        //     DB::raw('SUM(idle_occ) as idle_occ'),
        //     DB::raw('SUM(idle_duration) as idle_duration'),
        //     DB::raw('AVG(greenband_percentage) as greenband_percentage'),
        //     DB::raw('SUM(greenband_duration) as greenband_duration'),
        //     DB::raw('SUM(overall_score) as overall_score'),
        // )
        // ->groupBy('asset_name')
        // ->get();
        // dd($report);
        // return Inertia::render('ScoringReport', [
        //     'report' => $report,
        // ]);
    }

}
