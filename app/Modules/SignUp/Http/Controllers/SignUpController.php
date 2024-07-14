<?php

namespace App\Modules\SignUp\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\SignUp\Http\Requests\SignUpRequest;
use App\Modules\SignUp\Models\SignUp;
use App\Modules\SignUp\Models\UserFocalpoint;
use App\Modules\Users\Models\Organigation;
use App\Modules\Users\Models\OrganizationType;
use App\Modules\Users\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SignUpController extends Controller
{

    public function index(Request $request) : View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {

                $list = SignUp::with(['user', 'organization:id,organization_name_en', 'organizationType:id,organization_type'])
                ->select('id', 'phone_number', 'organization_id','organization_type', 'central_email', 'user_id', 'status', 'updated_at', 'updated_by')
                // ->where('status', '!=', 1)
                ->orderByDesc('id')
                ->get();
            

                return DataTables::of($list)
                    ->editColumn('image', function ($row) {
                        return "<img width='150px' class='img-thumbnail' src='" .asset($row->image). "' alt='" . htmlspecialchars($row->title_en) . "'>";
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('organization_id', function ($row) {
                        return $row->organization->organization_name_en;
                    })
                    ->editColumn('organization_type', function ($row) {
                        return $row->organizationType->organization_type;
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->editColumn('status', function ($row) {
                        $status =  '<span class="badge badge-danger">Inactive</span>';
                        if($row->status == 1){
                            $status = '<span class="badge badge-success">Active</span>';
                        }elseif($row->status == 2){
                            $status =  '<span class="badge badge-warning">Rejected</span>';
                        }
                        return $status;
                    })
                    ->addColumn('action', function ($row) {
                        $create_user_btn = '';
                        $reject_user_btn = '';
                        if ($row->status == 0) {
                            $create_user_btn = '<a href="' . route('signup.create_user', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Approve </a>';
                            $reject_user_btn = '<a href="' . route('signup.reject_user', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-danger btn-xs m-1"> Reject </a>';
                        }
                        $view_btn = '<a href="' . route('signup.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Open </a>';
                        return $view_btn . $create_user_btn . $reject_user_btn;
                    })
                    ->rawColumns(['phone_number', 'status', 'action'])
                    ->make(true);
            }

            return view('SignUp::list', [
                'add_permission' => true,
                'edit_permission' => true,
            ]);

        } catch (\Exception $e) {
            Log::error("Error occurred in SignUpController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [SignUp-101]");
            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())]);
        }
    }

    public function view($id): View
    {
        $decode_id = Encryption::decodeId($id);
        $data['user'] = SignUp::with(['organization:id,organization_name_en', 'organizationType:id,organization_type'])->findOrFail($decode_id);
        return view('SignUp::view', $data);
    }


    public function storeNewUser($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $signup = SignUp::findOrFail($decode_id);
            $token_no = hash('SHA256', "-" . $signup->central_email . "-");
            $encrypted_token = Encryption::encodeId($token_no);
            $user_hash_expire_time = new Carbon('+24 hours');

            if ($signup->organization_id) {
                $isApproverExist = Users::query()->where('organization_id', $signup->organization_id)->where('user_role_id', 2)->where('user_status', 1)->count();
                if ($isApproverExist) {
                    Session::flash('error', "Approver exists! please contact with system admin");
                    return redirect()->back();
                }
            }

            DB::beginTransaction();
            // Users
            $user = new Users();
            $user->user_email = $signup->central_email;
            $user->user_mobile = $signup->phone_number;
            $user->username = $signup->user_id;
            $user->organization_id = $signup->organization_id;
            $user->organization_type = $signup->organization_type;
            $user->user_status = 0;
            $user->is_email_verified = 0;
            $user->user_hash = $encrypted_token;
            $user->user_hash_expire_time = $user_hash_expire_time->toDateTimeString();
            $user->is_approved = 0; // 1 = auto approved
            $user->user_type = 3; // Office User
            $user->user_role_id = 2; // Approver
            $user->save();
            // UserFocalpoint
            $user_focalpoint = new UserFocalpoint();
            $user_focalpoint->user_id = $user->id;
            $user_focalpoint->organization_id = $signup->organization_id;
            $user_focalpoint->organization_type = $signup->organization_type;
            $user_focalpoint->fp_name = $signup->fp_name;
            $user_focalpoint->fp_designation = $signup->fp_designation;
            $user_focalpoint->fp_phone_number = $signup->fp_phone_number;
            $user_focalpoint->fp_email = $signup->fp_email;
            $user_focalpoint->dfp_name = $signup->dfp_name;
            $user_focalpoint->dfp_designation = $signup->dfp_designation;
            $user_focalpoint->dfp_phone_number = $signup->dfp_phone_number;
            $user_focalpoint->dfp_email = $signup->dfp_email;
            $user_focalpoint->save();
            // SignUp
            $signup->status = 1; // Approved
            $signup->save();
            // sendEmailSMS
            $receiverInfo[] = [
                'user_email' => $signup->central_email,
                'user_mobile' => $signup->phone_number,
            ];
            $appInfo = [
                'verification_link' => url('users/verify-created-user/' . ($encrypted_token)),
                'username' => $signup->user_id,
            ];
            CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);
            DB::commit();

            Session::flash('success', 'User has been created successfully! An email has been sent to the user for account activation.');
            return redirect('users/list');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Sorry! Something is Wrong.[SignUp-102]');
            Log::error("Error occurred in SignUpController@storeNewUser ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }

    public function signup(): View | RedirectResponse
    {
        if (!(Auth::check() && ((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3))) {
            return redirect("/");
        }
        $data['organizations'] = Organigation::query()->whereStatus(1)->pluck('organization_name_en', 'id');
        $data['organization_types'] = OrganizationType::query()->whereStatus(1)->pluck('organization_type', 'id');
        return view('SignUp::signup', $data);
    }

    public function storeSignup(SignUpRequest $request) : RedirectResponse
    {
        try {
            $signup = new SignUp();
            $signup->organization_id = $request->get('organization_name') ?? null;
            $signup->organization_type = $request->get('organization_type') ?? null;
            $signup->central_email = $request->get('central_email') ?? null;
            $signup->phone_number = $request->get('phone_number') ?? null;
            $signup->user_id = $request->get('user_id') ?? null;
            $signup->fp_name = $request->get('fp_name') ?? null;
            $signup->fp_designation = $request->get('fp_designation') ?? null;
            $signup->fp_phone_number = $request->get('fp_phone_number') ?? null;
            $signup->fp_email = $request->get('fp_email') ?? null;
            $signup->dfp_name = $request->get('dfp_name') ?? null;
            $signup->dfp_designation = $request->get('dfp_designation') ?? null;
            $signup->dfp_phone_number = $request->get('dfp_phone_number') ?? null;
            $signup->dfp_email = $request->get('dfp_email') ?? null;
            $signup->save();

            Session::flash('success', 'Successfully registered, after approval you will get an email with a password set link. Please wait or contact the support team.');
            return redirect()->route("signup");

        } catch (\Exception $e) {
            Session::flash('error', "Something went wrong during application data store [SignUp-103]");
            Log::error("Error occurred in SignUpController@storeSignup ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back()->withInput();
        }
    }

    

    public function rejectUser($id)
    {
        try {    
            $decode_id = Encryption::decodeId($id);
            $signup = SignUp::findOrFail($decode_id);
            $signup->status = 2; // Rejected
            $signup->save();
            Session::flash('success', 'User request has been rejected !');
            return Redirect::back();
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.[SignUp-104]');
            Log::error("Error occurred in SignUpController@rejectUser ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return Redirect::back();
        }
    }

    public function getOrganigationName(Request $request)
    {
        try {    
            $response = Organigation::query()->whereStatus(1)->where('organization_type', $request->condition_id)->pluck('organization_name_en', 'id')->toArray();
            $data = ['responseCode' => 1, 'data' => $response];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => CommonFunction::showErrorPublic($e->getMessage()) . ' [U5A-111]'
            ]);
        }
    }

    
    public function checkUserId(Request $request) 
    {
        try{
            $user_id = $request->get('user_id');
            $existingUser = SignUp::where('user_id', $user_id)->first();
            if ($existingUser) {
                $message = 'UserId Exists, Please try another userId!';
                return Response::json(['status' => 'failed', 'message' => $message]);
            }
            $message = 'UserId available!';
            return Response::json(['status' => 'success', 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => CommonFunction::showErrorPublic($e->getMessage()) . ' [U5A-111]'
            ]);
        }
    }
}

