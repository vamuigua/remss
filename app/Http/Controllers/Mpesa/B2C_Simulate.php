<?php
  $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

  $access_token = 'MD1Ae4fArkfisPDn9B85AdCTL2gZ';
  $ShortCode = '601383';
  $amount = '70000';
  $msisdn = '254708374149';
  $billRef = 'INV_700'; //This is anything that helps identify the specific transaction. Can be a clients ID, Account Number, Invoice amount, cart no.. etc

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header


  $curl_post_data = array(
          //Fill in the request parameters with valid values
         'ShortCode' => $ShortCode,
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
?>