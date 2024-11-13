<?php

namespace App\Http\Controllers\Function;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Module;

class GlobalController extends Controller
{
    public static function access($module = '') {
        if ($module == '') { //call all module
            $query = User::with(['access', 'access.modules'])->where('id', Auth::user()->id)->first();                
        }
        else if ($module != '') { //call 1 module
            $data = Module::where('name', '=', $module)->first();

            $query = User::with(['access' => function($q) use($data) {
                $q->where('module_id', '=', $data->id);
            }, 'access.modules'])->where('id', Auth::user()->id)->first();                
        }

        return $query;
    }   
}
