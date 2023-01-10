  protected function brochurewhatsapp(Request $request)
    {   

    




        print_r('hellllllll');

        $this->whatsappNotification("+27785122210");
        
        //return $whatsapp;
        
    }

    private function whatsappNotification(string $recipient)
    {       

         $timestamp = time();

        $statuses = array(
            "ireq" => "success",
            "ires" => "pending",
            "ipod" => "pending",
            "hids" => "No hids were specified.",
        );

      

        // Twillo
        $sid    = getenv("TWILIO_AUTH_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token);
        
        $from_doc = "Medinformer Health";
        $body = "Important health information from $from_doc. Acne: https://medinformer.co.za/health_subjects/acne-pimples/";

        $return = '';
        $statuses["ires"] = $return;
        $statuses["ipod"] = "success";


        //  return array(
        //     'xmlsent' => $body,
        //     'statuses' => $statuses
        // );


        //Twillo return
        return $twilio->messages->create("whatsapp:$recipient",["from" => "whatsapp:$wa_from", "body" => $body]);
    }
