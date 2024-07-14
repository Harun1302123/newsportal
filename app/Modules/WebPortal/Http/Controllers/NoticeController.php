<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\WebPortal\Http\Requests\StoreNoticeRequest;
use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\Notice;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;

class NoticeController extends Controller
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
        $this->service_id = 33;
        $this->list_route = 'notices.list';
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

                $list = Notice::with('user')
                    ->select('id', 'title', 'attachment', 'publish_at', 'achieve_at', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('title', function ($row) {
                        return $row->title;
                    })
                    ->editColumn('attachment', function ($row) {
                        return '<a href="' . asset($row->attachment) . '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="far fa-file-pdf"></i> PDF</a><br>';
                    })
                    ->editColumn('publish_at', function ($row) {
                        return CommonFunction::formatdate($row->publish_at);
                    })
                    ->editColumn('achieve_at', function ($row) {
                        return CommonFunction::formatdate($row->achieve_at);
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
                        return '<a href="' . route('notices.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['attachment', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::notice.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Notice-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New Notice';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            return view('WebPortal::notice.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreNoticeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreNoticeRequest $request): RedirectResponse
    {
        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $notice = Notice::findOrFail($app_id);
            } else {
                $notice = new Notice();
            }

            $notice->title = $request->get('title');
            $notice->body = $request->get('body');
            $notice->publish_at = $request->get('publish_at');
            $notice->achieve_at = $request->get('achieve_at');
            $notice->status = $request->get('status');

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $notice->attachment = $this->uploadFile($file);
            }
            $notice->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Notice-102]");
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
                $data['data'] = Notice::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Notice';
                $data['list_route'] = $this->list_route;
                return view('WebPortal::notice.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Notice-103]");
            return redirect()->back();
        }
    }






}
