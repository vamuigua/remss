<?php
    require 'config.php';
    header("Content-Type: application/json");

    $confirmation_response = '{"C2BPaymentConfirmationResult": "Success"}';

    // Response from M-PESA Stream
    $mpesaResponse = file_get_contents('php://input');

    // log the response
    $logFile = "M_PESAConfirmationResponse.txt";

    // write to file
    $log = fopen($logFile, "a");
    fwrite($log, $mpesaResponse);
    fclose($log);

    // decode the mpesa response
    $jsonMpesaResponse = json_decode($mpesaResponse, true); // We will then use this to save to database
    
    // turn mpesa response to an array
    $transaction = array(
            ':TransactionType'      => $jsonMpesaResponse['TransactionType'],
            ':TransID'              => $jsonMpesaResponse['TransID'],
            ':TransTime'            => $jsonMpesaResponse['TransTime'],
            ':TransAmount'          => $jsonMpesaResponse['TransAmount'],
            ':BusinessShortCode'    => $jsonMpesaResponse['BusinessShortCode'],
            ':BillRefNumber'        => $jsonMpesaResponse['BillRefNumber'],
            ':InvoiceNumber'        => $jsonMpesaResponse['InvoiceNumber'],
            ':OrgAccountBalance'    => $jsonMpesaResponse['OrgAccountBalance'],
            ':ThirdPartyTransID'    => $jsonMpesaResponse['ThirdPartyTransID'],
            ':MSISDN'               => $jsonMpesaResponse['MSISDN'],
            ':FirstName'            => $jsonMpesaResponse['FirstName'],
            ':MiddleName'           => $jsonMpesaResponse['MiddleName'],
            ':LastName'             => $jsonMpesaResponse['LastName']
    );

    // save response to DB
    insert_response($transaction);
    
    echo $confirmation_response;
?>
