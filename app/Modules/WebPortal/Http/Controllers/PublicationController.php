<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\WebPortal\Models\HomePageContentCategory;
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
use App\Modules\WebPortal\Models\Publication;
use Illuminate\Support\Facades\Redirect;
use App\Modules\WebPortal\Http\Requests\StorePublicationRequest;
use Illuminate\Support\Facades\Response;

class PublicationController extends Controller
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
        $this->service_id = 46;
        $this->list_route = 'publications.list';
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

                $list = Publication::with('user')
                    ->select('id', 'title_en', 'attachment','image', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('attachment', function ($row) {
                        return '<a href="' . asset($row->attachment) . '" target="_blank" class="btn btn-sm btn-outline-dark" ><i class="far fa-file-pdf"></i> PDF</a><br>';
                    })
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
                        return '<a href="' . route('publications.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['attachment','image', 'status', 'action'])
                    ->make(true);

            } else {
                return view('WebPortal::publication.list', [
                    'add_permission' => $this->add_permission,
                    'edit_permission' => $this->edit_permission,
                ]);

            }
        } catch (Exception $e) {
            Log::error("Error occurred in publicationController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [publicationController-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New publication';
            $data['list_route'] = $this->list_route;
            $data['categories'] = HomePageContentCategory::where('type', 'publication')->pluck('name', 'id')->toArray();
            $data['add_permission'] = $this->add_permission;
            return view('WebPortal::publication.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StorepublicationRequest $request
     * @param publication $publication
     * @return RedirectResponse
     */
    public function store(StorePublicationRequest $request, publication $publication): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $publication = Publication::findOrFail($app_id);
            } else {
                $publication = new Publication();
            }

            $publication->category_id = $request->get('category');
            $publication->title_en = $request->get('title_en');
            $publication->title_bn = $request->get('title_bn');
            $publication->description_en = $request->get('description_en');
            $publication->description_bn = $request->get('description_bn');

            $publication->status = $request->get('status');

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $publication->attachment = $this->uploadFile($file);
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $publication->image = $this->uploadFile($file);
            }
            $publication->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in publicationController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Publication-102]");
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
            $data['data'] = publication::findOrFail($decode_id);
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Publication';
            $data['list_route'] = $this->list_route;
            $data['categories'] = HomePageContentCategory::where('type', 'publication')->pluck('name', 'id')->toArray();

            return view('WebPortal::publication.edit', $data);

        } catch (Exception $e) {
            Log::error("Error occurred in PublicationController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Publication-103]");
            return redirect()->back();
        }
    }
}
