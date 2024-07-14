<?php
namespace App\Modules\WebPortal\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StoreHomePageCategoryRequest;
use App\Modules\WebPortal\Models\HomePageContentCategory;
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

class HomePageCategoryController extends Controller
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
        $this->service_id = 35;
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

                $list = HomePageContentCategory::with('user')
                    ->select('id', 'name', 'type', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();
                return Datatables::of($list)
                    ->editColumn('name', function ($row) {
                        return $row->name;
                    })
                    ->editColumn('type', function ($row) {
                        return $row->type;
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
                        return '<a href="' . route('homepage.categories.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['name','type', 'status', 'action'])

                    ->make(true);
            }
            return view('WebPortal::homepage-category.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in HomePageCategoryController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [HomePageCategory-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New HomePage Category';
            $data['add_permission'] = $this->add_permission;
            $data['type'] = ['photo' => 'Photo','video'=>'Video','event'=>'Event','news'=>'News','publication'=>'Publication'];
            return view('WebPortal::homepage-category.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreHomePageCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreHomePageCategoryRequest $request): RedirectResponse
    {
        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $data = HomePageContentCategory::findOrFail($app_id);
            } else {
                $data = new HomePageContentCategory();
            }

            $data->type = $request->get('type');
            $data->name = $request->get('name');
            $data->status = $request->get('status');

            $data->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("homepage.categories.list");

        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Banner-102]");
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
                $data['data'] = HomePageContentCategory::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['type'] = ['photo' => 'Photo','video'=>'Video','event'=>'Event','news'=>'News','publication'=>'Publication'];

                return view('WebPortal::homepage-category.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Banner-103]");
            return redirect()->back();
        }
    }
}
