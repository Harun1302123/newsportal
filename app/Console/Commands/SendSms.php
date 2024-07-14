<?php

namespace App\Console\Commands;

use App\Modules\Settings\Models\Configuration;
use App\Modules\Settings\Models\EmailQueue;
use Illuminate\Console\Command;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sms_queue_data = EmailQueue::where('sms_status', 0)
            ->where('sms_to', '!=', '')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get([
                'id',
                'sms_content',
                'sms_to',
                'sms_no_of_try'
            ]);
        $count = 0;
        $access_token = '';
        foreach ($sms_queue_data as $sms_data) {
            $id = $sms_data->id;
            $sms_body = $sms_data->sms_content;
            $mobile_number = $sms_data->sms_to;
            $mobile_number = str_replace("+88", "", "$mobile_number");
            $sms_no_of_try = $sms_data->sms_no_of_try;

            // Get Token from SMS API Portal
            if (empty($access_token)) {
                $token_response = json_decode($this->getToken());
                if ($token_response->responseCode == 0) {
                    echo $token_response->msg;
                    continue;
                }
                $access_token = $token_response->data;
            }
            // End of Get Token from SMS API Portal


            $sms_api_url = config('app.SMS_API_URL_FOR_SEND');
            $curl_handle = curl_init();

            curl_setopt_array($curl_handle, array(
                CURLOPT_URL => "$sms_api_url",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t    \"msg\": \"$sms_body\",\n\t    \"destination\": \"$mobile_number\"\n\t\n}\n",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $access_token",
                    "Content-Type: application/json",
                    "Content-Type: text/plain"
                ),
            ));
            $response = curl_exec($curl_handle);
            $emailQueue = EmailQueue::find($id);
            if (curl_errno($curl_handle)) {
                echo "cURL Error #:" . curl_error($curl_handle);
                $emailQueue->sms_status = -1;
                $emailQueue->sms_response = '" . $response . "';
                curl_close($curl_handle);
                continue;
            }
            curl_close($curl_handle);
            // End of Send SMS via API Portal

            $decodeResponse = json_decode($response);
            $sms_response_id = 0;
            $sms_no_of_try = $sms_no_of_try + 1;
            if ($sms_no_of_try > 10) {
                $sms_status = -9; // data is invalid, abort sending
            }

            if ($decodeResponse->status == 200) {
                $sms_status = 1;
                $sms_response_id = $decodeResponse->data->id;
                echo "Successfully sent SMS to - <b> $mobile_number </b><br/>";
            } else {
                $sms_status = -1;
                echo "Could not send SMS to - <b> $mobile_number </b><br/>";
            }


            $emailQueue->sms_status = $sms_status;
            $emailQueue->sms_response_id = $sms_response_id;
            $emailQueue->sms_response = '" . $response . "';
            $emailQueue->sms_no_of_try = $sms_no_of_try;
            $emailQueue->save();
        }

        if (count($sms_queue_data) == 0) {
            echo '<br/>No SMS in queue to send! ' . date("j F, Y, g:i a");
        }
        return '';

    }

    private function getToken()
    {
        $access_token_url = config('app.SMS_API_URL_FOR_TOKEN');
        $access_data = [
            "client_id" => config('app.SMS_CLIENT_ID'),
            "client_secret" => config('app.SMS_CLIENT_SECRET'),
            "grant_type" => config('app.SMS_GRANT_TYPE')
        ];
        try {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($access_data));
            curl_setopt($curl_handle, CURLOPT_URL, $access_token_url);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $result = curl_exec($curl_handle);
            if (curl_errno($curl_handle)) {
                $data = ['responseCode' => 0, 'msg' => curl_error($curl_handle), 'data' => ''];
                curl_close($curl_handle);
                return json_encode($data);
            }
            curl_close($curl_handle);

            if (!$result || !property_exists(json_decode($result), 'access_token')) {
                $data = ['responseCode' => 0, 'msg' => 'SMS API connection failed!', 'data' => ''];
                return json_encode($data);
            }

            $decoded_json = json_decode($result, true);
            $data = [
                'responseCode' => 1,
                'data' => $decoded_json['access_token'],
            ];

            // updating token
            $token = $decoded_json['access_token'];
            $token_expire = (time() + $decoded_json['expires_in']) - 60;
            $token_record = Configuration::where('caption', 'email_sms_api_token')->exists();
            if ($token_record) {
                $config = Configuration::where('caption', 'email_sms_api_token')->first();
                $config->value = $token;
                $config->value2 = $token_expire;
                $config->save();

            } else {
                $config = new Configuration();
                $config->caption = 'email_sms_api_token';
                $config->value = $token;
                $config->value2 = $token_expire;
                $config->save();
            }
        } catch (Exception $e) {
            $data = ['responseCode' => 0, 'msg' => $e->getMessage() . $e->getFile() . $e->getLine(), 'data' => ''];
        }
        return json_encode($data);
    }
}
