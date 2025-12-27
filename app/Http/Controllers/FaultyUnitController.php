<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaultyUnitRequest;
use App\Http\Requests\UpdateFaultyUnitRequest;
use App\Models\FaultyUnit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaultyUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $faultyunits = FaultyUnit::all();
        return Inertia::render('FaultyUnits/faultyunits', [
            'faultyunits' => $faultyunits,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaultyUnitRequest $request)
    {


        FaultyUnit::create($request->validated()  + [
            'user_id' => $request->user()->id,
        ]);
        return back()->with('success', 'Record created Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaultyUnitRequest $request, FaultyUnit $faultyunit)
    {
        $faultyunit->update($request->validated());
        return redirect()->back()->with('success','Record Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaultyUnit $faultyunit)
    {
        $faultyunit->delete();
              return redirect()->back()->with('success','Record Deleted Successfully');

    }
}
