<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MovingReportImport;
use Illuminate\Support\Facades\DB;


class MovingReportImportController extends Controller
{
      public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        DB::table('moving_reports')->truncate();

        Excel::import(new MovingReportImport, $request->file('file'));
    }
}
