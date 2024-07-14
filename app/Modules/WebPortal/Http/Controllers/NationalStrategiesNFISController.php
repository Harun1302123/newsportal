<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Models\NationalStrategiesNFIS;
use Illuminate\Support\Facades\Redirect;
use App\Modules\WebPortal\Http\Requests\StoreNationalStrategiesNFISRequest;
use Illuminate\Support\Facades\Response;

class NationalStrategiesNFISController extends Controller
{
    use FileUploadTrait;

    protected string $list_route;
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->service_id = 57;
        $this->list_route = 'national_strategies_nfis.list';
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

                $list = NationalStrategiesNFIS::with('user')
                    ->select('id', 'title_en', 'attachment', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('attachment', function ($row) {
                        return '<a href="' . asset($row->attachment) . '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="far fa-file-pdf"></i> PDF</a><br>';
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->editColumn('status', function ($row) {
                        return $row->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('national_strategies_nfis.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['attachment', 'status', 'action'])
                    ->make(true);

            } else {
                return view('WebPortal::national_strategies_nfis.list', [
                    'add_permission' => $this->add_permission,
                    'edit_permission' => $this->edit_permission,
                ]);

            }
        } catch (Exception $e) {
            Log::error("Error occurred in NationalStrategiesNFISController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [NationalStrategiesNFIS-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New National Strategies NFIS';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            return view('WebPortal::national_strategies_nfis.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreNationalStrategiesNFISRequest $request
     * @return RedirectResponse
     */
    public function store(StoreNationalStrategiesNFISRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $national_strategies_nfis = NationalStrategiesNFIS::findOrFail($app_id);
            } else {
                $national_strategies_nfis = new NationalStrategiesNFIS();
            }

            $national_strategies_nfis->title_en = $request->get('title_en');
            $national_strategies_nfis->title_bn = $request->get('title_bn');
            $national_strategies_nfis->status = $request->get('status');

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $national_strategies_nfis->attachment = $this->uploadFile($file);
            }
            $national_strategies_nfis->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in NationalStrategiesNFISController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [NationalStrategiesNFIS-102]");
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
            $data['data'] = NationalStrategiesNFIS::findOrFail($decode_id);
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit National Strategies NFIS';
            $data['list_route'] = $this->list_route;
            return view('WebPortal::national_strategies_nfis.edit', $data);

        } catch (Exception $e) {
            Log::error("Error occurred in ResourceController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Resource-103]");
            return redirect()->back();
        }
    }
}
