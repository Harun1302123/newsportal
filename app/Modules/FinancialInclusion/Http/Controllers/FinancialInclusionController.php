<?php

namespace App\Modules\FinancialInclusion\Http\Controllers;

use App\Modules\FinancialInclusion\Http\Requests\StoreFinancialInclusionRequest;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\MonitoringFramework\Models\MefYear;
use Exception;
use App\Libraries\ACL;
use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Users\Models\OrganizationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Modules\FinancialInclusion\Models\FinancialInclusion;
class FinancialInclusionController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    const BANK = 1;
    const NBFI = 2;
    const MFS = 3;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->service_id = 64;
        $this->list_route = 'financial_inclusions.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = FinancialInclusion::with('user','quarter')->orderBy('id', 'desc')->get();
                return Datatables::of($list)
                    ->addColumn('SL', function () {
                        static $count = 1;
                        return $count++;
                    })
                    ->editColumn('year', function ($list) {
                        return Str::limit($list->mef_year, 50);
                    })
                    ->editColumn('quarter', function ($list) {
                        return Str::limit($list->quarter->name, 80);
                    })
                    ->editColumn('organization_type_text', function ($list) {
                        return Str::limit($list->organization_type_text, 80);
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->editColumn('status', function ($list) {
                        if ($list->status == 1) {
                            return "<span class='badge badge-success'>Active</span>";
                        } else {
                            return "<span class='badge badge-info'>Inactive</span>";
                        }
                    })
                    ->addColumn('action', function ($list) {
                        if ($this->edit_permission) {
                           return '<a href="' . url('/financial_inclusions/edit/' . Encryption::encodeId($list->id)) . '" class="btn btn-sm btn-outline-dark m-1"> <i class="fa fa-edit"></i> Edit</a>';
                        }
                        return '';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            return view('FinancialInclusion::list', ['add_permission' => $this->add_permission, 'edit_permission' => $this->edit_permission, 'view_permission' => $this->view_permission]);
        } catch (Exception $e) {
            Log::error("Error occurred in FinancialInclusionController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [FinancialInclusion-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            if ($this->add_permission) {
                $data['card_title'] = 'New Financial Inclusion';
                $data['add_permission'] = $this->add_permission;

                $data['organization_types'] = OrganizationType::where('status', 1)->where('id','!=','8')->pluck('organization_type', 'id')->toArray();
                $data['year'] = MefYear::where('status', 1)->pluck('year', 'year')->toArray();
                $data['quarter'] =  MefQuarter::pluck('name', 'id')->toArray();

                return view('FinancialInclusion::create', $data);
            }
            return redirect()->back()->with('error', "Don't have create permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in FinancialInclusionController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [FinancialInclusion-102]");
            return redirect()->back();
        }
    }

    /**
     * @param StoreFinancialInclusionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFinancialInclusionRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add or edit permission");
                return redirect()->route($this->list_route);
            }
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $financial_inclusion = FinancialInclusion::findOrFail($app_id);
            } else {
                $financial_inclusion = new FinancialInclusion();
            }

            $financial_inclusion->mef_year = $request->get('mef_year');
            $financial_inclusion->mef_quarter_id = $request->get('mef_quarter_id');
            $financial_inclusion->organization_type_id = $request->get('organization_type_id');

            if (in_array($request->get('organization_type_id'), [self::BANK, self::NBFI, self::MFS])) {
                $financial_inclusion->male_rural = $request->get('male_rural');
                $financial_inclusion->male_urban = $request->get('male_urban');
                $financial_inclusion->female_rural = $request->get('female_rural');
                $financial_inclusion->female_urban = $request->get('female_urban');
                $financial_inclusion->others_rural = $request->get('others_rural');
                $financial_inclusion->others_urban = $request->get('others_urban');
                $financial_inclusion->total_rural = $request->get('total_rural');
                $financial_inclusion->total_urban = $request->get('total_urban');
                $financial_inclusion->total = $request->get('total_a');
            } else {
                $financial_inclusion->male = $request->get('male');
                $financial_inclusion->female = $request->get('female');
                $financial_inclusion->total = $request->get('total_b');
            }

            $financial_inclusion->status = $request->get('status');
            $financial_inclusion->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in FinancialInclusionController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [FinancialInclusion-103]");
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
            if ($this->edit_permission) {
                $data['edit_permission'] = $this->edit_permission;
                $decode_id = Encryption::decodeId($id);
                $data['data'] = FinancialInclusion::findOrFail($decode_id);

                $data['organization_types'] = OrganizationType::where('status', 1)->where('id','!=','8')->pluck('organization_type', 'id')->toArray();
                $data['year'] = MefYear::where('status', 1)->pluck('year', 'year')->toArray();
                $data['quarter'] =  MefQuarter::pluck('name', 'id')->toArray();

                return view('FinancialInclusion::edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in FinancialInclusionController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [FinancialInclusion-103]");
            return redirect()->back();
        }
    }
}
