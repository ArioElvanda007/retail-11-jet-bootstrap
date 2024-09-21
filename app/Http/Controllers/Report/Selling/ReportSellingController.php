<?php

namespace App\Http\Controllers\Report\Selling;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportSellingController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.selling.index", 'name' => "Report Selling"]
        ];

        $date_from = Carbon::now();
        return view('content.report.selling.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }       
}
