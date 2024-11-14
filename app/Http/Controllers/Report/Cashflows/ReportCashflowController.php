<?php

namespace App\Http\Controllers\Report\Cashflows;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportCashflowController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    public function index()
    {
        if (app($this->can_access())->access('report cashflows')->access->count() == 0 || app($this->can_access())->access('report cashflows')->access[0]->modules->is_active == 0 || app($this->can_access())->access('report cashflows')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.cashflows.index", 'name' => "Report Cashflows"]
        ];

        $date_from = Carbon::now();
        return view('content.report.cashflows.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }       
}
