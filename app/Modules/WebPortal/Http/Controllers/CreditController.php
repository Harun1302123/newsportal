<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Libraries\ImageProcessing;
use App\Modules\WebPortal\Http\Requests\StoreBiographyRequest;
use App\Modules\WebPortal\Http\Requests\StoreCreditRequest;
use Illuminate\Support\Facades\Redirect;
use App\Modules\WebPortal\Models\Credit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Response;
use App\Traits\FileUploadTrait;

class CreditController extends Controller
{
    use FileUploadTrait;

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->service_id = 39;
        $this->list_route = 'credits.list';
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
                $list = Credit::with('user')
                    ->select('id', 'name_en', 'name_bn', 'designation_en', 'designation_bn', 'details_en', 'image', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('name', function ($row) {
                        return Str::limit($row->name_en, 50);
                    })
                    ->editColumn('designation', function ($row) {
                        return Str::limit($row->designation_en, 50);
                    })
                    ->editColumn('organization', function ($row) {
                        return Str::limit($row->organization_en, 50);
                    })
                    ->editColumn('image', function ($row) {
                        return "<img class='img-thumbnail' src='" . asset($row->image) . "' alt='" . htmlspecialchars($row->name_en) . "'>";
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return optional($row->user)->name_eng;
                    })
                    ->editColumn('status', function ($row) {
                        return $row->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="'. route('credits.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image', 'status', 'action'])
                    ->make(true);
            }
            return view('WebPortal::credit.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in CreditController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Credit-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New Credit';
            $data['list_route'] = $this->list_route;
            $data['types'] = [
                'aspire_to_innovate'=>'Aspire to Innovate (a2i)',
                'nfis_tracker_development_&_maintenance_team'=>'NFIS Tracker Development & Maintenance Team',
                'business_automation_ltd'=>'Business Automation Ltd',
            ];
            $data['add_permission'] = $this->add_permission;
            return view('WebPortal::credit.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreCreditRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCreditRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $credit = Credit::findOrFail($app_id);
            } else {
                $credit = new Credit();
            }
            $credit->type = $request->get('type');
            $credit->name_en = $request->get('name_en');
            $credit->name_bn = $request->get('name_bn');
            $credit->designation_en = $request->get('designation_en');
            $credit->designation_bn = $request->get('designation_bn');
            $credit->details_en = $request->get('details_en');
            $credit->details_bn = $request->get('details_en');
            $credit->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $credit->image = $this->uploadFile($file);
            }

            $credit->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in CreditController@Store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Credit-102] ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
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
                $decode_id = Encryption::decodeId($id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Credit';
                $data['list_route'] = $this->list_route;
                $data['data'] = Credit::findOrFail($decode_id);
                $data['types'] = [
                    'aspire_to_innovate'=>'Aspire to Innovate (a2i)',
                    'nfis_tracker_development_&_maintenance_team'=>'NFIS Tracker Development & Maintenance Team',
                    'business_automation_ltd'=>'Business Automation Ltd',
                ];
                return view('WebPortal::credit.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");

        } catch (Exception $e) {
            Log::error("Error occurred in CreditController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Credit-103]");
            return redirect()->back();
        }
    }
}
