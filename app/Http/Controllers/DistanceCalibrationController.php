<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistanceCalibrationRequest;
use App\Http\Requests\UpdateDistanceCalibrationRequest;
use App\Models\DistanceCalibration;
use App\Models\Truck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DistanceCalibrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $calibrations = DistanceCalibration::with('user', 'truck')
            ->paginate(50);

        return Inertia::render('DistanceCalibrations/calibrations', [
            'calibrations' => $calibrations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('DistanceCalibrations/Create');
    }

    /**
     * Store a newly created resource in storage.
     * Creates a separate record for each truck in the comma-separated list.
     */
    public function store(StoreDistanceCalibrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $trucks = $validated['trucks'] ?? [];
        $userId = $request->user()->id;

        // Create a separate record for each truck
        foreach ($trucks as $unitname) {
            $truck = Truck::where('unitname', trim($unitname))->first();

            if ($truck) {
                DistanceCalibration::create([
                    'truck_id' => $truck->id,
                    'user_id' => $userId,
                ]);
            }
        }
        return redirect()->route('dstcalibrations.index')->with('success', 'Records created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(DistanceCalibration $distanceCalibration): Response
    {
        return Inertia::render('DistanceCalibrations/Show', [
            'calibration' => $distanceCalibration->load('creator'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistanceCalibration $dstcalibration): Response
    {
        $calibration = DistanceCalibration::with('truck')->findOrFail($dstcalibration->id);

        return Inertia::render('DistanceCalibrations/Edit', [
            'calibration' =>  $calibration
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistanceCalibrationRequest $request, DistanceCalibration $dstcalibration)
    {


        $dstcalibration->update($request->validated());

        return Redirect::route('dstcalibrations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistanceCalibration $dstcalibration)
    {

        $dstcalibration->delete();
        return Redirect::back();
    }
}
