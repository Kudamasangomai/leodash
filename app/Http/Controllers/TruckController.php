<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\FetchTruckService;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $trucks = Truck::all();

        return Inertia::render('Trucks/trucks', [
            'trucks' => $trucks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Trucks/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTruckRequest $request): RedirectResponse
    {
        Truck::create($request->validated());

        return Redirect::route('trucks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Truck $truck): Response
    {
        return Inertia::render('Trucks/Show', [
            'truck' => $truck,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Truck $truck): Response
    {
        return Inertia::render('Trucks/Edit', [
            'truck' => $truck,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTruckRequest $request, Truck $truck): RedirectResponse
    {
        $truck->update($request->validated());

        return Redirect::route('trucks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Truck $truck): RedirectResponse
    {
        $truck->delete();

        return Redirect::route('trucks.index');
    }

    /**
     * Fetch trucks from external XML API and import new unitnames.
     */
    public function fetch(Request $request, FetchTruckService $service)
    {
        try {
            $result = $service->fetchFromXmlApi();
            $msg = "Fetched {$result['total']} rows, inserted {$result['inserted']} new trucks.";
            return redirect()->back()->with('success', $msg);
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }
}
