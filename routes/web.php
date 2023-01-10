<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiTrackingController;
use App\ApiTracking;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\SMSReportsController;
use App\Http\Controllers\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


//Reports
Route::get('smsreports', [App\Http\Controllers\DisplayDataController::class, 'smsreports'])->name('smsreports');
Route::get('smsreportscreate', [App\Http\Controllers\DisplayDataController::class, 'smsreportscreate'])->name('smsreportscreate');

Route::get('emailreports', [App\Http\Controllers\DisplayDataController::class, 'emailreports'])->name('emailreports');
Route::get('emailreportscreate', [App\Http\Controllers\DisplayDataController::class, 'emailreportscreate'])->name('emailreportscreate');





//

//Route::get('daterange', [App\Http\Controllers\HomeController::class, 'index'])->name('daterange.index');

//Route::get('daterange', [App\Http\Controllers\DateRangeController::class, 'sms'])->name('daterange');
Route::resource('user_reports', App\Http\Controllers\DateRangeController::class);
//Route::resource('sms_reports', App\Http\Controllers\SMSReportsController::class);
Route::get('smsreportscreate', [App\Http\Controllers\DisplayDataController::class, 'smsreportscreate'])->name('smsreportscreate');





//End Reports 
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/reports', [App\Http\Controllers\HomeController::class, 'reports'])->name('reports');
Route::get('/sms_reports', [App\Http\Controllers\HomeController::class, 'sms_reports'])->name('sms_reports');

// Verify 
Route::get('/verify-me', [App\Http\Controllers\VerifyController::class, 'contactForm'])->name('contact-form');

Route::post('/verify-me', [App\Http\Controllers\VerifyController::class, 'storeContactForm'])->name('contact-form.store');








Route::get('/export', [App\Http\Controllers\AjaxController::class, 'export']);
Route::post('/brochuresearch', [App\Http\Controllers\AjaxController::class, 'brochuresearch']);
Route::post('/brochurefetch', [App\Http\Controllers\AjaxController::class, 'brochurefetch']);
Route::get('/brochurecategory', [App\Http\Controllers\AjaxController::class, 'brochurecategory']);
Route::post('/brochureemail', [App\Http\Controllers\AjaxController::class, 'brochureemail']);
Route::post('/brochuresms', [App\Http\Controllers\AjaxController::class, 'brochuresms']);

Route::post('/brochurewhatsapp', [App\Http\Controllers\AjaxController::class, 'brochurewhatsapp']);

Route::get('/ajax', [App\Http\Controllers\AjaxController::class, 'ajax'])->name('ajax');

