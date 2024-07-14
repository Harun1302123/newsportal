<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\WebPortal\Http\Requests\StoreBannerRequest;
use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\Banner;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;

class BannerController extends Controller
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
        $this->service_id = 30;
        $this->list_route = 'banners.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request) : View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {

                $list = Banner::with('user')
                    ->select('id', 'title_en', 'image', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('image', function ($row) {
                        return "<img width='150px' class='img-thumbnail' src='" .asset($row->image). "' alt='" . htmlspecialchars($row->title_en) . "'>";
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
                        return '<a href="' . route('banners.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image','title_en', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::banners.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Banner-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            if ($this->add_permission) {
                $data['card_title'] = 'Create New Banner';
                $data['list_route'] = $this->list_route;
                $data['add_permission'] = $this->add_permission;
                return view('WebPortal::banners.create', $data);
            }
            return redirect()->back()->with('error', "Don't have create permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Banner-102]");
            return redirect()->back();
        }

    }

    /**
     * @param StoreBannerRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBannerRequest $request): RedirectResponse
    {
        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $banner = Banner::findOrFail($app_id);
            } else {
                $banner = new Banner();
            }

            $banner->title_en = $request->get('title_en');
            $banner->title_bn = $request->get('title_bn');
            $banner->description_en = $request->get('description_en');
            $banner->description_bn = $request->get('description_bn');
            $banner->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $banner->image = $this->uploadFile($file);
            }

            $banner->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Banner-103]");
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
                $data['data'] = Banner::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Banner';
                $data['list_route'] = $this->list_route;
                return view('WebPortal::banners.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Banner-104]");
            return redirect()->back();
        }
    }

}
