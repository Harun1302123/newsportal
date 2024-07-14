<?php

namespace App\Modules\SignUpOrganization\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use Yajra\DataTables\DataTables;
use App\Modules\SignUpOrganization\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Libraries\Encryption;
use App\Modules\SignUpOrganization\Http\Requests\SignUpOrganizationRequest;
use App\Modules\Users\Models\Organigation;
use App\Modules\Users\Models\OrganizationType;
use PHPUnit\Exception;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class SignUpOrganizationController extends Controller
{
    protected string $list_route;
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = route('signup-organizations.list');
        $this->service_id = 42;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws \Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {

                $list = Organization::with(['user', 'organizationType:id,organization_type'])
                    ->select('id', 'organization_name_en', 'organization_type', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('organization_name_en', function ($row) {
                        return "<a href='" . $row->organization_name_en . "' target='_blank' class='text-dark'>" . $row->organization_name_en . "</a>";
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('organization_type', function ($row) {
                        return $row->organizationType->organization_type;
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->editColumn('status', function ($row) {
                        return $row->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('signup-organizations.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['organization_name_en', 'status', 'action'])
                    ->make(true);
            }

            return view('SignUpOrganization::list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in SignUpOrganizationController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [SignUp Organization -101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data['card_title'] = 'Create New SignUp Organization';
        $data['list_route'] = $this->list_route;
        $data['add_permission'] = $this->add_permission;
        $data['organization_types'] = OrganizationType::query()->whereStatus(1)->pluck('organization_type', 'id');
        return view('SignUpOrganization::create', $data);
    }

    /**
     * @param SignUpOrganizationRequest $request
     * @param SignUpOrganization $signUp_organization
     * @return RedirectResponse
     */
    public function store(SignUpOrganizationRequest $request, Organization $signUp_organization): RedirectResponse
    {
        try {
            $this->saveOrUpdate($signUp_organization, $request);

            Session::flash('success', 'Data save successfully!');
            return redirect()->route('signup-organizations.list');
        } catch (\Exception $e) {
            Log::error("Error occurred in SignUpOrganizationController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [SignUp Organization -102]");
            return Redirect::back()->withInput();
        }
    }
    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['data'] = Organigation::where('id', $decode_id)->first();
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit SignUp Organization ';
            $data['list_route'] = $this->list_route;
            $data['organization_types'] = OrganizationType::query()->whereStatus(1)->pluck('organization_type', 'id');
            return view('SignUpOrganization::edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in SignUpOrganizationController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [SignUp Organization -103]");
            return redirect()->back();
        }
    }

    /**
     * @param SignUpOrganizationRequest $request
     * @return RedirectResponse
     */
    public function update(SignUpOrganizationRequest $request): RedirectResponse
    {
        try {

            $signUp_organization_id = Encryption::decodeId($request->get('id'));
            $signUp_organization = Organigation::findOrFail($signUp_organization_id);
    
            $this->saveOrUpdate($signUp_organization, $request);

            Session::flash('success', 'Data Updated successfully!');
            return redirect()->route('signup-organizations.list');
        } catch (Exception $e) {
            Log::error("Error occurred in SignUpOrganizationController@update ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data update [SignUp Organization -104]");
            return Redirect::back()->withInput();
        }
    }

    /**
     * @param SignUpOrganization $signUp_organization
     * @param
     * @return void
     */
    private function saveOrUpdate($signUp_organization, $request): void
    {
        try {

            $signUp_organization->organization_name_en = $request->get('organization_name_en');
            $signUp_organization->organization_name_bn = $request->get('organization_name_bn');
            $signUp_organization->organization_type = $request->get('organization_type');
            $signUp_organization->status = $request->get('status');
            $signUp_organization->save();
        } catch (\Exception $e) {
            Log::error("Error occurred in SignUpOrganizationController@saveOrUpdate ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data saveOrUpdate [SignUp Organization -105]");
        }
    }
}
