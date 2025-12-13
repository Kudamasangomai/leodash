<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaultRequest;
use App\Http\Requests\UpdateFaultRequest;
use App\Models\Fault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FaultController extends Controller
{
       public function index()
    {

        return Inertia::render('faults/faults',[
            'faults' => Fault::all()
        ]);
    }

    public function store(StoreFaultRequest $request)
    {

        Fault::create($request->validated());
        return Redirect::back();
    }

    public function update(UpdateFaultRequest $request , Fault $fault){

        $fault->update($request->validated());
        return Redirect::back();
    }
}
