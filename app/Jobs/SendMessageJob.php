<?php

namespace App\Jobs;

use Exception;
use App\Message;
use AfricasTalking\SDK\AfricasTalking;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $retryAfter = 3;
    public $tries = 3;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // send bulksms to recepients
        $this->sendSMS($this->message);
    }

    // function to send messages through AT API
    public function sendSMS($message)
    {
        // Set your app credentials
        $username   = env('AFRICASTALKING_USERNAME');
        $apiKey     = env('AFRICASTALKING_API_KEY');

        // Set your shortCode or senderId
        $from = "REMSS";

        // Initialize the SDK
        $AT = new AfricasTalking($username, $apiKey);

        // Get the SMS service
        $sms = $AT->sms();

        // Set the numbers you want to send to in international format
        $recipients_array = explode(", ", $message->recepients);

        foreach ($recipients_array as $recipient) {
            // Thats it, hit send and we'll take care of the rest
            $result = $sms->send([
                'to'      => $recipient,
                'message' => $message->message,
                'from'    => $from
            ]);

            // log the response
            $logFile = public_path("/remss/Bulksms/BulkSMSResponse.json");

            // convert result array to string
            $str_json = json_encode($result, JSON_PRETTY_PRINT);

            // write to file
            $log = fopen($logFile, "a");
            fwrite($log, $str_json);
            fclose($log);

            // decode the bulksms response
            // $json = json_decode($str_json, true);

            // Check for errors
            // print_r($json['data']['SMSMessageData']['Recipients'][0]['statusCode']); // statusCode '101' means successful
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // log the error response
        $logFile = public_path("/remss/Bulksms/BulkSMSResponse_Error.txt");

        // convert result array to string
        $error_msg = $exception->getMessage();

        // write to file
        $log = fopen($logFile, "a");
        fwrite($log, $error_msg);
        fclose($log);
    }
}
