<?php

namespace App\Http\Controllers\Mpesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MpesaController extends Controller
{  
    private $access_token = '';

    // access token
    public function access_token(){
        $consumerKey = '00VYUw8a9QNWPpEe0xMmQo5FxGMgVuJ5';
        $consumerSecret = 'cSuw5KuVBeXIIEQT'; 

        $headers = ['Content-Type:application/json; charset=utf8'];

        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);

        $this->access_token = $result->access_token;
        
        curl_close($curl);

        return $this->access_token;
    }

    // register confirmation and validation urls
    public function register_url(){
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        
        $access_token = $this->access_token();
        $shortCode = '601383';
        $confirmationUrl = 'https://bdbbe5bd.ngrok.io/remss/confirmation_url.php';  // remember to make urls https and use ngrok
        $validationUrl = 'https://bdbbe5bd.ngrok.io/remss/validation_url.php';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); 
        
        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ShortCode' => $shortCode,
            'ResponseType' => 'Confirmed',
            'ConfirmationURL' => $confirmationUrl,
            'ValidationURL' => $validationUrl
        );
        
        $data_string = json_encode($curl_post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        $curl_response = curl_exec($curl);
        print_r($curl_response);
        
        echo $curl_response;
    }

    // Simulate C2B Paybill Transaction
    public function C2B_Simulate(){
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
        
        $access_token = $this->access_token();
        $shortCode = '601383';
        $amount = '7500';
        $msisdn = '254708374149';
        $billRef = 'INV_075'; //This is anything that helps identify the specific transaction. Can be a clients ID, Account Number, Invoice amount, cart no.. etc
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));
    
    
        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ShortCode' => $shortCode,
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'Msisdn' => $msisdn,
            'BillRefNumber' => $billRef
        );
    
        $data_string = json_encode($curl_post_data);
    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    
        $curl_response = curl_exec($curl);
        print_r($curl_response);
    
        echo $curl_response;
    }


}