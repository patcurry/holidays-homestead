<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Contracts\Auth\Factory as Auth;

use Saml2;

//use App\Http\Controllers\SetsController;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\MessageBag;

use Datetime;
use Illuminate\Support\Facades\Input;
use Validator;
use File;

use App\CustomClass\DateTools;


class ECMSController extends Controller
{
    public function __construct()
    {
       //$this->middleware('auth:api');
       //$this->middleware('auth:api',['except' =>['test']] ); 
    }

    public function hello()
    { 
        return "Hallo! Hier ist der ECMSController";
    } 
    
    public function holidays($year)
    { 
        
        $dt = new DateTools;
        $dt->getHolidays($year);
        return json_encode($dt->holidays);
    }  
    
    //public function countWorkdays($from, $to, Request $request)
    public function countWorkdays(Request $request)
    { 
    /*
     * put weil Daten übertragen werden
     * In http/Middelware/VerifyCsrfToken.php ist Tokenprüfung für
     * diese Fruppe ausgeschaltet
     * 
     */    
        $dt = new DateTools;
        $count = $dt->WorkDays($request->from, $request->to);
        //$count = $dt->WorkDays($from, $to);
        $arr = array('workdays' => $count, 'user' => 'tra');
        return json_encode($arr);
    }      
    
} // class end

