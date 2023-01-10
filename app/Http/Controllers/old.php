<?php 

 public function sendWhatsapp(Request $request) {
        //print_r($vars->msidn);
        $timestamp = time();

        $statuses = array(
            "ireq" => "success",
            "ires" => "pending",
            "ipod" => "pending",
            "hids" => "No hids were specified.",
        );

        $doctor_name = (isset($request->doctor_name))? $request->doctor_name: false;
        $doctor_diagnosis = (isset($request->doctor_diagnosis))? $request->doctor_diagnosis: 'Medinformer Medical Information';
        //$doctor_email = (isset($request->doctor_email))? $request->doctor_email: false;
        $patient_number = (isset($request->msidn))? $request->msidn: false;

        //$pids = (isset($request->pids))? $request->pids: false;
        $hids = (isset($request->hids))? $request->hids: false;
        $statuses['hids'] = $hids;
        //$service_date = (isset($request->service_date))? $request->service_date: false;
        //$doctor_contact = (isset($request->doctor_contact))? $request->doctor_contact: false;
        //$text_signature = (isset($request->text_signature))? $request->text_signature: false;
        //$image_signature = (isset($request->image_signature))? $request->image_signature: false;

        $doctor_message = (isset($request->doctor_diagnosis))? $request->doctor_diagnosis: '';
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
        $postscriptValue = (isset($request->postscript))? $request->postscript : 'No';
        $postscriptPasscode = (isset($request->postscript_passcode))? $request->postscript_passcode: NULL;
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

        $this->whatsappNotification($patient_number);





        // $sms = new SMS;
        // $sms->user_id = Auth::user()->id;

        // $sms->msidn = $vars->msidn;
        // $sms->doctor_diagnosis = $vars->doctor_diagnosis;
        // $sms->doctor_name = $vars->doctor_name;
        // $sms->hids = $b->post_title;

        // $sms->save();

        return array(
            'xmlsent' => $body,
            'statuses' => $statuses
        );
    }

