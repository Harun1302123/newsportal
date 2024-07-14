<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\FAQ\Models\FAQ;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * @return view
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $faqs = FAQ::where('status', 1)
            ->where('is_archived', 0)
            ->orderBy('ordering', 'asc')
            ->get();
        return view('frontend.pages.faq.index', compact('faqs'));
    }
}
