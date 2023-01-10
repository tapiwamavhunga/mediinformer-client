<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
use Corcel\Acf\Field\BasicField;
use Corcel\Acf\FieldFactory;
use Corcel\Acf\Field\PostObject;
use App\Models\User;
use App\Models\SMS;
use App\Models\Whatsapp;

use App\Models\Emails;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\FeedbackMail;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class AjaxController extends Controller
{
       protected function ajax(){
        echo "Helo";
       }

       public function exportCSV(Request $request){

        echo "string";
       }

       public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

       


  
    // ajax function.
    public function brochuresearch() {
        // Make your response and echo it.
        $authorid = \auth::user()->id;
        $searchfilter = $_POST['data']['search-filter'];
        $this->access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUwMTA3NzBkMDJkZGIyMmEyMzk1NzQ2ZGUyZTZlODBiYWRjYWVlYjMxZmY3ZjAwN2U5OGE1YjhjZDc0Y2YxYTYzYjRiMTk3NmFiMjIzNDg1In0.eyJhdWQiOiI3IiwianRpIjoiZTAxMDc3MGQwMmRkYjIyYTIzOTU3NDZkZTJlNmU4MGJhZGNhZWViMzFmZjdmMDA3ZTk4YTViOGNkNzRjZjFhNjNiNGIxOTc2YWIyMjM0ODUiLCJpYXQiOjE2NDYxMjI1NTMsIm5iZiI6MTY0NjEyMjU1MywiZXhwIjoyNTkyODkzNzUzLCJzdWIiOiIxMDAxIiwic2NvcGVzIjpbXX0.qVtvuBQc8M-szwpuf9BiOt81m_BBkxPXx2Bl_JIA3xx2RrHMWYIA_IoP7MyUoRkI_FzZqak9heDAALte9t15en6a8h9ohnn4twxVw9x6Ae_kIbPnOghcSeoqb2J6Azx701bCWiEmwBGlZyi9BiBkE5P37fpkPIyObqn2GZ52PBZG4c2Q0Mpv42r4kYVZkTlA-Z738lUmZxaw3Y7UUZFzARCr_a7mYdh0g4mXaKpo7uBC2ELxVTwvMwQ5PxHNyJS1U3CmuuW1oyUesqFrilqS6q7BUQhLGGovwsf-mZVCXl8fAcLfbLG_BRqlY365nuqDXpo8ZiKhkAcH7KFFZyULNiuPy0cG1POHygk0-tKatbOecjAZg5nvLbTTc2R984aEqpqztPiQIV3LUuZQ9dFv_KUa3yfPL2yl9diS5I6be-ITiqT8N35FToWGTPzwnN79xx6HwdA-IvvopmFC9OjvWtsjspWUtWT4BOB2bWas7HACVPVLavhW_jDDnLR_KUGNXsFXIRrP0ipGsjIJiO4nLNE4cXcc52VISSrY1lNyjDA68caDAuWiqj5EcVxt2i7n6wZEVjqoRmGggVzzxopeClngu77sUmPotmYn7j072tpPWWi0eeVXf-vhfGM153ET57Ignkmwq9Pz3-zg3AWfo4NL_l_7thfC0lztm3bz9Jg";
        
        $email_message = \auth::user()->email_message;
       $query_endpoint = "https://client.local/api/brochure-search";

       //$query_endpoint = "https://practitioner.medinformer.co.za/api/brochure-search";

        $postvars = array();
        /*$brochure_id = ($_POST['miapi_brochure_id'] != '')? $_POST['miapi_brochure_id']: false;
        if($brochure_id):
            $postvars['brochure_id'] = $brochure_id;
        endif;*/
        $brochure_search = ($_POST['data']['brochure_search'] != '')? $_POST['data']['brochure_search']: false;
        // if($brochure_search):
        //     if($searchfilter == 'search'){
        //         $postvars['search'] = $brochure_search;
        //     }
        //     if($searchfilter == 'icd10'){
        //         $postvars['icd10'] = $brochure_search;
        //     }
        // endif;
        /*$icd10 = ($_POST['miapi_icd10'] != '')? $_POST['miapi_icd10']: false;
        if($icd10):
            $postvars['icd10'] = $icd10;
        endif;*/
        if(count($postvars) == 0) $postvars = false;

            $results = $this->brochuresearches($brochure_search);
            // dd($results);
            ?>

            <?php if(isset($results)): ?>
            <div class='brochurelisting-tools'>
                <div class='backtobrochures'>
                    <span class='back-icon'><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M231.293 473.899l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L70.393 256 251.092 74.87c4.686-4.686 4.686-12.284 0-16.971L231.293 38.1c-4.686-4.686-12.284-4.686-16.971 0L4.908 247.515c-4.686 4.686-4.686 12.284 0 16.971L214.322 473.9c4.687 4.686 12.285 4.686 16.971-.001z"></path></svg></span>
                    <span>Search Again</span>
                </div>
                
                
                <div class='brochurecount'>
                    <div class='brochurecount-label'>Brochures:</div>
                    <div class='brochurecount-icon'>
                        <span class='back-icon'><svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="book-open" class="svg-inline--fa fa-book-open fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M576 62.75v337.84c0 16.23-13.13 29.77-30 30.66-49.47 2.6-149.52 12.1-218.7 46.92-10.65 5.36-23.28-1.94-23.28-13.49V100.81a15.37 15.37 0 0 1 7.27-13.17c67.24-41.16 176.16-52.48 231-55.59C560.64 31 576 45 576 62.75z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M264.73 87.64C197.5 46.48 88.58 35.17 33.78 32.05 15.36 31 0 45 0 62.75V400.6c0 16.24 13.13 29.78 30 30.66 49.49 2.6 149.59 12.11 218.77 46.95 10.62 5.35 23.21-1.94 23.21-13.46V100.63a15.05 15.05 0 0 0-7.25-12.99z"></path></g></svg></span>
                        <span><strong><?= count($results); ?></strong></span>
                    </div>
                </div>
            </div>
            
            <?php $this->showResultsHTML($results, $authorid); ?>

        <?php else: ?>
            <div class='no-results'> - <i>No results found for <strong></strong>, please try again. </i></div>
        <?php endif; ?>

        <?php
        // Don't forget to stop execution afterward.
        die();
    }
  

 

    public function queryapi($endpoint, $post=false, $access_token=false){

        $return = false;
        if($access_token){


            // set bearer token string.
            $authorization = "Authorization: Bearer ".$access_token;

            // start curl setup
            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if($post):
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

                //send brochure_id as array
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

                //set content type as multipart/form-data for posting data to api.
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data' , $authorization ));
            else:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            endif;

            // execute curl setup.
            $return = curl_exec($ch);

            // print_r($return);
            // die("efefefefefefef");


            // close curl connection.
            curl_close($ch);

        } else {

            $return = false;

        }

        return $return;
    }


    public function showResultsHTML($results, $authorid){

        //$accesstoken = ($this->access_token)? $this->access_token: get_user_meta( $authorid, 'access_token', true);

        $accesstoken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUwMTA3NzBkMDJkZGIyMmEyMzk1NzQ2ZGUyZTZlODBiYWRjYWVlYjMxZmY3ZjAwN2U5OGE1YjhjZDc0Y2YxYTYzYjRiMTk3NmFiMjIzNDg1In0.eyJhdWQiOiI3IiwianRpIjoiZTAxMDc3MGQwMmRkYjIyYTIzOTU3NDZkZTJlNmU4MGJhZGNhZWViMzFmZjdmMDA3ZTk4YTViOGNkNzRjZjFhNjNiNGIxOTc2YWIyMjM0ODUiLCJpYXQiOjE2NDYxMjI1NTMsIm5iZiI6MTY0NjEyMjU1MywiZXhwIjoyNTkyODkzNzUzLCJzdWIiOiIxMDAxIiwic2NvcGVzIjpbXX0.qVtvuBQc8M-szwpuf9BiOt81m_BBkxPXx2Bl_JIA3xx2RrHMWYIA_IoP7MyUoRkI_FzZqak9heDAALte9t15en6a8h9ohnn4twxVw9x6Ae_kIbPnOghcSeoqb2J6Azx701bCWiEmwBGlZyi9BiBkE5P37fpkPIyObqn2GZ52PBZG4c2Q0Mpv42r4kYVZkTlA-Z738lUmZxaw3Y7UUZFzARCr_a7mYdh0g4mXaKpo7uBC2ELxVTwvMwQ5PxHNyJS1U3CmuuW1oyUesqFrilqS6q7BUQhLGGovwsf-mZVCXl8fAcLfbLG_BRqlY365nuqDXpo8ZiKhkAcH7KFFZyULNiuPy0cG1POHygk0-tKatbOecjAZg5nvLbTTc2R984aEqpqztPiQIV3LUuZQ9dFv_KUa3yfPL2yl9diS5I6be-ITiqT8N35FToWGTPzwnN79xx6HwdA-IvvopmFC9OjvWtsjspWUtWT4BOB2bWas7HACVPVLavhW_jDDnLR_KUGNXsFXIRrP0ipGsjIJiO4nLNE4cXcc52VISSrY1lNyjDA68caDAuWiqj5EcVxt2i7n6wZEVjqoRmGggVzzxopeClngu77sUmPotmYn7j072tpPWWi0eeVXf-vhfGM153ET57Ignkmwq9Pz3-zg3AWfo4NL_l_7thfC0lztm3bz9Jg";

        if(isset($results)):
        
        ?>

            <div id='medclient-portfolios' class='medclient-portfolio-items'>

            <?php 
            foreach($results as $res): 
                    

                $this->showBrochureSearchHTML($res, $authorid);
            endforeach; 
            ?>

            </div>

        <?php else: ?>
            <div class='no-results'> - <i>No results found for <strong>'<?= $_POST['brochure_search']; ?>'</strong>, please try again. </i></div>
        <?php endif;

    }


    public function showBrochureHTML($result, $authorid){
        global $brochurefields;
        global $post;
        ?>
                <?php $result = (array)$result; ?>
                


                

                <style type="text/css">
                    .small_square{
    width: 170px;
    
    
}
                </style>

                <?php 
                $postScriptcontent = "Hello";      

                    ?>

            <?php 
            //$postScriptcontent = ['postscript'=>$result['type'] == "postscript", 
           // 'postscript_passcode'=>(isset($result['password'])? $result['password'] : null)
            //]; 

            // print_r($postScriptcontent);
            // die();

            ?>


                <div class='medclient-portfolio-item' style="background: #F2F2F2; padding:17px; margin-bottom: 10px; border-bottom: 1px solid #CECECE;">
                    <div class='medclient-portfolio-item-img'>
                        <a href='' target="_blank">

                            <img src='<?= $result['image']; ?>' class="small_square">
                        </a>
                    </div>
                    <div class='medclient-portfolio-item-details'>

                        
                        <h3>
                            <span>
                                <input type='checkbox' class='medclient_portfolio_chosen' name='medclient_portfolio_chosen' data-title='<?= $result['title']; ?>' data-id='<?= $result['id']; ?>'  data-href='' data-post="<?php echo $authorid;?>" id="EmailModal" data-content='<?php echo json_encode($postScriptcontent); ?>'>
                            </span>
                            <a href='#' target="_blank" style="font-size: 15px; color:#495057 !important;">
                                <?= $result['title']; ?> |   <?= $result['type']; ?> |   <?= $result['password']; ?>
                            </a>
                        </h3>
                        <div class='brochure-icd10-codes'><strong>ICD10:</strong> <?= $result['icd10']; ?></div>
                        <div class='brochure-hid'><?= $result['excerpt']; ?> </div>
                        <?php
                            $str = $result['title'];
                            $new_str = str_replace(' ', '-', $str);
                             // Outputs: Thisisasimplepieceoftext.
                            //echo $new_str;
                            ?>


                       <a class='view_Brochure' href='https://medinformer.co.za/health_subjects/<?= $new_str ?>' target="_blank" style="padding: 0px !important; padding-left: 10px !important;
padding-right: 10px !important; line-height:36px !important;">View Brochure</a>


                        


<input type="text"  value='#' id="idInputField" hidden>




                    </div>
                    <div class='medclient-clear-float'></div>
                </div>

                <style type="text/css">

                .quickaction-sms, .quickaction-email, .view_Brochure{
                    padding: 0px !important;
                    padding-left: 10px !important;
padding-right: 10px !important;
color:  #fff !important;
                }


                    .clsCopyBtn {
    background-color: #51bae1;
    color: #fff;
    line-height: 36px;
    padding: 0 15px;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.5px;
    display: inline-block;
    vertical-align: middle;
    border-radius: 3px;
    margin-right: 5px;
    margin-top: 15px;
    opacity: 1;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.24);
    border: none;
}

.quickaction-sms, .quickaction-email, .view_Brochure {
    background-color: #51bae1;
    color: #fff;
    line-height: 36px;
    padding: 10px;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.5px;
    display: inline-block;
    vertical-align: middle;
    border-radius: 3px;
    margin-right: 5px;
    margin-top: 15px;
    opacity: 1;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.24);
    border: none;
}

