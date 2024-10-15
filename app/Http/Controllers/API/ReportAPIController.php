<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAPIController extends Controller
{
    public function stock($fromDate, $type)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));

        $query = DB::select("CALL spReportStock('$fromDate')");
        return response()->json($query);
    }  
    
    public function buying($fromDate, $type)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));

        $query = DB::select("CALL spReportBuying('$fromDate')");
        return response()->json($query);
    }    

    public function selling($fromDate, $type)
    {
        $query = DB::select("CALL spReportSelling('$fromDate')");
        return response()->json($query);
    }  
    
    public function cashflows($fromDate, $type)
    {
        $query = DB::select("CALL spReportCashflow('$fromDate')");
        return response()->json($query);
    }  
    
    public function accounting($fromDate, $toDate)
    {
        $query = DB::select("CALL spReportJournal('$fromDate', '$toDate')");
        return response()->json($query);
    }      
}
