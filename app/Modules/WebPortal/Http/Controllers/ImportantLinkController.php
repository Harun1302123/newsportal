<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\ImportantLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Http\Requests\StoreImportantLinkRequest;
use PHPUnit\Exception;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ImportantLinkController extends Controller
{
    protected string $list_route;
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = route('important-links.list');
        $this->service_id = 31;
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

                $list = ImportantLink::with('user')
                    ->select('id', 'title_en', 'important_link', 'status', 'updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('title_en', function ($row) {
                        return "<a href='" . $row->important_link . "' target='_blank' class='text-dark'>" . $row->title_en . "</a>";
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
                        return '<a href="' . route('important-links.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['title_en', 'status', 'action'])
                    ->make(true);
            }

            return view('WebPortal::important-links.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred in ImportantLinkController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Important Link-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data['card_title'] = 'Create New Important Link';
        $data['list_route'] = $this->list_route;
        $data['add_permission'] = $this->add_permission;
        return view('WebPortal::important-links.create', $data);
    }

    /**
     * @param StoreimportantLinkRequest $request
     * @param ImportantLink $important_link
     * @return RedirectResponse
     */
    public function store(StoreimportantLinkRequest $request, ImportantLink $important_link): RedirectResponse
    {
        try {
            $this->saveOrUpdateImportantLink($important_link, $request);

            Session::flash('success', 'Data save successfully!');
            return redirect()->route('important-links.list');
        } catch (\Exception $e) {
            Log::error("Error occurred in ImportantLinkController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Important Link-102]");
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
            $data['data'] = ImportantLink::where('id', $decode_id)->first();
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Important Link';
            $data['list_route'] = $this->list_route;
            return view('WebPortal::important-links.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in ImportantLinkController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Important Link-103]");
            return redirect()->back();
        }
    }

    /**
     * @param StoreimportantLinkRequest $request
     * @return RedirectResponse
     */
    public function update(StoreimportantLinkRequest $request): RedirectResponse
    {
        try {
            $important_link_id = Encryption::decodeId($request->get('id'));
            $important_link = ImportantLink::findOrFail($important_link_id);
            $this->saveOrUpdateImportantLink($important_link, $request);

            Session::flash('success', 'Data Updated successfully!');
            return redirect()->route('important-links.list');
        } catch (Exception $e) {
            Log::error("Error occurred in ImportantLinkController@update ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data update [Important Link-104]");
            return Redirect::back()->withInput();
        }
    }

    /**
     * @param importantLink $important_link
     * @param
     * @return void
     */
    private function saveOrUpdateImportantLink(ImportantLink $important_link, $request): void
    {
        try {
            $important_link->title_en = $request->get('title_en');
            $important_link->title_bn = $request->get('title_bn');
            $important_link->important_link = $request->get('link');
            $important_link->status = $request->get('status');
            $important_link->save();
        } catch (\Exception $e) {
            Log::error("Error occurred in ImportantLinkController@saveOrUpdateImportantLink ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data saveOrUpdateImportantLink [Important Link-105]");
        }
    }
}
