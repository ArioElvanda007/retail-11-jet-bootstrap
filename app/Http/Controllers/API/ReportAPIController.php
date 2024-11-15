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
        $fromDate = date('Y-m-d', strtotime($fromDate));

        $query = DB::select("CALL spReportSelling('$fromDate')");
        return response()->json($query);
    }  
    
    public function cashflows($fromDate, $type)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));

        $query = DB::select("CALL spReportCashflow('$fromDate')");
        return response()->json($query);
    }  
    
    public function accounting($fromDate, $toDate)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));
        $toDate = date('Y-m-d', strtotime($toDate));
        
        $query = DB::select("CALL spReportJournal('$fromDate', '$toDate')");
        return response()->json($query);
    }      

    public function ledger($fromDate, $toDate, $opt)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));
        $toDate = date('Y-m-d', strtotime($toDate));
        
        $query = DB::select("CALL spReportLedger('$fromDate', '$toDate', $opt)");
        return response()->json($query);
    }
    
    public function ledgerDaily($fromDate, $opt)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));
        
        $query = DB::select("CALL spReportLedger_Daily('$fromDate', $opt)");
        return response()->json($query);
    } 
    
    public function ledgerMonthly($fromDate, $opt)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));
        
        $query = DB::select("CALL spReportLedger_Monthly('$fromDate', $opt)");
        return response()->json($query);
    }
    
    public function ledgerYearly($fromDate, $opt)
    {
        $fromDate = date('Y-m-d', strtotime($fromDate));
        
        $query = DB::select("CALL spReportLedger_Yearly('$fromDate', $opt)");
        return response()->json($query);
    }    
}
