<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StoreEventRequest;
use App\Modules\WebPortal\Models\Event;
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

class EventController extends Controller
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
        $this->service_id = 15;
        $this->list_route = 'events.list';
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

                $list = Event::leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'events.event_category')
                    ->with('user')
                    ->select('events.id', 'events.heading_en', 'events.event_date', 'events.image', 'events.status', 'events.updated_at', 'events.updated_by', 'homepage_content_categories.name as category_name')
                    ->orderByDesc('events.id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('image', function ($row) {
                        return "<img width='150px' class='img-thumbnail' src='" .asset($row->image). "' alt='" . htmlspecialchars($row->heading_en) . "'>";
                    })
                    ->editColumn('event_date', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->event_date);
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
                        return '<a href="' . route('events.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image','heading_en', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::events.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in EventController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Event-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New Event';
            $data['add_permission'] = $this->add_permission;
            $data['list_route'] = $this->list_route;
            $data['event_categories'] =  HomePageContentCategory::where('type', 'event')->pluck('name', 'id')->toArray();
            return view('WebPortal::events.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreEventRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $event = Event::findOrFail($app_id);
            } else {
                $event = new Event();
            }

            $event->heading_en = $request->get('heading_en');
            $event->heading_bn = $request->get('heading_bn');
            $event->details_en = $request->get('details_en');
            $event->details_bn = $request->get('details_bn');
            $event->event_category = $request->get('event_category');
            $event->event_date = $request->get('event_date');
            $event->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $event->image = $this->uploadFile($file);
            }

            $event->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route($this->list_route);

        } catch (\Exception $e) {
            Log::error("Error occurred in EventController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [event-102]");
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
                $data['data'] = Event::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Event';
                $data['list_route'] = $this->list_route;
                $data['event_categories'] =  HomePageContentCategory::where('type', 'event')->pluck('name', 'id')->toArray();
                return view('WebPortal::events.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in EventController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Event-103]");
            return redirect()->back();
        }
    }
}
