<?php

namespace App\Http\Controllers\Report\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportStockController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "buying.buying.index", 'name' => "Stocks"]
        ];

        $date_from = Carbon::now();

        return view('content.report.stocks.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }    
}
