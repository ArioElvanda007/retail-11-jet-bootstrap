<?php

namespace App\Http\Controllers\Report\Buying;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportBuyingController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    public function index()
    {
        if (app($this->can_access())->access('report buying')->access->count() == 0 || app($this->can_access())->access('report buying')->access[0]->modules->is_active == 0 || app($this->can_access())->access('report buying')->access[0]->can_view == 0) {
            return abort(401);
        }

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.buying.index", 'name' => "Report Buying"]
        ];

        $date_from = Carbon::now();
        return view('content.report.buying.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }      
}