.medclient_portfolio_chosen {
    width: 18px;
    height: 18px;
    display: inline-block;
    vertical-align: middle;
    margin-top: 0px !important;
}

.project-tab a {
    color: #fff !important;
    cursor: pointer !important;
    font-weight: 700 !important;
    line-height: 1.15 !important;
    padding-bottom: 10px !important;
    font-size: 13.5px !important;
}
/*.view_Brochure{
    background-color: #66AA3B !important;
    color:  #fff !important;
}

.quickaction-email{
    background-color: #DD8051 !important;
    color:  #fff !important;
}

.view_Brochure{
    background-color: #18659B !important;
    color:  #fff !important;
    
}*/
                </style>
        <?php
    }

    //for search results
    public function showBrochureSearchHTML($result, $authorid){
        global $brochurefields;
        global $post;
        ?>
                <?php $result = (array)$result; ?>
                


                

                <style type="text/css">
                    .small_square{
    width: 170px;
    
    
}
                </style>

                <?php 
                $postScriptcontent = "Hello";      

                    ?>

            <?php 
            //$postScriptcontent = ['postscript'=>$result['type'] == "postscript", 
           // 'postscript_passcode'=>(isset($result['password'])? $result['password'] : null)
            //]; 

            // print_r($postScriptcontent);
            // die();

            ?>


                <div class='medclient-portfolio-item' style="background: #F2F2F2; padding:17px; margin-bottom: 10px; border-bottom: 1px solid #CECECE;">
                    <div class='medclient-portfolio-item-img'>
                        <a href='' target="_blank">

                            <img src='<?= $result['image']; ?>' class="small_square">
                        </a>
                    </div>
                    <div class='medclient-portfolio-item-details'>

                        
                        <h3>
                            <span>
                                <input type='checkbox' class='medclient_portfolio_chosen' name='medclient_portfolio_chosen' data-title='<?= $result['post_title']; ?>' data-id='<?= $result['ID']; ?>'  data-href='' data-post="<?php echo $authorid;?>" id="EmailModal" data-content='<?php echo json_encode($postScriptcontent); ?>'>
                            </span>
                            <a href='#' target="_blank" style="font-size: 15px; color:#495057 !important;">
                                <?= $result['post_title']; ?> 
                            </a>
                        </h3>
                        <div class='brochure-icd10-codes'><strong>ICD10:</strong> 100</div>
                        <div class='brochure-hid'>No content </div>
                        <?php
                            $str = $result['post_title'];
                            $new_str = str_replace(' ', '-', $str);
                             // Outputs: Thisisasimplepieceoftext.
                            //echo $new_str;
                            ?>


                       <a class='view_Brochure' href='https://medinformer.co.za/health_subjects/<?= $new_str ?>' target="_blank" style="padding: 0px !important; padding-left: 10px !important;
padding-right: 10px !important; line-height:36px !important;">View Brochure</a>


                        


<input type="text"  value='#' id="idInputField" hidden>




                    </div>
                    <div class='medclient-clear-float'></div>
                </div>

                <style type="text/css">

                .quickaction-sms, .quickaction-email, .view_Brochure{
                    padding: 0px !important;
                    padding-left: 10px !important;
padding-right: 10px !important;
color:  #fff !important;
                }


                    .clsCopyBtn {
    background-color: #51bae1;
    color: #fff;
    line-height: 36px;
    padding: 0 15px;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.5px;
    display: inline-block;
    vertical-align: middle;
    border-radius: 3px;
    margin-right: 5px;
    margin-top: 15px;
    opacity: 1;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.24);
    border: none;
}

