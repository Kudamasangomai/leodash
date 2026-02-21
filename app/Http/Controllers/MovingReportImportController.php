<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MovingReportImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MovingReportImportController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {

            DB::table('moving_reports')->truncate();
            Excel::import(new MovingReportImport, $request->file('file'));
            return Redirect::back();
        } catch (\Throwable $th) {
            return back()->withErrors('warning', 'Something is Wrong with your file');
        }
    }
}
