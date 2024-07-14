<?php

namespace App\Modules\Goals\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Goals\Http\Request\GoalsRequest;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Goals\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Exception;
use App\Traits\FileUploadTrait;
use Symfony\Component\HttpFoundation\Response;

class GoalController extends Controller
{
    use FileUploadTrait;

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 2;
        $this->list_route = 'goals.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws \Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Goal::with('user')
                    ->select('id','order', 'title_en', 'updated_at', 'updated_by')
                    ->orderBy('order')
                    ->get();
                return Datatables::of($list)
                    ->editColumn('order', function ($list) {
                        return $list->order;
                    })
                    ->editColumn('title_en', function ($list) {
                        return $list->title_en;
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->addColumn('action', function ($list) {
                        if ($this->edit_permission) {
                            return '<a href="' . URL::to('goals/edit/' . Encryption::encodeId($list->id)) .
                                '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a> ';
                        }
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
            return view('Goals::list', ['add_permission' => $this->add_permission, 'edit_permission' => $this->edit_permission]);

        } catch (Exception $e) {
            Log::error("Error occurred in GoalController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Goal-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function store(GoalsRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add or edit permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $goal = Goal::findOrFail($app_id);
            } else{
                $goal = new Goal();
            }

            $goal->title_en =$request->get('title_en');
            $goal->title_bn =$request->get('title_bn');
            // $goal->hex_color = $request->get('colorpicker');;
            // $goal->description_en = $request->get('description_en');
            // $goal->description_bn = $request->get('description_bn');
            // $goal->order = $request->get('order');
            $goal->status = 1;

            if ($request->hasFile('bg_image')) {
                $file = $request->file('bg_image');
                $goal->image = $this->uploadFile($file);
            }

            $goal->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in GoalController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Goal-102]");
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
            if (!($this->edit_permission)) {
                Session::flash('error', "Don't have edit permission");
                return redirect()->route($this->list_route);
            }
            $decode_id = Encryption::decodeId($id);
            $data['data'] = Goal::findOrFail($decode_id);
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Goal';
            return view('Goals::edit',$data);
            
        } catch (\Exception $e) {
            Log::error("Error occurred in GoalController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Goal-103]");
            return redirect()->back();
        }
    }

}
