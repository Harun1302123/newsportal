<?php

namespace App\Http\Controllers\Frontend;

use App\Modules\WebPortal\Models\Stakeholder;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StakeholderController extends Controller
{
    /**
     * @return view
     */
    public function index(): View|RedirectResponse
    {
        $data = [];

        $stakeholders_data = Stakeholder::join('stakeholder_organizations', 'stakeholders.id', '=', 'stakeholder_organizations.stakeholder_id','left outer')
            ->select('stakeholders.*', 'stakeholder_organizations.name_en as organization_name_en', 'stakeholder_organizations.name_bn as organization_name_bn','stakeholder_organizations.url as organization_url')
            ->orderBy('stakeholders.ordering')
            ->orderBy('stakeholder_organizations.ordering')
            ->get()->toArray();

        foreach ($stakeholders_data as $stakeholder_data){
            $data['stakeholders'][$stakeholder_data['id']]['name_en'] = $stakeholder_data['name_en'];
            $data['stakeholders'][$stakeholder_data['id']]['name_bn'] = $stakeholder_data['name_bn'];
            $data['stakeholders'][$stakeholder_data['id']]['url'] = $stakeholder_data['url'];
            $organization_data=[];
            $organization_data['organization_name_en'] = $stakeholder_data['organization_name_en'];
            $organization_data['organization_name_bn'] = $stakeholder_data['organization_name_bn'];
            $organization_data['organization_url'] = $stakeholder_data['organization_url'];
            $data['stakeholders'][$stakeholder_data['id']]['organizations'][] = $organization_data;

        }
        return view('frontend.pages.stakeholders.index', $data);
    }

}
