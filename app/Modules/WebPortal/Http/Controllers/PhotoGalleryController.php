<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StorePhotoGalleryRequest;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Models\PhotoGallery;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PhotoGalleryController extends Controller
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
        $this->service_id = 16;
        $this->list_route = 'photo-galleries.list';
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

                $list = PhotoGallery::leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'photo_galleries.resource_category')
                    ->with('user')
                    ->select('photo_galleries.id', 'photo_galleries.title_en', 'photo_galleries.image', 'photo_galleries.status', 'photo_galleries.updated_at', 'photo_galleries.updated_by', 'homepage_content_categories.name as category_name')
                    ->orderByDesc('photo_galleries.id')
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
                        return '<a href="' . route('photo-galleries.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image','title_en', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::photo-gallery.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in PhotoGalleryController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Photo Gallery-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New Photo Gallery';
            $data['add_permission'] = $this->add_permission;
            $data['list_route'] = $this->list_route;
            $data['resource_categories'] =  HomePageContentCategory::where('type', 'resource_category')->pluck('name', 'id')->toArray();
            return view('WebPortal::photo-gallery.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StorePhotoGalleryRequest $request
     * @return RedirectResponse
     */
    public function store(StorePhotoGalleryRequest $request): RedirectResponse
    {
        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $photoGallery = PhotoGallery::findOrFail($app_id);
            } else {
                $photoGallery = new PhotoGallery();
            }

            $photoGallery->title_en = $request->get('title_en');
            $photoGallery->title_bn = $request->get('title_bn');
            $photoGallery->details_en = $request->get('details_en');
            $photoGallery->details_bn = $request->get('details_bn');
            $photoGallery->resource_category = $request->get('photo_category');
            $photoGallery->ordering = $request->get('ordering') ?? 0;
            $photoGallery->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $photoGallery->image = $this->uploadFile($file);
            }

            $photoGallery->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route($this->list_route);

        } catch (\Exception $e) {
            Log::error("Error occurred in PhotoGalleryController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Photo Gallery-102]");
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
                $data['data'] = PhotoGallery::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Photo Gallery';
                $data['list_route'] = $this->list_route;
                $data['resource_categories'] =  HomePageContentCategory::where('type', 'photo')->pluck('name', 'id')->toArray();
                return view('WebPortal::photo-gallery.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in PhotoGalleryController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Photo Gallery-103]");
            return redirect()->back();
        }
    }
}
