<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

trait FileUploadTrait
{
    /**
     * Uploads a file to the server and returns the path where the file has been saved.
     * @param $file
     * @return string
     */
    public function uploadFile($file): string
    {
        try {

            if (!$file->isValid()) {
                throw new Exception('Invalid file uploaded.');
            }

            $year = date('Y');
            $month = date('m');
            $year_month = $year . '/' . $month . '/';
            $local_path = config('app.upload_doc_path') . $year_month;
            $db_path = uniqid($local_path . time() . '_', false) . '.' . $file->getClientOriginalExtension();

            // Create directories if they don't exist
            if (!file_exists($local_path)) {

                $year_directory = config('app.upload_doc_path') . $year . '/';
                if (!file_exists($year_directory)) {
                    mkdir($year_directory, 0755, true);
                    file_put_contents($year_directory . 'index.html', ''); // Create an index.html file
                }

                mkdir($local_path, 0755, true);
                file_put_contents($local_path . 'index.html', ''); // Create an index.html file
            }

            $file->move($local_path, $db_path);

            return $db_path;

        } catch (Exception $e) {
            Log::error("Error occurred in FileUploadTrait@uploadFile ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [FileUpload-101]");
            return Redirect::back()->withInput();
        }
    }
}
