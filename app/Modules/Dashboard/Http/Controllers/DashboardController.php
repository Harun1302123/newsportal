<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Communication\Models\Communication;
use App\Modules\WebPortal\Models\Notice;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    /**
     * @return View|RedirectResponse
     */
    public function dashboard(): View|RedirectResponse
    {
        if (Auth::user()->user_type == '3') {
            $query = Communication::query()
                ->where(function ($query){
                    $query->where('start_date','>=',date('Y-m-d'))
                        ->orWhere('end_date','>=',date('Y-m-d'));
                })
                ->where('status',1)
                ->where(function ($query){
                    $query->where('communication_type','individual')
                        ->whereJsonContains('user_ids',strval(Auth::user()->id))
                        ->orWhere(function ($query){
                            $query->where('communication_type','organization')
                                ->where('organization_type', strval(Auth::user()->organization_type))
                                ->whereJsonContains('organization_ids', strval(Auth::user()->organization_id))
                                ->orWhereJsonContains('organization_ids', '0')
                                ->orWhere('organization_type','0');
                        });
                });
            $data['communications'] = $query->get();
            $data['schedule_data'] = $query->take(4)->get();

        } else {
            $query = Communication::where('status', 1);
            $data['communications'] = $query->get();
            $data['schedule_data'] = Communication::where('status', 1)
                ->where('start_date','>=',date('Y-m-d'))
                ->orWhere('end_date','>=',date('Y-m-d'))
                ->take(4)->get();
        }
        if (auth()->check()) {
            return view('Dashboard::index', $data);
        }
        return redirect()->route('login')->with('error', 'Oops! You do not have access');
    }


    public function noticeData(Request $request):  \Illuminate\View\View|JsonResponse
    {

        try{
            if ($request->ajax() && $request->isMethod('post')) {

                $list = Notice::with('user')
                    ->select('id', 'title', 'attachment', 'publish_at', 'achieve_at', 'status', 'updated_at', 'updated_by')
                    ->where('status', 1)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();

                return Datatables::of($list)
                    ->editColumn('title', function ($row) {
                        return $row->title;
                    })
                    ->editColumn('attachment', function ($row) {
                        return '<a href="' . asset($row->attachment) . '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="far fa-file-pdf"></i> PDF</a><br>';
                    })
                    ->editColumn('publish_at', function ($row) {
                        return CommonFunction::formatdate($row->publish_at);
                    })
                    ->editColumn('achieve_at', function ($row) {
                        return CommonFunction::formatdate($row->achieve_at);
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
                        return '<a href="' . route('notices.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-eye"></i> Open</a><br>';
                    })
                    ->rawColumns(['attachment', 'status', 'action'])
                    ->make(true);
            }
            return view('WebPortal::notice.list');

        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Notice-104]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], 502);
        }
    }


    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['data'] = Notice::findOrFail($decode_id);
            return view('WebPortal::notice.view', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Notice-105]");
            return redirect()->back();
        }
    }
}
