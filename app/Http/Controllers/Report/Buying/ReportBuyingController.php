<?php

namespace App\Http\Controllers\Report\Buying;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportBuyingController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.buying.index", 'name' => "Report Buying"]
        ];

        $date_from = Carbon::now();
        return view('content.report.buying.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }      
}
