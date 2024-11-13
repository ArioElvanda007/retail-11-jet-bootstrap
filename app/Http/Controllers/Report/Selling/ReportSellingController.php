<?php

namespace App\Http\Controllers\Report\Selling;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportSellingController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    public function index()
    {
        if (app($this->can_access())->access('report selling')->access[0]->modules->is_active == 0 || app($this->can_access())->access('report selling')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.selling.index", 'name' => "Report Selling"]
        ];

        $date_from = Carbon::now();
        return view('content.report.selling.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }       
}
