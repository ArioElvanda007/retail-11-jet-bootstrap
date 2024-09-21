<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAPIController extends Controller
{
    public function stock($fromDate, $type)
    {
        $query = DB::select("CALL spReportStock('$fromDate')");
        return response()->json($query);
    }  
    
    public function buying($fromDate, $type)
    {
        $query = DB::select("CALL spReportBuying('$fromDate')");
        return response()->json($query);
    }      
}
