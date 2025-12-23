<?php

namespace App\Http\Controllers;

use App\Imports\EventsReportImport;
use App\Models\Violation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class ViolationController extends Controller
{

    public function index()
    {
        $violations = Violation::orderBy('event_type')
            ->orderByDesc('max_speed')
            ->take(500)
            ->get()
                  ->groupBy('event_type');
        return Inertia::render('Violations/violations', [
            'violations' => $violations,
        ]);
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        DB::table('violations')->truncate();
        Excel::import(
            new EventsReportImport,
            $request->file('file')
        );

        $violations = Violation::latest()->take(500)->get();
        return Redirect::back()->with('',$violations);

    }
}
