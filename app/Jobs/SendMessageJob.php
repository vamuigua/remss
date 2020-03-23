<?php

namespace App\Jobs;

use App\Message;
use App\Tenant;
use AfricasTalking\SDK\AfricasTalking;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $this->sendSMS($this->message->message);
    }

    // function to send messages through AT API
    public function sendSMS($message){
        // Set your app credentials
        $username   = "sandbox";
        $apiKey     = "d4ae8a06372c53410112a3045f896f7fb05ac192d23033c7c8e1fff1210211e8";

        // Initialize the SDK
        $AT = new AfricasTalking($username, $apiKey);

        // Get the SMS service
        $sms = $AT->sms();

        // get all the tenants
        $tenants = Tenant::all();
        
        // Set the numbers you want to send to in international format
        foreach ($tenants as $tenant) {
            $recipients = $tenant->phone_no;

            // Set your shortCode or senderId
            $from = "REMSS";

            try {
                // Thats it, hit send and we'll take care of the rest
                $result = $sms->send([
                    'to'      => $recipients,
                    'message' => $message,
                    'from'    => $from
                ]);
                
                // log the response
                $logFile = "BulkSMSResponse.txt";
                
                // convert result array to string
                $str_json = json_encode($result);

                // write to file
                $log = fopen($logFile, "a");
                fwrite($log, $str_json);
                fclose($log);

                 // decode the bulksms response
                $json = json_decode($str_json, true);
                
                // print_r($json['data']['SMSMessageData']['Recipients'][0]['statusCode']);
                
            } catch (Exception $e) {
                // log the response
                $logFile = "BulkSMSResponse_Error.txt";
                
                // convert result array to string
                $str_json = json_encode($e->getMessage());

                // write to file
                $log = fopen($logFile, "a");
                fwrite($log, $str_json);
                fclose($log);
            }
        }
        
    }
}
