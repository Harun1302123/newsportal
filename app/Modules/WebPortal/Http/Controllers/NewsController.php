<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Http\Requests\StoreNewsRequest;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;



class NewsController extends Controller
{
    use FileUploadTrait;
    protected $list_route;
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    public function __construct()
    {
        $this->list_route = route('news.list');
        $this->service_id = 40;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')){

                $list = News::with('user','category:id,name')
                    ->select('id', 'title_en', 'image', 'status','category_id' ,'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();
                return Datatables::of($list)
                    ->addColumn('SL', function () {
                        static $count = 1;
                        return $count++;
                    })
                    ->editColumn('title', function ($list) {
                        return Str::limit($list->title_en, 50);
                    })
                    ->editColumn('image', function ($row) {
                        return "<img width='150px' style='height:70px !important' class='img-thumbnail' src='" .asset($row->image). "' alt='" . htmlspecialchars($row->title_en) . "'>";
                    })
                    ->editColumn('category', function ($list) {
                        return Str::limit($list->category->name, 50);
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
                        } elseif ($list->status == 0) {
                            return "<span class='badge badge-danger'>Inactive</span>";
                        }
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('news.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image', 'title', 'status', 'action'])
                    ->make(true);

            }
                return view('WebPortal::news.list',[
                    'add_permission' => $this->add_permission,
                    'edit_permission' => $this->edit_permission,
                ]);

        }
        catch (Exception $e) {
            Log::error("Error occurred in NewsController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [News-101]");
            abort(500, 'Internal Server Error');
        }

    }

    public function create()
    {
        $data['news_category'] = HomePageContentCategory::where('type', 'event')->pluck('name', 'id')->toArray();
        $data['card_title'] = 'Create New News';
        $data['list_route'] = $this->list_route;
        $data['add_permission'] = $this->add_permission;
        return view('WebPortal::news.create', $data);
    }

    public function store(StoreNewsRequest $request)

    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route('news.list');
            }
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $news = News::findOrFail($app_id);
            } else {
                $news = new News();
            }
            $this->saveOrUpdateNews($news,$request);
            Session::flash('success', 'Data save successfully!');
            return redirect('/news/list');
        } catch (\Exception $e) {
            Session::flash('error', "Something went wrong during application data store [News-101]");
            return Redirect::back()->withInput();
        }
    }

    public function edit($id)
    {
        $decode_id = Encryption::decodeId($id);
        $data['data'] = News::where('id', $decode_id)->first();
        $data['news_category'] = HomePageContentCategory::where('type', 'event')->pluck('name', 'id')->toArray();
        $data['edit_permission'] = $this->edit_permission;
        $data['card_title'] = 'Edit News';
        $data['list_route'] = $this->list_route;
        return view('WebPortal::news.edit', $data);
    }


    private function saveOrUpdateNews($news,$request): void
    {
        $news->title_en = $request->get('title_en');
        $news->title_bn = $request->get('title_bn');
        $news->content_en = $request->get('content_en');
        $news->content_bn = $request->get('content_bn');
        $news->status = $request->get('status');
        $news->category_id = $request->get('category_id');


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $news->image = $this->uploadFile($file);
        }
        // for update
        if ($request->hasFile('image_new')) {
            $file = $request->file('image_new');
            $news->image = $this->uploadFile($file);
            // remove old image
            if ($request->image) {
                $old_file_path = public_path($request->image);
                unlink($old_file_path);
            }
        }

        $news->save();
    }

}
