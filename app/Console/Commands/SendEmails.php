<?php

namespace App\Console\Commands;

use App\Modules\Settings\Models\Configuration;
use App\Modules\Settings\Models\EmailQueue;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

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
        $email_queue_data = EmailQueue::where('email_status', 0)->orderBy('id', 'desc')->limit(5)
            ->get([
            'id',
            'app_id',
            'caption',
            'email_to',
            'email_cc',
            'email_content',
            'email_no_of_try',
            'attachment',
            'email_subject',
            'attachment_certificate_name'
        ]);
        $count = 0;
        $access_token = '';
        foreach ($email_queue_data as $data )
        {
            $email_to = '';
            $id = $data->id;
            $email_content = $data->email_content;
            $email_subject = $data->email_subject;
            $email_to = str_replace("'", "", $data->email_to);
            $email_cc = str_replace("'", "", $data->email_cc);
            $email_cc_exp = explode(',', $email_cc);
            $attachment = $data->attachment;
            $email_no_of_try =$data->email_no_of_try;
            $count++;



            if (empty($access_token)) {
                $token_response = json_decode($this->getToken());
                if ($token_response->responseCode == 0) {
                    echo $token_response->msg;
                    continue;
                }
                $access_token = $token_response->data;
            }
            $sms_api_url_for_token = config('app.EMAIL_API_URL_FOR_SEND');
            $base_email_for_api = config('app.EMAIL_FROM_FOR_EMAIL_API');
            $email_from_for_email_api = ($email_subject) ? $email_subject . ' <' . $base_email_for_api . '>' : $base_email_for_api;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'sender' => $base_email_for_api,
                'receipant' => $email_to,
                'subject' => $email_subject,
                'bodyText' => '',
                'bodyHtml' => $email_content,
                'cc' => $email_cc
            )));
            curl_setopt($curl_handle, CURLOPT_URL, "$sms_api_url_for_token");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer $access_token",
                "Content-Type: application/x-www-form-urlencoded"
            ));
            $result = curl_exec($curl_handle);
            $emailQueue = EmailQueue::find($id);
            if (curl_errno($curl_handle)) {
                echo "cURL Error #:" . curl_error($curl_handle);
                $emailQueue->email_status = -1;
                $emailQueue->email_response = $result;
                curl_close($curl_handle);
                continue;
            }
            curl_close($curl_handle);
            $decoded_json = json_decode($result, true);

            $email_response_id = 0;
            $email_status = 0; // email has not been sent yet
            $email_no_of_try = $email_no_of_try + 1;
            if ($email_no_of_try > 10) {
                $email_status = -9; // data is invalid, abort sending
                echo "Could not send Email to - <b> $email_to </b><br/>";
            }
            if (isset($decoded_json['status']) and $decoded_json['status'] == 200) {
                $email_status = 1;
                $email_response_id = $decoded_json['data']['id'];
                echo "Successfully sent Email to - <b> $email_to </b><br/>";
            }
            $emailQueue->email_status = $email_status;
            $emailQueue->email_response_id = $email_response_id;
            $emailQueue->email_response = '" . $result . "';
            $emailQueue->email_no_of_try = $email_no_of_try;
            $emailQueue->save();
        }

        if ($count == 0) {
            echo '<br/>No email in queue to send! ' . date("j F, Y, g:i a");
        }
       return '';

    }

    private function getToken()
    {
        $sms_api_url_for_token = config('app.SMS_API_URL_FOR_TOKEN');
        $sms_client_id = config('app.SMS_CLIENT_ID');
        $sms_client_secret = config('app.SMS_CLIENT_SECRET');
        $sms_grant_type = config('app.SMS_GRANT_TYPE');

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
                'client_id' => $sms_client_id,
                'client_secret' => $sms_client_secret,
                'grant_type' => $sms_grant_type
            )));
            curl_setopt($curl, CURLOPT_URL, "$sms_api_url_for_token");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);

            if (curl_errno($curl)) {
                $data = ['responseCode' => 0, 'msg' => curl_error($curl), 'data' => ''];
                curl_close($curl);
                return json_encode($data);
            }
            curl_close($curl);

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
            $token_record = Configuration::where('caption','email_sms_api_token')->exists();
            if ($token_record) {
                $config = Configuration::where('caption','email_sms_api_token')->first();
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
