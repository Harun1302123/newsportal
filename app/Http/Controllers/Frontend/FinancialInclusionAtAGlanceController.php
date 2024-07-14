<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\FinancialInclusion\Models\FinancialInclusion;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\Users\Models\OrganizationType;
use Illuminate\View\View;
use Illuminate\Http\Request;

class FinancialInclusionAtAGlanceController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $data['quarter'] =  MefQuarter::pluck('name', 'id')->toArray();
        $data['year'] = FinancialInclusion::distinct()->pluck('mef_year', 'mef_year')->toArray();
        $data['organization_types'] = OrganizationType::where('status', 1)->where('id','!=','8')->pluck('financial_inclusion_title', 'id')->toArray();

        if ($request->input('data')) {
            $id = Encryption::decodeId($request->input('data'));
            $data['financial_inclusion'] =  FinancialInclusion::findorfail($id);
        }

        return view('frontend.pages.financial_inclusion_at_a_glance.index', $data);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function details(Request $request): View
    {
        $mef_year = $request->get('mef_year');
        $mef_quarter_id = $request->get('mef_quarter_id');
        $organization_type_id = $request->get('organization_type_id');

        $financial_inclusion = FinancialInclusion::with('quarter','organization_types')
            ->where('mef_year', $mef_year)
            ->where('mef_quarter_id', $mef_quarter_id)
            ->where('organization_type_id', $organization_type_id)
            ->where('status', 1)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')
            ->first();

        $data['data'] = $financial_inclusion;
        $data['male'] = ($financial_inclusion->male ?? 0) + ($financial_inclusion->male_rural ?? 0) + ($financial_inclusion->male_urban ?? 0);
        $data['female'] = ($financial_inclusion->female ?? 0) + ($financial_inclusion->female_rural ?? 0) + ($financial_inclusion->female_urban ?? 0);
        $data['others'] =  ($financial_inclusion->others_rural ?? 0) + ($financial_inclusion->others_urban ?? 0);
        $data['rural'] =  ($financial_inclusion->total_rural ?? 0);
        $data['urban'] =  ($financial_inclusion->total_urban ?? 0);

        return view('frontend.pages.financial_inclusion_at_a_glance.details', $data);
    }
}
