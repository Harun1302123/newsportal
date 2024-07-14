<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SdgNfisController extends Controller
{
    /**
     * @return view
     */
    public static function index(): View
    {
        $data = [];

        return view('frontend.pages.sdg_ngis.index', $data);
    }

}
