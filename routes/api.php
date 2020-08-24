<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\MobilePayment;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('validate', function (Request $request) {
    // Log validation response
    Log::info("Validate: " . $request->getContent());

    /* Validate response array */
    $accept_array = array("ResultCode" => 0, "ResultDesc" => "Accepted");
    $reject_array = array("ResultCode" => 1, "ResultDesc" => "Rejected");

    return response()->json($accept_array);
});

Route::post('confirm', function (Request $request) {
    // Log confirmation response
    Log::info("Confirm: " . $request->getContent());

    $confirm_array = array("C2BPaymentConfirmationResult" => "Success");

    // Get response, convert to array and save mpesa transation to db
    $response = json_decode($request->getContent(), true);
    MobilePayment::create($response);

    return response()->json($confirm_array);
});
