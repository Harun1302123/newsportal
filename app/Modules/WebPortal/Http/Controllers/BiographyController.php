<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StoreBiographyRequest;
use Illuminate\Support\Facades\Redirect;
use App\Modules\WebPortal\Models\Biography;
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

class BiographyController extends Controller
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
        $this->service_id = 32;
        $this->list_route = 'biographies.list';
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
                $list = Biography::with('user')
                    ->select('biographies.id', 'biographies.name_en', 'biographies.name_bn', 'biographies.designation_en', 'biographies.designation_bn', 'biographies.organization_en', 'biographies.image', 'biographies.status', 'biographies.updated_at', 'biographies.updated_by')
                    ->orderByDesc('biographies.id')
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
                        return '<a href="' . route('biographies.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image', 'status', 'action'])
                    ->make(true);
            }
            return view('WebPortal::biographies.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in BiographyController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Biography-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New Biography';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            return view('WebPortal::biographies.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreBiographyRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBiographyRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $biography = Biography::findOrFail($app_id);
            } else {
                $biography = new Biography();
            }

            $biography->name_en = $request->get('name_en');
            $biography->name_bn = $request->get('name_bn');
            $biography->designation_en = $request->get('designation_en');
            $biography->designation_bn = $request->get('designation_bn');
            $biography->organization_en = $request->get('organization_en');
            $biography->organization_bn = $request->get('organization_bn');
            $biography->description_en = $request->get('description_en');
            $biography->description_bn = $request->get('description_bn');
            $biography->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $biography->image = $this->uploadFile($file);
            }

            $biography->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in BiographyController@Store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Biography-102] ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
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
                $data['data'] = Biography::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Biography';
                $data['list_route'] = $this->list_route;

                return view('WebPortal::biographies.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");

        } catch (Exception $e) {
            Log::error("Error occurred in BiographyController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Biography-103]");
            return redirect()->back();
        }
    }
}
