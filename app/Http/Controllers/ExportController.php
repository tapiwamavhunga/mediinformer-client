<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\User;
use App\Models\SMS;
use App\Models\Emails;

class ExportController extends Controller
{
    //

    public function export_users(){
        $users = User::all();


    // Export all users
    // (new FastExcel($users))->export('file.xlsx');
    return (new FastExcel(User::all()))->download('file.xlsx');
    }
}
