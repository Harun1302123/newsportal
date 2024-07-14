<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Goals\Models\Goal;
use App\Modules\Targets\Models\Target;
use Illuminate\View\View;

class StrategicGoalsController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data = [];

        $data['goals'] = goals();

        return view('frontend.pages.strategic_goals.index', $data);
    }

}
