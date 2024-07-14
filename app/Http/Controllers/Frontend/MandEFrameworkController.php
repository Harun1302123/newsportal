<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MandEFrameworkController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data = [];

        return view('frontend.pages.m_and_e_framework.index', $data);
    }

    public function details(): View
    {
        $data = [];

        return view('frontend.pages.m_and_e_framework.details', $data);
    }


}