Route::get('/user/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
Route::get('/user/verify-practice/{id}', [App\Http\Controllers\UserController::class, 'verifypractice'])->name('user.verify-practice');

Route::put('/user/update-practice/{id}', [App\Http\Controllers\UserController::class, 'updatepractice'])->name('user.update-practice');










Route::get('/admin/user/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');

Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


Route::get('admin/users', [App\Http\Controllers\HomeController::class, 'adminUsers'])->name('admin.users')->middleware('is_admin');
Route::get('users/getusers', [App\Http\Controllers\HomeController::class, 'getusers'])->name('users.getusers');


Route::get('admin/brochures', [App\Http\Controllers\HomeController::class, 'adminBrochures'])->name('admin.brochures')->middleware('is_admin');

Route::get('admin/users/verify-me', [App\Http\Controllers\HomeController::class, 'adminVerify'])->name('admin.users.verify-me')->middleware('is_admin');

Route::get('admin/companies', [App\Http\Controllers\HomeController::class, 'adminCompanies'])->name('admin.companies')->middleware('is_admin');

Route::resource('users', UserController::class);


Route::get('send-mail', function () {

   

    $details = [

        'title' => 'Mail from ItSolutionStuff.com',

        'body' => 'This is for testing email using smtp'

    ];

   $email ="mavhungatapiwa@gmail.com";
   $name ="Tapiwa";
   $subject = "eedefef";

    \Mail::send('emails.myTestMail', [], function ($mail) {
    $mail->to('mavhungatapiwa@gmail.com')->subject('Does this work?');
});
   

    dd("Email is Sent.");

});




/**
 * Send an email and do processing on a model with the email
 */



// Track Brochure Views
// Route::get('/tracking/email/{timestamp}/{brochureid}', 'ApiTrackingController@trackEmailLinkBrochure')->name('track.email.brochure');

Route::get('/tracking/email/{timestamp}/{brochureid}', [App\Http\Controllers\ApiTrackingController::class, 'trackEmailLinkBrochure'])->name('track.email.brochure');


Route::get('/tracking/sms/{timestamp}/{brochureid}', [App\Http\Controllers\ApiTrackingController::class, 'trackSMSLinkBrochure'])->name('track.sms.brochure');

 //Route::get('/tracking/sms/{timestamp}/{brochureid}', 'ApiTrackingController@trackSMSLinkBrochure')->name('track.sms.brochure');

Route::get('/tracking/smscode/{timestamp}/{brochureid}/{smscode}', [App\Http\Controllers\ApiTrackingController::class, 'trackSMSCodeLinkBrochure'])->name('track.smscode.brochure');

// Route::get('/tracking/smscode/{timestamp}/{brochureid}/{smscode}', 'ApiTrackingController@trackSMSCodeLinkBrochure')->name('track.smscode.brochure');



//api sms responder
Route::get('/smsbrochure/', function () {
        dd("dghdgfgdgfhsdgf");
        $timestamp = time();
        $xmlarr = array(
                'keyword' => false,
                'to' => false,
                'from' => false,
                'eventDate' => false,
        );

    $xmldata = (isset($_GET['XMLDATA']))? urldecode($_GET['XMLDATA']): false;
    $xmldata = str_replace('<SMS_RECEIVE><RECEIVE_RESPONSE></XML>','</SMS_RECEIVE></RECEIVE_RESPONSE></XML>', $xmldata);
    //Log::debug($xmldata);

    $ob = simplexml_load_string($xmldata);

    //Log::debug(print_r($ob->RECEIVE_RESPONSE[0], true));

    $keywordjson = json_encode($ob->RECEIVE_RESPONSE[0]);
    $keywordarr = json_decode($keywordjson, true);
    $keyword = $keywordarr['SMS_RECEIVE'];
    $xmlarr['keyword'] = $keyword;

        $tojson = json_encode($ob->RECEIVE_RESPONSE->SMS_RECEIVE['to']);
        $toarr = json_decode($tojson, true);
    $xmlarr['to'] = $toarr[0];

        $fromjson = json_encode($ob->RECEIVE_RESPONSE->SMS_RECEIVE['from']);
        $fromarr = json_decode($fromjson, true);
    $xmlarr['from'] = $fromarr[0];

        $eventDatejson = json_encode($ob->RECEIVE_RESPONSE->SMS_RECEIVE['eventDate']);
        $eventDatearr = json_decode($eventDatejson, true);
    $xmlarr['eventDate'] = $eventDatearr[0];

    //Log::debug(print_r($xmlarr, true));

    //Log::debug(print_r($xmlarr['keyword'], true));

     $conditions = array(
        'health',
        'contact'
    );

    if(!in_array(strtolower($keyword), $conditions)){

        //Log::debug('BROCHURE KEYWORD REQUEST');
        /* get health basket brochure ids*/
        $bids = array();
        $bf = BrochureField::where('title', 'Health Basket')->first();
        if($bf):
            $bfvs = BrochureFieldValues::where('field_id', $bf->id)->distinct()->get();
            foreach($bfvs as $bfv){
                if(stripos($bfv->value, $keyword) !== false){
                    $bids[] = $bfv->brochure_id;
                }
            }
        endif;
        //$brochures = Brochure::where('title', 'LIKE', '%'.$xmlarr['keyword'].'%')->get();

        /*if(count($brochures) > 0){
            foreach($brochures as $brochure){
                $bids .= $brochure->id.',';
            }
        }
        $bids = substr($bids, 0, -1);*/

        ApiTracking::trackRequest('brochure-sms-responder/'.trim($xmlarr['from']).'/'.implode(',', $bids).'/'.$timestamp.'/'.trim($xmlarr['to']));


  $body_msg = '';
        $brochures = Brochure::find($bids); //Brochure::where('title', 'LIKE', '%'.$xmlarr['keyword'].'%')->get();
        if(count($brochures) > 0){
            $body_msg = 'Click link below for Medinformer health info:'."\n"."\n";
            foreach($brochures as $brochure){
                Log::debug(print_r($brochure, true));
                $trackurl = route('track.smscode.brochure', ['timestamp' => $timestamp, 'brochureid' => $brochure->id, 'smscode' => trim($xmlarr['to'])] );
                Log::debug($trackurl);
                $bitlyobj = json_decode(
                    file_get_contents(
                        "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($trackurl)."&format=json"
                    )
                )->data->url;
                $body_msg .= $brochure->title.": ";
                $body_msg .= $bitlyobj."\n"."\n";
            }
        }

    } else {
        //Log::debug('MANUAL KEYWORD REQUEST');
        //Log::debug(print_r($keyword, true));
        //$body_msg = '';
        switch(strtolower($keyword)):
            case 'health':
                $body_msg = 'Click link below for Medinformer health info:'."\n"."\n";
                $qrlanding = 'https://www.medinformer.co.za/medinformer-qrlanding/';
                if($xmlarr['to'] == '39291'){
                    $qrlanding = 'https://www.medinformer.co.za/dischem-qrlanding/';
                }
                $bitlyobj = json_decode(
                    file_get_contents(
                        "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($qrlanding)."&format=json"
                    )
                )->data->url;
                $body_msg .= $bitlyobj."\n"."\n";
            break;
            case 'contact':
                $body_msg = 'Click link and fill out contact form:'."\n"."\n";
                $url = 'https://www.medinformer.co.za/conference-contacts/';
 /*if($xmlarr['to'] == '39291'){
                    $qrlanding = 'https://www.medinformer.co.za/dischem-qrlanding/';
                }*/
                $bitlyobj = json_decode(
                    file_get_contents(
                        "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($url)."&format=json"
                    )
                )->data->url;
                $body_msg .= $bitlyobj."\n"."\n";
            break;
        endswitch;

    }
    $body = '
    <XML>
                <SENDBATCH delivery_report="1" status_report="1">
                        <SMSLIST>
                                <SMS_SEND uid="'.$timestamp.'" user="43587887" password="jNXqa6" to="'.$xmlarr['from'].'">'.$body_msg.'</SMS_SEND>
                        </SMSLIST>
                </SENDBATCH>
        </XML>';
    //Log::debug(print_r($body, true));

        $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://sg1.channelmobile.co.za');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    // execute curl setup.
    $return = curl_exec($ch);

    // close curl connection.
    curl_close($ch);

        return '';

})->name('home.sms.responder');


/*
 * Vehicles Routes
 */

/*
 * Users Routes
 */
Route::resource('users', App\Http\Controllers\UsersController::class);

Route::resource('allreports', App\Http\Controllers\ReportsController::class);


Route::get('export_users', [App\Http\Controllers\ExportController::class, 'export_users'])->name('export_users');


/*
 * Users Routes
 */
