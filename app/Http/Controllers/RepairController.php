<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RepairsExport;
use App\Models\Repair;
use App\Models\Truck;
use Inertia\Inertia;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Models\Fault;
use App\Models\User;
use App\Services\FetchLocationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class RepairController extends Controller
{
    public function index()
    {
        $repairs = Repair::query()
            ->search(request('q'))
            ->with(['truck', 'user', 'fault', 'doneBy'])
            ->orderByRaw("(status = 'pending') DESC")
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return Inertia::render('Repairs/repairs', [
            'repairs' => $repairs,
            'trucks' => Truck::all(), // get only the columns you need
            'faults' => Fault::all(),
            'users' =>  User::all(),
        ]);
    }

    public function store(StoreRepairRequest $request)
    {

        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $haspendingrepair = Repair::hasPendingRepair($validated['fault_id'], $validated['truck_id']);

        if ($haspendingrepair) {
            return back()->with('warning', $haspendingrepair);
        }

        Repair::create($validated);
        return back()->with('success', 'Record created Successful');
    }

    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        $validated = $request->validated();
        $repair->update($validated);
        return redirect()->route('repairs.index')->with('success', 'Records created successfully');
    }


    public function closerepair(Request $request, $id)
    {

        $repair = Repair::findOrFail($id);
        $repairdata = $request->validate([
            'comments' => 'required',
            'repairedondate' => 'required|date|before_or_equal:today',
        ]);

        $repair->update(
            $repairdata + [
                'status' => 'completed', // use enum class
                'done_by' => $request->donebyid,
            ]
        );
        return back()->with('success', 'Record Completed Successfully');
    }

    public function destroy(Repair $repair)
    {
        $repair->delete();
        return redirect()->back();
    }


    public function fetchLocations(FetchLocationService $service): RedirectResponse
    {
        $result = $service->fetchAndUpdate();
        $message = "Processed {$result['processed']} positions; updated {$result['updated']} repair(s).";
        return redirect()->back()->with('success', $message);
    }


    // public function export()
    // {
    //    $repairs = Repair::with(['truck', 'user', 'fault', 'doneBy'])->get();
    //     return response()->json($repairs);
    // }


    public function exportExcel(Request $request)
    {

        $validated = $request->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ]);

        $fileName = 'LeoDashRepairs_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new RepairsExport($validated['fromDate'], $validated['toDate']),
            $fileName
        );
    }
}
