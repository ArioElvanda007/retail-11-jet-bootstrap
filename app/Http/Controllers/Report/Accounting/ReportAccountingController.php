<?php

namespace App\Http\Controllers\Report\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportAccountingController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.accounting.index", 'name' => "Report Balance"]
        ];

        $date_from = Carbon::now()->addDays(-31);
        $date_to = Carbon::now();        
        return view('content.report.accounting.index', compact('date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);
    }  
}
