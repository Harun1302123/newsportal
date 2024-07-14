<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\WebPortal\Http\Requests\StoreMenuItemRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\MenuItem;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;

class MenuItemController extends Controller
{

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;


    public function __construct()
    {
        $this->service_id = 33;
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
                $list = MenuItem::with('user')
                    ->select('menu_items.id', 'menu_items.name', 'menu_items.slug', 'parent.name as parent_name', 'menu_items.status', 'menu_items.updated_at', 'menu_items.updated_by')
                    ->leftJoin('menu_items AS parent', 'menu_items.parent_id', '=', 'parent.id')
                    ->orderBy('menu_items.parent_id')->orderBy('menu_items.ordering')->get();

                return Datatables::of($list)
                    ->editColumn('slug', function ($row) {
                        return $row->slug;
                    })
                    ->editColumn('parent_menu', function ($row) {
                        return $row->parent_name;
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
                        return '<a href="' . route('menu-items.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::menu-items.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in MenuItemController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MenuItem-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New Menu';
            $data['add_permission'] = $this->add_permission;
            $data['menu_items'] = [0 => 'No Parent'] + MenuItem::where('status', 1)->orderBy('ordering', 'asc')->pluck('name', 'id')->all();

            //dd($menu_items);
            //$menu_items = MenuItem::where('status', 1)->orderBy('ordering', 'asc')->pluck('name', 'id')->toArray();
            // ['' => 'Select One'] + PaymentMethod::where('status', 1)->where('is_archive', 0)->lists('name', 'id')->all();
            //$menu_items[0] = 'No Parent';
//            $encryptedItems = [];
//            foreach ($menu_items as $id => $name) {
////                $encryptedid = Encryption::encodeId($id);
//                $encryptedid = $id;
//                $encryptedItems[$encryptedid] = $name;
//            }
            //$data['menu_items'] = $encryptedItems;

            return view('WebPortal::menu-items.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @param StoreMenuItemRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $menuitem = MenuItem::findOrFail($app_id);
            } else {
                $menuitem = new MenuItem();
            }

            $menuitem->parent_id = $request->get('parent_id');
            $menuitem->name = $request->get('name');
            $menuitem->name_bn = $request->get('name_bn');
            $menuitem->slug = $request->get('slug');
            $menuitem->ordering = $request->get('ordering');
            $menuitem->heading_en = $request->get('heading_en');
            $menuitem->heading_bn = $request->get('heading_bn');
            $menuitem->content_en = $request->get('content_en');
            $menuitem->content_bn = $request->get('content_bn');
            $menuitem->status = $request->get('status');
            $menuitem->save();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("menu-items.list");

        } catch (Exception $e) {
            Log::error("Error occurred in MenuItemController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MenuItem-102]");
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
                $data['data'] = MenuItem::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Menu';
                $data['menu_items'] = [0 => 'No Parent'] + MenuItem::where('status', 1)->orderBy('ordering', 'asc')->pluck('name', 'id')->all();

                //dd($data['menu_items']);
//                $menu_items[0] = 'No Parent';
//                $encryptedItems = [];
//                foreach ($menu_items as $id => $name) {
////                    $encryptedid = Encryption::encodeId($id);
//                    $encryptedid = $id;
//                    $encryptedItems[$encryptedid] = $name;
//                }
//                $data['menu_items'] = $encryptedItems;

                return view('WebPortal::menu-items.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (Exception $e) {
            Log::error("Error occurred in MenuItemController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MenuItem-103]");
            return redirect()->back();
        }
    }
}
