<?php

namespace App\Modules\FAQ\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRequest;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Modules\FAQ\Models\FAQ;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class FAQController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;


    public function __construct()
    {
        $this->service_id = 19;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);

    }

    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = FAQ::with('user')->orderBy('id', 'desc')->get();
                return Datatables::of($list)
                    ->addColumn('SL', function () {
                        static $count = 1;
                        return $count++;
                    })
                    ->editColumn('title', function ($list) {
                        return Str::limit($list->title, 50);
                    })
                    ->editColumn('details', function ($list) {
                        return Str::limit($list->details, 80);
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
                    ->addColumn('action', function ($list) {
                        if ($this->edit_permission) {
                            return '<a href="' . url('/faq/edit/' . Encryption::encodeId($list->id)) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                        }
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
            return view('FAQ::list', ['add_permission' => $this->add_permission, 'edit_permission' => $this->edit_permission]);
        } catch (Exception $e) {
            Log::error("Error occurred in FAQController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [FAQ-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);

        }

    }

    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Create New FAQ';
            $data['add_permission'] = $this->add_permission;
            return view('FAQ::create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    public function store(FAQRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add or edit permission");
                return redirect()->route('faq.list');
            }
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $faq = FAQ::findOrFail($app_id);
            } else {
                $faq = new FAQ();
            }
            $faq->title = $request->get('title');
            $faq->details = $request->get('details');
            $faq->ordering = $request->get('ordering') ?? 0;
            $faq->status = $request->get('status');
            $faq->save();
            Session::flash('success', 'Data save successfully!');
            return redirect()->route("faq.list");

        } catch (Exception $e) {
            Log::error("Error occurred in FAQController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [FAQ-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);

        }
    }

    public function edit($id): View|RedirectResponse
    {
        $decode_id = Encryption::decodeId($id);
        $data = FAQ::where('id', $decode_id)->first();
        $edit_permission = $this->edit_permission;
        return view('FAQ::edit', compact('data', 'edit_permission'));
    }

    public function update(FAQRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            if ($this->edit_permission) {
                $id = Encryption::decodeId($request->id);
                $faq = FAQ::find($id);
                $faq->title = $request->get('title');
                $faq->details = $request->get('details');
                $faq->ordering = $request->get('ordering') ?? 0;
                $faq->status = $request->get('status');
                $faq->save();
                Session::flash('success', 'Data updated successfully!');
                return redirect('/faq/list');
            }
            Session::flash('error', "Don't have edit permission");
            return redirect('/faq/list');
        } catch (\Exception $e) {
            Session::flash('error', "Something went wrong during application data update [FAQ-102]");
            return Redirect::back()->withInput();
        }
    }


}
