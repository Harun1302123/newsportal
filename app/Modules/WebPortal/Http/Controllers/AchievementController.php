<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StoreAchievementRequest;
use App\Traits\FileUploadTrait;
use PHPUnit\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;


class AchievementController extends Controller
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
        $this->list_route = route('achievements.list');
        $this->service_id = 36;
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

                $list = Achievement::with('user')
                    ->select('id', 'title_en', 'image', 'number_en', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('image', function ($row) {
                        return "<img width='150px' style='height:70px !important' class='img-thumbnail' src='" . asset($row->image) . "' alt='" . htmlspecialchars($row->title_en) . "'>";
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
                        return '<a href="' . route('achievements.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image', 'title_en', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::achievement.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in AchievementController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Achievement-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data['card_title'] = 'Create New Achievement';
        $data['list_route'] = $this->list_route;
        $data['add_permission'] = $this->add_permission;
        return view('WebPortal::achievement.create', $data);
    }

    /**
     * @param StoreAchievementRequest $request
     * @param Achievement $achievement
     * @return RedirectResponse
     */
    public function store(StoreAchievementRequest $request, Achievement $achievement): RedirectResponse
    {
        try {
            $this->saveOrUpdate($achievement, $request);

            Session::flash('success', 'Data save successfully!');
            return redirect()->route('achievements.list');
        } catch (\Exception $e) {
            Log::error("Error occurred in AchievementController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Achievement-102]");
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
            $data['data'] = Achievement::findOrFail($decode_id);
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Achievement';
            $data['list_route'] = $this->list_route;
            return view('WebPortal::achievement.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in AchievementController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Achievement-103]");
        }
    }


    /**
     * @param StoreAchievementRequest $request
     * @return RedirectResponse
     */
    public function update(StoreAchievementRequest $request): RedirectResponse
    {
        try {
            $achievement_id = Encryption::decodeId($request->get('id'));
            $achievement = Achievement::findOrFail($achievement_id);
            $this->saveOrUpdate($achievement, $request);

            Session::flash('success', 'Data Updated successfully!');
            return redirect()->route('achievements.list');
        } catch (Exception $e) {
            Log::error("Error occurred in AchievementController@update ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data update [Achievement-104]");
            return Redirect::back()->withInput();
        }
    }
    /**
     * @param $achievement
     * @param $request
     * @return void
     */
    private function saveOrUpdate($achievement, $request): void
    {
        try {
            $achievement->title_en = $request->get('title_en');
            $achievement->title_bn = $request->get('title_bn');
            $achievement->number_en = $request->get('number_en');
            $achievement->number_bn = $request->get('number_bn');
            $achievement->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $achievement->image = $this->uploadFile($file);
            }

            $achievement->save();
        } catch (\Exception $e) {
            Log::error("Error occurred in AchievementController@saveOrUpdate ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data saveOrUpdate [Achievement-105]");
        }
    }
}
