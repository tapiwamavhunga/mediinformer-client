<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class WhatsRangeController extends Controller

{

    function index(Request $request)

    {

        if(request()->ajax()) {


            if(!empty($request->from_date)) {


                $data = DB::table('whatsapp')

                    ->whereBetween('created_at', array($request->from_date, $request->to_date))

                    ->get();


            } else {


                $data = DB::table('whatsapp')

                    ->get();


            }


            return datatables()->of($data)->make(true);

        }


        return view('user_reports');

    }



  

}