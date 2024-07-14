<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Goals\Models\Goal;
use Illuminate\View\View;

class SteeringCommitteeController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data = [];

        return view('frontend.pages.steering_committee.index', $data);
    }

}
