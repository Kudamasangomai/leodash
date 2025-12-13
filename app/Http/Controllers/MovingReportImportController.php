<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MovingReportImport;
use Illuminate\Support\Facades\DB;
// use ProtoneMedia\Splade\Facades\Toast;

class MovingReportImportController extends Controller
{
      public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        DB::table('moving_reports')->truncate();

        Excel::import(new MovingReportImport, $request->file('file'));

        // Toast::title('File uploaded and processed successfully.')
        //     ->success()->center()->backdrop()->autoDismiss(2);
        // return redirect()->route('early-start');
    }
}
