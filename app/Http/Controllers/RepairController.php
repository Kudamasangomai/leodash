<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Truck;
use Inertia\Inertia;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Models\Fault;
use App\Models\User;
use App\Services\FetchLocationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index(Request $request)
    {
        $repairs = Repair::query()
            ->when(request('q'), function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->whereHas('truck', function ($query) use ($q) {
                        $query->where('unitname', 'like', "%{$q}%");
                    })
                        ->orWhereHas('fault', function ($query) use ($q) {
                            $query->where('name', 'like', "%{$q}%");
                        });
                });
            })->with(['truck', 'user', 'fault', 'doneBy'])
            ->orderByRaw("(status = 'pending') DESC")
            ->orderBy('last_reported_at', 'ASC')
            ->paginate(100)
            ->withQueryString();

        return Inertia::render('Repairs/repairs', [
            'repairs' => $repairs,
            'trucks' => Truck::all(),
            'faults' => Fault::all(),
            'users' =>  User::all(),
        ]);
    }

    public function store(StoreRepairRequest $request)
    {

        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $haspendingrepair = Repair::hasPendingReapir($validated['fault_id'], $validated['truck_id']);

        if ($haspendingrepair) {
            return back()->with('warning', $haspendingrepair);
        }

        Repair::create($validated);
        return back()->with('success', 'Record created Successful');
    }

    public function show(Repair $repair)
    {
        return Inertia::render('Repairs/Show', [
            'repair' => $repair->load(['truck', 'user']),
        ]);
    }

    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        $validated = $request->validated();
        $repair->update($validated);
        return redirect()->back();
    }


    public function closerepair(Request $request, $id)
    {


        $repair = Repair::findOrFail($id);
        $repairdata = $request->validate([
            'comments' => 'required',
        ]);

        $repair->update(
            $repairdata + [
                'status' => 'completed',
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
}
