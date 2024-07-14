<?php

namespace App\Modules\WebPortal\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Predis\Command\Redis\SUBSTR;
use Yajra\DataTables\DataTables;
use App\Modules\WebPortal\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;

class CommentController extends Controller
{
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

    public function index(Request $request) : View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {

                $list = Comment::with('user')
                    ->select('id', 'name', 'email', 'number','details', 'created_at','updated_at', 'updated_by')
                    ->orderByDesc('id')
                    ->get();

                return Datatables::of($list)

                    ->editColumn('name', function ($row) {
                        return $row->name;
                    })
                    ->editColumn('email', function ($row) {
                        return $row->email;
                    })
                    ->editColumn('number', function ($row) {
                        return $row->email;
                    })
                    ->editColumn('details', function ($row) {
                        return strlen($row->details) < 80 ? substr($row->details, 0,80) : substr($row->details, 0,80).'...' ;
                    })
                    ->editColumn('datetime', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->created_at);
                    })
                    ->rawColumns([])
                    ->make(true);
            }

            return view('WebPortal::comments.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);

        } catch (Exception $e) {
            Log::error("Error occurred in BannerController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Banner-101]");
            Return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }


}
