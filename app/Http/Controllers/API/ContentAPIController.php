<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentAPIController extends Controller
{
    public function dashboard()
    {
        $query = DB::select("CALL spContentDashboard()");
        return response()->json($query);
    }     
}