.quickaction-sms, .quickaction-email, .view_Brochure {
    background-color: #51bae1;
    color: #fff;
    line-height: 36px;
    padding: 10px;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.5px;
    display: inline-block;
    vertical-align: middle;
    border-radius: 3px;
    margin-right: 5px;
    margin-top: 15px;
    opacity: 1;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.24);
    border: none;
}

.medclient_portfolio_chosen {
    width: 18px;
    height: 18px;
    display: inline-block;
    vertical-align: middle;
    margin-top: 0px !important;
}

.project-tab a {
    color: #fff !important;
    cursor: pointer !important;
    font-weight: 700 !important;
    line-height: 1.15 !important;
    padding-bottom: 10px !important;
    font-size: 13.5px !important;
}
/*.view_Brochure{
    background-color: #66AA3B !important;
    color:  #fff !important;
}

.quickaction-email{
    background-color: #DD8051 !important;
    color:  #fff !important;
}

.view_Brochure{
    background-color: #18659B !important;
    color:  #fff !important;
    
}*/
                </style>
        <?php
}


public function brochurecategory(Request $request) {
        // Make your response and echo it.
        // echo '<pre>'.print_r($_POST, true).'</pre>';

       
       
        $authorid = \auth::user()->id;
        $postvars['category_id'] = "200";
        //dd($postvars['category_id']);

         //print_r($authorid); die();
        $data = "200";
        $accesstoken  = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUwMTA3NzBkMDJkZGIyMmEyMzk1NzQ2ZGUyZTZlODBiYWRjYWVlYjMxZmY3ZjAwN2U5OGE1YjhjZDc0Y2YxYTYzYjRiMTk3NmFiMjIzNDg1In0.eyJhdWQiOiI3IiwianRpIjoiZTAxMDc3MGQwMmRkYjIyYTIzOTU3NDZkZTJlNmU4MGJhZGNhZWViMzFmZjdmMDA3ZTk4YTViOGNkNzRjZjFhNjNiNGIxOTc2YWIyMjM0ODUiLCJpYXQiOjE2NDYxMjI1NTMsIm5iZiI6MTY0NjEyMjU1MywiZXhwIjoyNTkyODkzNzUzLCJzdWIiOiIxMDAxIiwic2NvcGVzIjpbXX0.qVtvuBQc8M-szwpuf9BiOt81m_BBkxPXx2Bl_JIA3xx2RrHMWYIA_IoP7MyUoRkI_FzZqak9heDAALte9t15en6a8h9ohnn4twxVw9x6Ae_kIbPnOghcSeoqb2J6Azx701bCWiEmwBGlZyi9BiBkE5P37fpkPIyObqn2GZ52PBZG4c2Q0Mpv42r4kYVZkTlA-Z738lUmZxaw3Y7UUZFzARCr_a7mYdh0g4mXaKpo7uBC2ELxVTwvMwQ5PxHNyJS1U3CmuuW1oyUesqFrilqS6q7BUQhLGGovwsf-mZVCXl8fAcLfbLG_BRqlY365nuqDXpo8ZiKhkAcH7KFFZyULNiuPy0cG1POHygk0-tKatbOecjAZg5nvLbTTc2R984aEqpqztPiQIV3LUuZQ9dFv_KUa3yfPL2yl9diS5I6be-ITiqT8N35FToWGTPzwnN79xx6HwdA-IvvopmFC9OjvWtsjspWUtWT4BOB2bWas7HACVPVLavhW_jDDnLR_KUGNXsFXIRrP0ipGsjIJiO4nLNE4cXcc52VISSrY1lNyjDA68caDAuWiqj5EcVxt2i7n6wZEVjqoRmGggVzzxopeClngu77sUmPotmYn7j072tpPWWi0eeVXf-vhfGM153ET57Ignkmwq9Pz3-zg3AWfo4NL_l_7thfC0lztm3bz9Jg";
        $query_endpoint = "https://client.local/api/brochure-search";
        //$query_endpoint ="https://practitioner.medinformer.co.za/api/brochure-search";

        $postvars = array();
        $postvars['category_id'] = "200";
        if(count($postvars) == 0) $postvars = false;
        $results = json_decode($this->queryapi($query_endpoint, $postvars, $accesstoken));

        ?>
        <div class='brochurelisting-tools'>
            <div class='backtobrochures'>
                <span class='back-icon'><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M231.293 473.899l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L70.393 256 251.092 74.87c4.686-4.686 4.686-12.284 0-16.971L231.293 38.1c-4.686-4.686-12.284-4.686-16.971 0L4.908 247.515c-4.686 4.686-4.686 12.284 0 16.971L214.322 473.9c4.687 4.686 12.285 4.686 16.971-.001z"></path></svg></span>
                <span>Search Again</span>
            </div>
            
            <div class='brochurecount'>
                <div class='brochurecount-label'>Brochures:</div>
                <div class='brochurecount-icon'>
                    <span class='back-icon'></span>
                    <span><strong><?= $results; ?></strong></span>
                </div>
            </div>
        </div>
        <?php

        $this->showResultsHTML($results, $authorid);

        // Don't forget to stop execution afterward.
    die();
    }

    public function brochurefetch() {
        // Make your response and echo it.
        //echo '<pre>'.print_r($_POST, true).'</pre>';

        // die()

        //$this->access_token = get_user_meta( $_POST['userid'], 'access_token', true);
        $authorid = $_POST['userid'];
        $accesstoken  = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUwMTA3NzBkMDJkZGIyMmEyMzk1NzQ2ZGUyZTZlODBiYWRjYWVlYjMxZmY3ZjAwN2U5OGE1YjhjZDc0Y2YxYTYzYjRiMTk3NmFiMjIzNDg1In0.eyJhdWQiOiI3IiwianRpIjoiZTAxMDc3MGQwMmRkYjIyYTIzOTU3NDZkZTJlNmU4MGJhZGNhZWViMzFmZjdmMDA3ZTk4YTViOGNkNzRjZjFhNjNiNGIxOTc2YWIyMjM0ODUiLCJpYXQiOjE2NDYxMjI1NTMsIm5iZiI6MTY0NjEyMjU1MywiZXhwIjoyNTkyODkzNzUzLCJzdWIiOiIxMDAxIiwic2NvcGVzIjpbXX0.qVtvuBQc8M-szwpuf9BiOt81m_BBkxPXx2Bl_JIA3xx2RrHMWYIA_IoP7MyUoRkI_FzZqak9heDAALte9t15en6a8h9ohnn4twxVw9x6Ae_kIbPnOghcSeoqb2J6Azx701bCWiEmwBGlZyi9BiBkE5P37fpkPIyObqn2GZ52PBZG4c2Q0Mpv42r4kYVZkTlA-Z738lUmZxaw3Y7UUZFzARCr_a7mYdh0g4mXaKpo7uBC2ELxVTwvMwQ5PxHNyJS1U3CmuuW1oyUesqFrilqS6q7BUQhLGGovwsf-mZVCXl8fAcLfbLG_BRqlY365nuqDXpo8ZiKhkAcH7KFFZyULNiuPy0cG1POHygk0-tKatbOecjAZg5nvLbTTc2R984aEqpqztPiQIV3LUuZQ9dFv_KUa3yfPL2yl9diS5I6be-ITiqT8N35FToWGTPzwnN79xx6HwdA-IvvopmFC9OjvWtsjspWUtWT4BOB2bWas7HACVPVLavhW_jDDnLR_KUGNXsFXIRrP0ipGsjIJiO4nLNE4cXcc52VISSrY1lNyjDA68caDAuWiqj5EcVxt2i7n6wZEVjqoRmGggVzzxopeClngu77sUmPotmYn7j072tpPWWi0eeVXf-vhfGM153ET57Ignkmwq9Pz3-zg3AWfo4NL_l_7thfC0lztm3bz9Jg";
        $query_endpoint = "https://practitioner.medinformer.co.za/api/brochure";
        //$query_endpoint ="http://client.local/api/brochure";
        $postvars = array();
        $postvars['brochure_id'] = $_POST['data'];

        //dd($postvars['data']);

        if(count($postvars) == 0) $postvars = false;
        $results = json_decode($this->queryapi($query_endpoint, $postvars, $accesstoken));
        //echo '<pre>'.print_r($results, true).'</pre>';
        ?>
        <div class='brochurelisting-tools'>
            <div class='backtobrochures' style="display: block;">
                <span class='back-icon'><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M231.293 473.899l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L70.393 256 251.092 74.87c4.686-4.686 4.686-12.284 0-16.971L231.293 38.1c-4.686-4.686-12.284-4.686-16.971 0L4.908 247.515c-4.686 4.686-4.686 12.284 0 16.971L214.322 473.9c4.687 4.686 12.285 4.686 16.971-.001z"></path></svg></span>
                <span>Search Again</span>
            </div>
            
            <div class='brochurecount'>
                <div class='brochurecount-label'>Brochures:</div>
                <div class='brochurecount-icon'>
                   
                </div>
            </div>
         </div>    
        <?php

        $this->showBrochureHTML($results, $authorid);

        // Don't forget to stop execution afterward.
        die();
    }

    public function get_brochure_categories($id, $accesstoken){
        $query_endpoint = "https://datacenter.medinformer.co.za/api/brochure-categories";
        $postvars = array(
            'brochure_id' => $id,
        );
        $return = json_decode( $this->queryapi( $query_endpoint, $postvars, $accesstoken) );
        return $return;
    }

    public function get_categories(){
        global $post;
        $this->access_token = get_user_meta( $post->post_author, 'access_token', true);
        //echo $this->access_token.'<BR>';
        $query_endpoint = "https://datacenter.medinformer.co.za/api/categories";
        ///echo $query_endpoint.'<BR>';
        $postvars = false;
        $return = json_decode( $this->queryapi( $query_endpoint, $postvars, $this->access_token) );
        return $return;

    }


    public function get_brochures($letter=false){
        global $post;
        
        if($this->brochures == false){

            $this->brochures = $this->get_all_brochures();
//            $prescript_brochures = $this->get_all_brochures();

//            $postscript_brochures = $this->get_postscript_brochures();

//            $this->brochures = array_merge( $prescript_brochures, $postscript_brochures );

            //duplicate objects will be removed
            $this->brochures = array_map("unserialize", array_unique(array_map("serialize", $this->brochures))); 
        }
        
        $results = array();

        if($letter){
            foreach($this->brochures as $brochure){
                
                if(substr(strtolower($brochure->title), 0, 1) === strtolower($letter)){
                    //echo '<pre>'.$brochure->title.' | '.substr(strtolower($brochure->title), 0, 1).'--'.strtolower($letter).'</pre>';
                    $results[] = $brochure;
                }
            }
        } else {
            $results = $this->brochures;
        }
        
        return $results;
    }



    public function brochureemail() {

        $debug = '<div class="medclient-note fail"><i class="far fa-times-circle"></i> Email failed to send to <strong>'.$_POST['data']['patient_email'].'</strong>, please contact Medinformer API Administrator.</div>';

        $accesstoken  = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUwMTA3NzBkMDJkZGIyMmEyMzk1NzQ2ZGUyZTZlODBiYWRjYWVlYjMxZmY3ZjAwN2U5OGE1YjhjZDc0Y2YxYTYzYjRiMTk3NmFiMjIzNDg1In0.eyJhdWQiOiI3IiwianRpIjoiZTAxMDc3MGQwMmRkYjIyYTIzOTU3NDZkZTJlNmU4MGJhZGNhZWViMzFmZjdmMDA3ZTk4YTViOGNkNzRjZjFhNjNiNGIxOTc2YWIyMjM0ODUiLCJpYXQiOjE2NDYxMjI1NTMsIm5iZiI6MTY0NjEyMjU1MywiZXhwIjoyNTkyODkzNzUzLCJzdWIiOiIxMDAxIiwic2NvcGVzIjpbXX0.qVtvuBQc8M-szwpuf9BiOt81m_BBkxPXx2Bl_JIA3xx2RrHMWYIA_IoP7MyUoRkI_FzZqak9heDAALte9t15en6a8h9ohnn4twxVw9x6Ae_kIbPnOghcSeoqb2J6Azx701bCWiEmwBGlZyi9BiBkE5P37fpkPIyObqn2GZ52PBZG4c2Q0Mpv42r4kYVZkTlA-Z738lUmZxaw3Y7UUZFzARCr_a7mYdh0g4mXaKpo7uBC2ELxVTwvMwQ5PxHNyJS1U3CmuuW1oyUesqFrilqS6q7BUQhLGGovwsf-mZVCXl8fAcLfbLG_BRqlY365nuqDXpo8ZiKhkAcH7KFFZyULNiuPy0cG1POHygk0-tKatbOecjAZg5nvLbTTc2R984aEqpqztPiQIV3LUuZQ9dFv_KUa3yfPL2yl9diS5I6be-ITiqT8N35FToWGTPzwnN79xx6HwdA-IvvopmFC9OjvWtsjspWUtWT4BOB2bWas7HACVPVLavhW_jDDnLR_KUGNXsFXIRrP0ipGsjIJiO4nLNE4cXcc52VISSrY1lNyjDA68caDAuWiqj5EcVxt2i7n6wZEVjqoRmGggVzzxopeClngu77sUmPotmYn7j072tpPWWi0eeVXf-vhfGM153ET57Ignkmwq9Pz3-zg3AWfo4NL_l_7thfC0lztm3bz9Jg";
        $this->access_token = $accesstoken;
        //$email_message = get_user_meta( $_POST['data']['page_author_id'], 'email_message', true);

        $user_info =  auth()->user();
      
        $doctor_email = auth()->user()->email;
         
        $billing_phone = auth()->user()->phone_number;
        $email_signature_attachment_id = auth()->user()->signature;


        //$diagnoses = '';
        //$diagnoses .= $_POST['doctor_diagnosis']."<br>"."<br>";
        //$diagnoses .= "";

        // $doctor_text_sig  = "<div style='background-color:#191919; font-size:12px; color:#eee'>";
        // $doctor_text_sig .= "<div>This is my custom Signature</div>";
        // $doctor_text_sig .= "<div><span>t: +27 71 372 6779</span> <span>skype: hannes.brink</span></div>";
        // $doctor_text_sig .= "</div>";

       $query_endpoint = "https://practitioner.medinformer.co.za/api/email-brochures";
        //$query_endpoint = "https://client.local/api/email-brochures";



        $postvars = array(
            'patient_email' => $_POST['data']['patient_email'],
            'doctor_email' => $doctor_email,
            'doctor_name' => $_POST['data']['doctor_name'],
            'email_title' => $_POST['data']['doctor_name']."",
            'doctor_diagnosis' => $_POST['data']['doctor_diagnosis'],
            'hids' => substr($_POST['data']['hids'], 0, -1),
            'image_signature' => ($email_signature_attachment_id != '')? wp_get_attachment_url( $email_signature_attachment_id ): '',
        );


        //echo $query_endpoint."<br>";
        //echo $query_endpoint."<br>";
        // echo '<pre>'.print_r((object)$postvars,true).'</pre>';
        // dd('dominic');
        $jsonresults = $this->emailbrochures((object)$postvars);
        //echo '<pre>'.print_r($jsonresults,true).'</pre>';

        // die();

        if($jsonresults['statuses']['ipod'] == 'success'){
            $debug = '<div class="medclient-note success"><i class="far fa-check-circle"></i> Email successfully sent to <strong>'.$_POST['data']['patient_email'].'</strong></div>';
        }

            if($jsonresults['statuses']['ipod'] == 'success'){

                echo '<button type="button" onClick="window.location.reload();" class="backtobrochures" style="border: none; margin-bottom: 10px;">Search Again</button></br>';
            }
        echo $debug;

        // Don't forget to stop execution afterward.
        die();
    }


      protected function brochurewhatsapp()
    {   

        $postvars = array(
            'msidn' => $_POST['data']['msidn'],
            'doctor_name' => $_POST['data']['doctor_name'],
            'doctor_diagnosis' => $_POST['data']['doctor_diagnosis'],
            'hids' => substr($_POST['data']['hids'], 0, -1),
            
        );

        //Medinformer Vars
        $msidn = $_POST['data']['msidn'];
        $doctor_name = $_POST['data']['doctor_name'];
        $doctor_diagnosis = $_POST['data']['doctor_diagnosis'];
        $hids = $_POST['data']['hids'];
        $patient_concent = $_POST['data']['patient_concent'];

        //$otp = "Testt";

        $this->whatsappNotification($msidn);
        

       


        return '<div class="medclient-note success"><i class="far fa-check-circle"></i> WhatsApp Message successfully sent to the recipient. <br><button type="button" onclick="window.location.reload();" class="backtobrochures mt-4" style="border: none; margin-bottom: 10px;">Search Again</button></div>';
        
    }

     private function whatsappNotification(string $recipient)
    {
    
    $emailstamp = time();

    $postvars = array(
        'msidn' => $_POST['data']['msidn'],
        'doctor_name' => $_POST['data']['doctor_name'],
        'doctor_diagnosis' => $_POST['data']['doctor_diagnosis'],
        'hids' => substr($_POST['data']['hids'], 0, -1),
    );

    $msidn = $_POST['data']['msidn'];
    $doctor_name = $_POST['data']['doctor_name'];
    $doctor_diagnosis = $_POST['data']['doctor_diagnosis'];
    $hids = $_POST['data']['hids'];
    $patient_concent = $_POST['data']['patient_concent'];
    $body = '';
       $bids = '';
        if($hids):
            
            $hids = str_replace(', ', ',', $hids);
            if( substr($hids, strlen($hids)-1, strlen($hids)) == ','){
                $hids = substr($hids, 0, -1);
            }
            //Log::debug(print_r($hids, true));
            $hidsarr = explode(',', $hids);
            

            foreach($hidsarr as $hid):

                //Log::debug(print_r($hid, true));

                $brochure_id = false;

                $bf_hid = Post::find($hid);
        

                $b = Post::find($hid);
                
                if(isset($b) && $b !== NULL):
                    $trackurl  = route('track.email.brochure', ['timestamp' => $emailstamp, 'brochureid' => $b->ID ] );
                    $bitlyobj = json_decode(
                        file_get_contents(
                            "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($trackurl)."&format=json"
                        )
                    )->data->url;
                    $body .= $trackurl;
                    $bids .= $b->id.',';
                endif;


            

            endforeach;
        else:
            $statuses['hids'] = 'No hids were specified.';
        endif;
        $bids = substr($bids, 0, -1);


       
    $number = $msidn;
    $to = "whatsapp:" . $number;
    $from = "whatsapp:+17262685428";
    $title = $b->post_title;

    $new_str = str_replace(' ', '-', $title);
    $doctor_name = auth()->user()->name;
    $link = $body;
    $newLink = "https://medinformer.co.za/health_subjects/$new_str";
    
 
    $msg = "Thank you for visiting $doctor_name , click on the below link to view an online brochure that we thought you may find helpful. Read More $newLink.";
 
    //$msg = "Thank you for visiting $doctor_name , click on the below link to learn more about $title. *Learn More $link here*.";

    $accountSid = getenv("TWILIO_AUTH_SID");
    $authToken = getenv("TWILIO_AUTH_TOKEN");
    $twilioClient = new Client($accountSid, $authToken);
    $msg_data = array("from" => $from, "body" => $msg);
    try {
        $message = $twilioClient->messages->create($to, $msg_data);
        $response = $message->sid ? $message->sid : '';
        error_log("Twilio msg response : " . print_r($response, true));
    } catch (TwilioException $e) {
        error_log('Could not send whatsapp notification to ' . $number);
        error_log('Could not send whatsapp TwilioException' . $e->getMessage());
    }

     $whatsapp = new Whatsapp;
        $whatsapp->user_id = Auth::user()->id;

        $whatsapp->msidn = $msidn;
        $whatsapp->doctor_diagnosis = $b->post_title;
        $whatsapp->doctor_name = $doctor_name;
        $whatsapp->hids = $b->post_title;

        $whatsapp->save();


}

    




   
       

    public function brochuresms() {

        

        $debug = '<div class="medclient-note fail"><i class="far fa-times-circle"></i> SMS failed to send to <strong>'.$_POST['data']['msidn'].'</strong>, please contact Medinformer API Administrator.</div>';

        


        $accesstoken  = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUwMTA3NzBkMDJkZGIyMmEyMzk1NzQ2ZGUyZTZlODBiYWRjYWVlYjMxZmY3ZjAwN2U5OGE1YjhjZDc0Y2YxYTYzYjRiMTk3NmFiMjIzNDg1In0.eyJhdWQiOiI3IiwianRpIjoiZTAxMDc3MGQwMmRkYjIyYTIzOTU3NDZkZTJlNmU4MGJhZGNhZWViMzFmZjdmMDA3ZTk4YTViOGNkNzRjZjFhNjNiNGIxOTc2YWIyMjM0ODUiLCJpYXQiOjE2NDYxMjI1NTMsIm5iZiI6MTY0NjEyMjU1MywiZXhwIjoyNTkyODkzNzUzLCJzdWIiOiIxMDAxIiwic2NvcGVzIjpbXX0.qVtvuBQc8M-szwpuf9BiOt81m_BBkxPXx2Bl_JIA3xx2RrHMWYIA_IoP7MyUoRkI_FzZqak9heDAALte9t15en6a8h9ohnn4twxVw9x6Ae_kIbPnOghcSeoqb2J6Azx701bCWiEmwBGlZyi9BiBkE5P37fpkPIyObqn2GZ52PBZG4c2Q0Mpv42r4kYVZkTlA-Z738lUmZxaw3Y7UUZFzARCr_a7mYdh0g4mXaKpo7uBC2ELxVTwvMwQ5PxHNyJS1U3CmuuW1oyUesqFrilqS6q7BUQhLGGovwsf-mZVCXl8fAcLfbLG_BRqlY365nuqDXpo8ZiKhkAcH7KFFZyULNiuPy0cG1POHygk0-tKatbOecjAZg5nvLbTTc2R984aEqpqztPiQIV3LUuZQ9dFv_KUa3yfPL2yl9diS5I6be-ITiqT8N35FToWGTPzwnN79xx6HwdA-IvvopmFC9OjvWtsjspWUtWT4BOB2bWas7HACVPVLavhW_jDDnLR_KUGNXsFXIRrP0ipGsjIJiO4nLNE4cXcc52VISSrY1lNyjDA68caDAuWiqj5EcVxt2i7n6wZEVjqoRmGggVzzxopeClngu77sUmPotmYn7j072tpPWWi0eeVXf-vhfGM153ET57Ignkmwq9Pz3-zg3AWfo4NL_l_7thfC0lztm3bz9Jg";
        $this->access_token = $accesstoken;


        


        //$query_endpoint = "https://datacenter.medinformer.co.za/api/sms-brochures";
        
        //dd($_POST['data']['msidn']);
        $postvars = array(
            'msidn' => $_POST['data']['msidn'],
            'postscript_passcode' => $_POST['data']['postscript_passcode'],
            'postscript' => $_POST['data']['postscript'],
            'doctor_name' => $_POST['data']['doctor_name'],
            'doctor_diagnosis' => "Important health info from ".$_POST['data']['doctor_name'],
            'hids' => substr($_POST['data']['hids'], 0, -1),
        );


        //echo $query_endpoint."<br>";
        //echo $query_endpoint."<br>";
        //echo '<pre>'.print_r($postvars,true).'</pre>';
        $jsonreturn = $this->sendSMS( (object)$postvars);

        $jsonresults = ( (object)$jsonreturn );

        //echo '<pre>'.print_r($jsonresults, true).'</pre>';


        if(isset($jsonresults->statuses['ipod']) && $jsonresults->statuses['ipod'] == 'success'){
            $debug = '<div class="medclient-note success"><i class="far fa-check-circle"></i> SMS successfully sent to <strong>'.$_POST['data']['msidn'].'</strong> </br><button type="button" onclick="window.location.reload();" class="backtobrochures mt-4" style="border: none; margin-bottom: 10px;">Search Again</button></div>';
        }

        echo $debug;

        // Don't forget to stop execution afterward.
        die();
    }


    public function sendSMS($vars) {
        //dd($vars->msidn);
        $timestamp = time();

        $statuses = array(
            "ireq" => "success",
            "ires" => "pending",
            "ipod" => "pending",
            "hids" => "No hids were specified.",
        );

        $doctor_name = (isset($vars->doctor_name))? $vars->doctor_name: false;
        $doctor_diagnosis = (isset($vars->doctor_diagnosis))? $vars->doctor_diagnosis: 'Medinformer Medical Information';
        //$doctor_email = (isset($request->doctor_email))? $request->doctor_email: false;
        $patient_number = (isset($vars->msidn))? $vars->msidn: false;

        //$pids = (isset($request->pids))? $request->pids: false;
        $hids = (isset($vars->hids))? $vars->hids: false;
        $statuses['hids'] = $hids;
        //$service_date = (isset($request->service_date))? $request->service_date: false;
        //$doctor_contact = (isset($request->doctor_contact))? $request->doctor_contact: false;
        //$text_signature = (isset($request->text_signature))? $request->text_signature: false;
        //$image_signature = (isset($request->image_signature))? $request->image_signature: false;

        $doctor_message = (isset($vars->doctor_diagnosis))? $vars->doctor_diagnosis: '';
        //$updated_msg = str_replace("{doctor_name}", $doctor_name, $doctor_message);

        //$updated_msg  = 'Your doctor has selected the following medical health information to share with you on your medical condition.'."<BR><BR>";
        //$updated_msg .= 'Yours in good health'."<BR>";

        $subject = $doctor_diagnosis;


        // SMS body
        $bids = '';

        $body_msg  = $subject."\n";
        //$body_msg .= $updated_msg."\n";

        if($hids):
            $hids = str_replace(', ', ',', $hids);
            $hidsarr = explode(',', $hids);

            foreach($hidsarr as $hid):

                $brochure_id = false;

                // $bf_hid =  Post::type('medicalbrochure')->status('publish')->paginate(6);

                // $bf_hid = BrochureField::where('slug', 'hid')->first();
                // $bfv_hids = BrochureFieldValues::where([
                //     ['field_id', $bf_hid->id],
                //     ['value', $hid]
                // ])->get();
                // foreach($bfv_hids as $bfv_hid){
                //     $b = Post::find($bfv_hid->brochure_id);
                //     if($b){
                //         $brochure_id = $bfv_hid->brochure_id;
                //     }
                // }
                
                // $postscript = "no";
                // $bf_postscript = BrochureField::where('slug', 'postscript')->first();
                // $bfv_postscript = BrochureFieldValues::where([
                //     ['field_id', $bf_postscript->id],
                //     ['brochure_id', $brochure_id]
                // ])->first();
                // if($bfv_postscript):   
                //     $postscript = $bfv_postscript->value;
                // endif;
 
                $b = Post::find($hid);
                
                if(isset($b) && $b !== NULL):
                    $trackurl  = route('track.sms.brochure', ['timestamp' => $timestamp, 'brochureid' => $b->ID ] );
                    $bitlyobj = json_decode(
                        file_get_contents(
                            "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($trackurl)."&format=json"
                        )
                    )->data->url;

                    $body_msg .= $b->title.": "; //'<div>- <a href="'.$trackurl.'" target="_blank">'.$b->title.'</a></div>';
                    $body_msg .= $bitlyobj."\n"."\n"; //'<div>- <a href="'.$trackurl.'" target="_blank">'.$b->title.'</a></div>';
                    $bids .= $b->ID.',';
                endif;


                /*$bfvs = BrochureFieldValues::where('value', $hid)->get();
                foreach($bfvs as $bfv):
                    $b = Brochure::find($bfv->brochure_id);
                    if(isset($b) && $b !== NULL):
                        $redirect_url = $this->getUserCompanyRedirectUrl();
                        $brochure_url = $redirect_url.'/'.str_slug($b->title);
                        $trackurl  = route('track.sms.brochure', ['timestamp' => $timestamp, 'brochureid' => $bfv->brochure_id] );
                        $bitlyobj = json_decode(
                            file_get_contents(
                                "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($trackurl)."&format=json"
                            )
                        )->data->url;

                        $body_msg .= $b->title.": "; //'<div>- <a href="'.$trackurl.'" target="_blank">'.$b->title.'</a></div>';
                        $body_msg .= $bitlyobj."\n"."\n"; //'<div>- <a href="'.$trackurl.'" target="_blank">'.$b->title.'</a></div>';
                        $bids .= $b->id.',';
                    endif;
                endforeach;*/
            endforeach;
            
        else:
            $statuses['hids'] = 'No hids were specified.';
        endif;
        $bids = substr($bids, 0, -1);
        
        $patient_number_firstchar = substr($patient_number,0, 1);
        if($patient_number_firstchar == '0'){
            $patient_number = '+27'.substr($patient_number, 1, strlen($patient_number));
        }
         //\Log::info("SENDING SMS");
        //\Log::info($vars);
        $postscriptValue = (isset($vars->postscript))? $vars->postscript : 'No';
        $postscriptPasscode = (isset($vars->postscript_passcode))? $vars->postscript_passcode: NULL;
        if($postscriptValue === "Yes"){
            $body_msg .= "Password is : ".$postscriptPasscode."\n"."\n";
        }

        $body = '';
        $body = '<XML>
                <SENDBATCH delivery_report="1" status_report="1">
                    <SMSLIST> 
                        <SMS_SEND uid="'.$timestamp.'" user="43587887" password="jNXqa6" to="'.$patient_number.'">'.$body_msg.'</SMS_SEND>
                    </SMSLIST>
                </SENDBATCH>
                </XML>';

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


   
        //$result = $this->sendSMS('http://sg1.channelmobile.co.za', $post);
        $statuses["ires"] = $return;
        $statuses["ipod"] = "success";

        //$this->trackRequest('brochure-sms/'.$patient_number.'/'.$bids.'/'.$timestamp);



        $sms = new SMS;
        $sms->user_id = Auth::user()->id;

        $sms->msidn = $vars->msidn;
        $sms->doctor_diagnosis = $vars->doctor_diagnosis;
        $sms->doctor_name = $vars->doctor_name;
        $sms->hids = $b->post_title;

        $sms->save();

        return array(
            'xmlsent' => $body,
            'statuses' => $statuses
        );
    }

       // brochures email to recipient.
    public function emailbrochures($request) {
        //dd($request->patient_email);

        $emailstamp = time();

        $statuses = array(
            "ireq" => "success",
            "ires" => "pending",
            "ipre" => "pending",
            "ipod" => "pending",
            "emailsig" => "null",
            "doctor_email" => "null",
            "doctor_contact" => "null",
            "ican" => "null",
        );
        \Log::info("sending email");
        //\Log::info($request);

        $email_title = (isset($request->email_title))? $request->email_title: false;
        $doctor_name = (isset($request->doctor_name))? $request->doctor_name: false;
        $doctor_email = (isset($request->doctor_email))? $request->doctor_email: false;
        $patient_email = (isset($request->patient_email))? $request->patient_email: false;
        $doctor_message = (isset($request->doctor_diagnosis))? str_replace("\n ","</br> </br>",$request->doctor_diagnosis): false;
        $type = (isset($request->type))? $request->type: 'Dr.';
        $newMessage =explode(".",$doctor_message);
        \Log::info($doctor_message);
         \Log::info($newMessage);
        $pids = (isset($request->pids))? $request->pids: false;
        $hids = (isset($request->hids))? $request->hids: false;
        $service_date = (isset($request->service_date))? $request->service_date: false;
        $doctor_contact = (isset($request->doctor_contact))? $request->doctor_contact: false;
        $text_signature = (isset($request->text_signature))? $request->text_signature: false;
        $image_signature = (isset($request->image_signature))? $request->image_signature: false;

        $updated_msg = str_replace("{doctor_name}", $doctor_name, $doctor_message);

        //$updated_msg  = 'Your doctor has selected the following medical health information to share with you on your medical condition.'."<BR><BR>";
        //$updated_msg .= 'Yours in good health'."<BR>";
        $doctor_name_arr = explode(" ", $doctor_name);
        $from_name = $doctor_name; //$type.' '.( isset($doctor_name_arr[0]) )? $doctor_name_arr[0]: $doctor_name;
        $from_email = $doctor_email;
        $subject = "Important health info from ".$from_name;  /*"Dr. Jone / Sister Mary.";*/


        $statuses['ires'] = 'success';

        //dd($statuses);
        // Email body
        $body = '';
        /*if($email_title && $email_title != '' && $email_title != null):
        $body .= '<h1>Hi '.$email_title.'</h1>';
        endif;*/
        foreach($newMessage as $key=>$msg){
            $size = (sizeof($newMessage)-1);
            if($key < $size){
                $body .= '<p>'.$msg.'.</p>';
            }elseif($size === $key){
                $endingsms= explode("health",$msg);
                $body .= '<p>'.$endingsms[0].',</p>';
//                $body .= '<p>'.$endingsms[1].'.</p>';
            }
            
        }
        



        $bids = '';
        if($hids):
            
            $hids = str_replace(', ', ',', $hids);
            if( substr($hids, strlen($hids)-1, strlen($hids)) == ','){
                $hids = substr($hids, 0, -1);
            }
            //Log::debug(print_r($hids, true));
            $hidsarr = explode(',', $hids);
            

            foreach($hidsarr as $hid):

                //Log::debug(print_r($hid, true));

                $brochure_id = false;

                $bf_hid = Post::find($hid);
                // $bfv_hids = BrochureFieldValues::where([
                //     ['field_id', $bf_hid->id],
                //     ['value', $hid]
                // ])->get();
                // foreach($bfv_hids as $bfv_hid){
                //     $b = Brochure::find($bfv_hid->brochure_id);
                //     if($b){
                //         $brochure_id = $bfv_hid->brochure_id;
                //     }
                // }
                
                // $postscript = "no";
                // $bf_postscript = BrochureField::where('slug', 'postscript')->first();
                // $bfv_postscript = BrochureFieldValues::where([
                //     ['field_id', $bf_postscript->id],
                //     ['brochure_id', $brochure_id]
                // ])->first();
                // if($bfv_postscript):   
                //     $postscript = $bfv_postscript->value;
                // endif;
 
                // $b = Post::find($brochure_id);
                // if(isset($b->post_title)):
                //     //$brochure_url = $redirect_url.'/'.str_slug($b->title);
                //     $trackurl = route('track.email.brochure', ['emailstamp' => $emailstamp, 'brochureid' => $brochure_id] );
                //     $body .= '<div>- <a href="'.$trackurl.'" target="_blank">'.$b->post_title.'</a></div>';
                //     $bids .= $b->id.',';
                // endif;

                $b = Post::find($hid);
                
                if(isset($b) && $b !== NULL):
                    $trackurl  = route('track.email.brochure', ['timestamp' => $emailstamp, 'brochureid' => $b->ID ] );
                    $bitlyobj = json_decode(
                        file_get_contents(
                            "http://api.bit.ly/v3/shorten?login=o_59ur33ucle&apiKey=R_e64642d5e5bd459dad58b1bfe1e38e1a&longUrl=".urlencode($trackurl)."&format=json"
                        )
                    )->data->url;
                     $body .= '<div>- <a href="'.$trackurl.'" target="_blank">'.$b->post_title.'</a></div>';
                    $bids .= $b->id.',';
                endif;


                /*foreach($bfvs as $bfv):
                    $b = Brochure::find($bfv->brochure_id);
                    if(isset($b->title)):
                        if($bfv)
                        $redirect_url = $this->getUserCompanyRedirectUrl();
                        $brochure_url = $redirect_url.'/'.str_slug($b->title);
                        $trackurl = route('track.email.brochure', ['emailstamp' => $emailstamp, 'brochureid' => $bfv->brochure_id] );
                        $body .= '<div>- <a href="'.$trackurl.'" target="_blank">'.$b->title.'</a></div>';
                        $bids .= $b->id.',';
                        endif;
                endforeach;*/

            endforeach;
        else:
            $statuses['hids'] = 'No hids were specified.';
        endif;
        $bids = substr($bids, 0, -1);

        if($pids):

        else:
            $statuses['pids'] = 'No pids were specified.';
        endif;

        $body .= "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>";

        $body .= "<table width='100%' style='max-width:600px;' border='0'>";
        if( $text_signature && !in_array( strtolower($text_signature), array('', 'null')) ):
            $body .= "<tr>";
            $body .= "  <td text-align='left'>".$text_signature."</td>";
            $body .= "</tr>";
        elseif( $image_signature && !in_array(strtolower($image_signature), array('', 'null')) ):
            $body .= "<tr>";
            $body .= "  <td text-align='left'><img src='".$image_signature."'>'</td>";
            $body .= "</tr>";
            $statuses['emailsig'] = 'success';
        else:
            $body .= "<tr>";
            $body .= "  <td text-align='left'>";
            $body .= "  <table style='font-size:12px;'>";

            if($doctor_name && !in_array( strtolower($doctor_name), array('', 'null')) ):
                $body .= "<tr><td style='color:rgb(77,184,71)!important; width:50px;'>Name:</td> <td>".$doctor_name."</td></tr>";
            endif;

            if($doctor_contact && !in_array( strtolower($doctor_contact), array('', 'null')) ):
                $body .= "<tr><td style='color:rgb(77,184,71)!important; width:50px;'>Contact:</td> <td>".$doctor_contact."</td></tr>";
                $statuses['doctor_contact'] = $doctor_contact;
            endif;

            if($doctor_email && !in_array( strtolower($doctor_email), array('', 'null')) ):
                $body .= "<tr><td style='color:rgb(77,184,71)!important; width:50px;'>Email:</td> <td>".$doctor_email."</td></tr>";
                $statuses['doctor_email'] = $doctor_email;
            endif;

            $body .= "  </table>";
            $body .= "  </td>";
            $body .= "</tr>";

        endif;
        $body .= "</table>";

        // print_r($b->post_title);
        // die();
   
        Mail::to($patient_email)->send(new FeedbackMail('production@medinformer.co.za', "Medinformer Health", $subject, $body));


        $email = new Emails;
        $email->user_id = Auth::user()->id;

        $email->doctor_name = $request->doctor_name;
        $email->patient_email = $request->patient_email;
        $email->doctor_email = Auth::user()->email;

        $email->doctor_diagnosis = $request->doctor_diagnosis;
        $email->doctor_name = $request->doctor_name;
        $email->hids = $b->post_title;

       
        $email->save();

        $statuses["ipod"] = "success";

        //$this->trackRequest('brochure-email/'.$patient_email.'/'.$bids.'/'.$emailstamp);

        return array(
            //'request' => $request->all(),
            'statuses' => $statuses
        );


        /*Mail::to('hannesbrink@gmail.com')->send(
            new FeedbackMail(
                'production@medinformer.co.za', 
                "Dehlia Dalrymple", 
                'test emails', 
                'this is a test email. check check.'
            )
        );*/


    }

         // search brochures
    public function brochuresearches($request){
        //dd($request);
        $searchcheck = false;

        $return = array();

        //$icd10 = (isset($request->icd10))? $request->icd10: false;
        $search = (isset($request))? $request: false;
        //$brochure_id = (isset($request->brochure_id))? $request->brochure_id: false;
        //$category_id = (isset($request->category_id))? $request->category_id: false;

        //$redirect_url = $this->getUserCompanyRedirectUrl();
        $redirect_url = "https://client.local/home";
        if($search):

            $brochures = $this->get_brochures_by_title($search);
            if(!empty($brochures)){
                return $brochures = array_merge($return, $brochures);
            } 
            // else {

            //     $icd10brochures = $this->get_brochures_by_icd10($search);
            //     if(!empty($icd10brochures)){
            //         $return = array_merge($return, $icd10brochures);
            //     }
                
            //     $categorybrochures = $this->get_brochures_by_category($search);
            //     if(!empty($categorybrochures)){
            //         $return = array_merge($return, $categorybrochures);
            //     }

            // }

            //$this->trackRequest('brochure-search/'.$search);

            if(empty($return)){
                $searchcheck = false;
            } else {
                $searchcheck = true;
            }

        endif;


        

        if($searchcheck == false){
            //$this->trackRequest('brochure-search/error');
            $return = array( 'Error' => "No search results found.");
        }

        return $return;
    
    }

    public function get_brochures_by_title($search){
        $redirect_url = "http://client.local/";
        $private_url = "http://client.local/";
        $return = array();
        $brochures = Post::type('medicalbrochure')->where('post_title', 'like', '%'.$search.'%')->get();
        //->orWhere('desc', 'like', '%'.$search.'%')
        
       // print_r($brochures);
        if($brochures !== null):

            foreach($brochures as $b):
        // print_r($b);

            if($b->ID):

                    $brochuresarr = array();
                    $brochuresarr['ID'] = $b->ID;
                    $brochuresarr['post_title'] = $b->title;
                    $brochuresarr['desc'] = $b->desc;
                    $brochuresarr['categories'] = $b->categories;
                    $brochuresarr['image'] = $b->image;
                    $brochuresarr['created_at'] = $b->created_at;
                    $brochuresarr['updated_at'] = $b->updated_at;
                    $brochure_id = $b->ID;
                    //dd($brochuresarr['updated_at']);
                    $brochuresarr['redirect_url'] = $redirect_url;
                    $brochuresarr['private_url'] = $private_url;

                    //get all brochure field values
                    // $brochuresarr['brochure_fields'] = array();
                    // $bfvs = BrochureFieldValues::where('brochure_id', '=', $brochure_id)->get();
                    // if($bfvs !== null):
                    //     $dataarr = array();
                    //     foreach($bfvs as $fvalue):
                    //         $field = BrochureField::find($fvalue->field_id);
                    //         if($field !== null):
                    //             $dataarr[str_slug($field->title)] = $fvalue->value;
                    //         endif;
                    //     endforeach;
                    //     $brochurefields = $dataarr;
                    //     $brochuresarr['brochure_fields'] = $dataarr;
                    // endif;

                    //get all segments
                    // $bs = BrochureSegments::where('brochure_id', '=', $brochure_id)->get();
                    // if($bs !== null):
                    //     $brochuresegments = $bs;
                    //     $brochuresarr['brochure_segments'] = $bs;
                    // endif;

                    // build html brochure
                    //$brochuresarr['html'] = $this->getBrochureHTML($b, $brochurefields, $brochuresegments);

                    $return[] = $brochuresarr;

                endif;

            endforeach;


        //else:
            //$return = array( 'Error' => "No Brochures found.");
        endif;

        return $return;
    }

}
