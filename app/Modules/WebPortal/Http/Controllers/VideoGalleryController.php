<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StoreVideoGalleryRequest;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Models\VideoGallery;
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

class VideoGalleryController extends Controller
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
        $this->service_id = 20;
        $this->list_route = 'video-galleries.list';
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

                $list = VideoGallery::leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'video_galleries.tutorial_category')
                    ->with('user')
                    ->select('video_galleries.id', 'video_galleries.title_en','video_galleries.image as image' , 'video_galleries.ordering as order', 'video_galleries.status', 'video_galleries.updated_at', 'video_galleries.updated_by','homepage_content_categories.name as category_name')
                    ->orderByDesc('video_galleries.id')
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
                        return '<a href="' . route('video-galleries.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image','title_en', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::video-gallery.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in VideoGalleryController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Video Gallery-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
           $data['tutorial_categories'] = HomePageContentCategory::where('type', 'video')->pluck('name', 'id')->toArray();
            $data['card_title'] = 'Create New Video Gallery';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            return view('WebPortal::video-gallery.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreVideoGalleryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreVideoGalleryRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $videoGallery = VideoGallery::findOrFail($app_id);
            } else {
                $videoGallery = new VideoGallery();
            }

            $videoGallery->title_en = $request->get('title_en');
            $videoGallery->title_bn = $request->get('title_bn');
            $videoGallery->status = $request->get('status');
            $videoGallery->tutorial_category = $request->get('tutorial_category');
            $videoGallery->url = $request->get('url');
            $videoGallery->video_length = $request->get('video_length');
            $videoGallery->ordering = $request->get('ordering') ?? 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $videoGallery->image = $this->uploadFile($file);
            }
            $videoGallery->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route($this->list_route);

        } catch (Exception $e) {
            Log::error("Error occurred in VideoGalleryController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Video Gallery-102]");
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
                $data['data'] = VideoGallery::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Video Gallery';
                $data['list_route'] = $this->list_route;
                $data['tutorial_categories'] = HomePageContentCategory::where('type', 'video')->pluck('name', 'id')->toArray();
                return view('WebPortal::video-gallery.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in VideoGalleryController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Video Gallery-103]");
            return redirect()->back();
        }
    }
}
