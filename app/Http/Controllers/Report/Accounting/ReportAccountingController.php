<?php

namespace App\Http\Controllers\Report\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportAccountingController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    public function index()
    {
        if (app($this->can_access())->access('report accounting')->access[0]->modules->is_active == 0 || app($this->can_access())->access('report accounting')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.accounting.index", 'name' => "Report Balance"]
        ];

        $date_from = Carbon::now()->addDays(-31);
        $date_to = Carbon::now();        
        return view('content.report.accounting.index', compact('date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);
    }  
}
