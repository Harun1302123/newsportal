<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\WebPortal\Models\NationalStrategiesNFIS;
use Illuminate\View\View;

class NationalStrategiesAndNFISController extends Controller
{
    /**
     * @return view
     */
    public static function index(): View
    {
        $data['data'] = NationalStrategiesNFIS::where('status',1)->get();

        return view('frontend.pages.national_strategies_nfis.index', $data);
    }



}
