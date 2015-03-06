<?php
/**
 * Created by PhpStorm.
 * User: ArseneLeQuebecois
 * Date: 06/03/2015
 * Time: 09:22
 */

class API {

    //Fonction pr send les sms avec l'API de Nexmo
    public function SendSMS($key,$secret,$telephone,$message){
        /* ENVOI DE SMS */
        include ( "../nexmo_api/NexmoMessage.php" );
        /**
         * To send a text message.
         *
         */
        // Step 1: Declare new NexmoMessage.
        $nexmo_sms = new NexmoMessage($key, $secret);

        // Step 2: Use sendText( $to, $from, $message ) method to send a message.
        $info = $nexmo_sms->sendText('+225'.$telephone, 'TRAVEL STAR', $message );
        // Step 3: Display an overview of the message
        $nexmo_sms->displayOverview($info);
        // Done!
    }
} 