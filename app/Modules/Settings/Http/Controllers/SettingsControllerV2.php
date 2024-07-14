<?php

namespace App\Modules\Settings\Http\Controllers;
//ob#code@start - (galib) remove unused elements
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Models\Services;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Apps\Models\IndustryCategories;
use App\Modules\CompanyAssociation\Models\CompanyAssociationMaster;
use App\Modules\CompanyProfile\Models\CompanyInfo;
use App\Modules\ProcessPath\Models\ProcessHistory;
use App\Modules\ProcessPath\Models\ProcessStatus;
use App\Modules\ProcessPath\Models\UserDesk;
use App\Modules\Settings\Models\Area;
use App\Modules\Settings\Models\Bank;
use App\Modules\Settings\Models\BankBranch;
use App\Modules\Settings\Models\Currencies;
use App\Modules\Settings\Models\EmailQueue;
use App\Modules\Settings\Models\HighComissions;
use App\Modules\Settings\Models\HomeContent;
use App\Modules\Settings\Models\HomePageSlider;
use App\Modules\Settings\Models\HsCodes;
use App\Modules\Settings\Models\Logo;
use App\Modules\Settings\Models\NeedHelp;
use App\Modules\Settings\Models\Notice;
use App\Modules\Settings\Models\Ports;
use App\Modules\Settings\Models\SecurityProfile;
use App\Modules\Settings\Models\ServiceDetails;
use App\Modules\Settings\Models\Units;
use App\Modules\Settings\Models\UserManual;
use App\Modules\Settings\Models\WhatsNew;
use App\Modules\Users\Models\EconomicZones;
use App\Modules\Users\Models\ParkInfo;
use App\Modules\Users\Models\UserTypes;
use App\Modules\Web\Models\HomePageArticle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Session;

//ob#code@end - (galib)
class SettingsControllerV2 extends Controller
{
    public function index()
    {
        return view("Settings::index");
    }

    public function NoticeList(Request $request)
    {
        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = Notice::orderBy('id');
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('heading', 'like', '%' . $search_input . '%')
                    ->orWhere('details', 'like', '%' . $search_input . '%')
                    ->orWhere('importance', 'like', '%' . $search_input . '%')
                    ->orWhere('status', 'like', '%' . $search_input . '%');
            });
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($notice, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($notice->id), 'heading' => $notice->heading, 'details' => $notice->details,
                'importance' => $notice->importance, 'status' => $notice->status,
            ];
        });

        return response()->json($data);
    }

    public function storeNotice(Request $request)
    {
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $messages = [
            'heading.required' => 'Heading (Bangla) field is required',
            'heading_en.required' => 'Heading (English) field is required',
            'details.required' => 'Details (Bangla) field is required',
            'details_en.required' => 'Details (English) field is required',
        ];

        $rules = [
            'heading' => 'required',
            'heading_en' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'details' => 'required',
            'details_en' => 'required',
            'importance' => 'required',
            'ordering_prefix' => 'required',
            'status' => 'required',
        ];

        $this->validate($request, $rules, $messages);
        try {
            $notice_photo = $request->file('photo');
            $notice_photo_path = '';
            $path = 'uploads/Notice/';
            if ($request->hasFile('photo')) {
                $file_name = 'notice_image_' . md5(uniqid()) . '.' . $notice_photo->getClientOriginalExtension();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $notice_photo->move($path, $file_name);
                $notice_photo_path = $path . $file_name;
            }

            $notice_document = $request->file('notice_document');
            $notice_document_path = '';
            if ($request->hasFile('notice_document')) {
                $file_name = 'notice_doc_' . md5(uniqid()) . '.' . $notice_document->getClientOriginalExtension();
                $file_size =  number_format($notice_document->getSize() / 1048576, 2);
                if ($file_size > 2) {
                    return response()->json(['status' => false, 'messages' => "The Document size should be maximum 2MB"]);
                }

                $mime_type = $notice_document->getClientMimeType();

                if ($mime_type == 'application/pdf' || $mime_type == 'application/octet-stream') {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $notice_document->move($path, $file_name);
                    $notice_document_path = $path . $file_name;
                } else {
                    return response()->json(['status' => false, 'messages' => "The Document must be pdf type"]);
                }
            }

            Notice::create(
                array(
                    'heading' => $request->get('heading'),
                    'heading_en' => $request->get('heading_en'),
                    'photo' => $notice_photo_path,
                    'notice_document' => $notice_document_path,
                    'details' => $request->get('details'),
                    'details_en' => $request->get('details_en'),
                    'status' => $request->get('status'),
                    'importance' => $request->get('importance'),
                    'ordering_prefix' => $request->get('ordering_prefix'),
                    'created_by' => CommonFunction::getUserId()
                )
            );
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function editNotice($notice_id)
    {
        $notice_id = Encryption::decodeId($notice_id);
        return Notice::where('id', $notice_id)->first();
    }

    public function updateNotice($id, Request $request)
    {
        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $notice_id = Encryption::decodeId($id);

        $messages = [
            'heading.required' => 'Heading (Bangla) field is required',
            'heading_en.required' => 'Heading (English) field is required',
            'details.required' => 'Details (Bangla) field is required',
            'details_en.required' => 'Details (English) field is required',
        ];

        $rules = [
            'heading' => 'required',
            'heading_en' => 'required',
            'details' => 'required',
            'details_en' => 'required',
            'importance' => 'required',
            'ordering_prefix' => 'required',
            'status' => 'required',
        ];
        if ($request->hasFile('photo')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024';
        }
        $this->validate($request, $rules, $messages);

        try {
            $notice_photo = $request->file('photo');
            $notice_photo_path = '';
            $path = 'uploads/Notice/';
            if ($request->hasFile('photo')) {
                $file_name = 'notice_image_' . md5(uniqid()) . '.' . $notice_photo->getClientOriginalExtension();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $notice_photo->move($path, $file_name);
                $notice_photo_path = $path . $file_name;
            }

            $notice_document = $request->file('notice_document');
            $notice_document_path = '';
            if ($request->hasFile('notice_document')) {
                $file_name = 'notice_doc_' . md5(uniqid()) . '.' . $notice_document->getClientOriginalExtension();
                $file_size =  number_format($notice_document->getSize() / 1048576, 2);
                if ($file_size > 2) {
                    return response()->json(['status' => false, 'messages' => "The Document size should be maximum 2MB"]);
                }

                $mime_type = $notice_document->getClientMimeType();

                if ($mime_type == 'application/pdf' || $mime_type == 'application/octet-stream') {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $notice_document->move($path, $file_name);
                    $notice_document_path = $path . $file_name;
                } else {
                    return response()->json(['status' => false, 'messages' => "The Document must be pdf type"]);
                }
            }

            $notice = Notice::find($notice_id);
            $notice->heading = $request->get('heading');
            $notice->heading_en = $request->get('heading_en');
            if (!empty($notice_photo_path)) {
                $notice->photo = $notice_photo_path;
            }
            if (!empty($notice_document_path)) {
                $notice->notice_document = $notice_document_path;
            }
            $notice->details = $request->get('details');
            $notice->details_en = $request->get('details_en');
            $notice->importance = $request->get('importance');
            $notice->ordering_prefix = $request->get('ordering_prefix');
            $notice->status = $request->get('status');
            $notice->save();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            dd($request->all());
            return response()->json(['status' => false]);
        }
    }

    public function serviceName(Request $request)
    {
        $services = Services::orderby('name')->get();
        return response()->json($services);
    }

    public function storeArea(Request $request)
    {
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $this->validate($request, [
            'area_nm' => 'required',
            'area_nm_ban' => 'required',
        ]);
        try {
            $area_type = $request->get('area_type');
            if ($area_type == 1) { //for division
                $parent_id = 0;
            } elseif ($area_type == 2) { // for district
                $parent_id = $request->get('division');
            } elseif ($area_type == 3) { //for thana
                $parent_id = $request->get('district');
            }
            Area::create([
                'area_type' => $area_type,
                'pare_id' => $parent_id,
                'area_nm' => $request->get('area_nm'),
                'area_nm_ban' => $request->get('area_nm_ban'),
            ]);

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function AreaList(Request $request)
    {

        if (!ACL::getAccessRight('settings', 'V'))
            die('You have no access right! Please contact system administration for more information.');

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $order = $request->get('order');
        $column_name = $request->get('column_name');
        $query = Area::select('area_info.*');

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('area_nm', 'like', '%' . $search_input . '%')
                    ->orWhere('area_nm_ban', 'like', '%' . $search_input . '%')
                    ->orWhere('area_type', 'like', '%' . $search_input . '%');
            });
        }
        if ($column_name) {
            $query->orderBy($column_name, $order);
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($area, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($area->area_id), 'area_nm' => $area->area_nm, 'area_nm_ban' => $area->area_nm_ban,
                'area_type' => $area->area_type,
            ];
        });

        return response()->json($data);
    }

    public function divisionName(Request $request)
    {
        $divisions = Area::orderBy('area_nm')->where('area_type', 1)->get();

        return response()->json($divisions);
    }

    public function districtName(Request $request)
    {
        $divisionId = $request->get('division');

        $districts = Area::orderBy('area_nm')->where('pare_id', $divisionId)->get();
        return response()->json($districts);
    }

    public function editArea($id)
    {

        $area_id = Encryption::decodeId($id);
        $data = Area::leftJoin('area_info as ai', 'area_info.pare_id', '=', 'ai.area_id')
            ->where('area_info.area_id', $area_id)
            ->first(['area_info.*', 'ai.pare_id as division_id']);
        return $data;
    }

    public function updateArea($id, Request $request)
    {

        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $area_id = Encryption::decodeId($id);
        $this->validate($request, [
            'area_nm' => 'required',
            'area_nm_ban' => 'required',
        ]);
        try {
            $area_type = $request->get('area_type');
            if ($area_type == 1) { //for division
                $parent_id = 0;
            } elseif ($area_type == 2) { // for district
                $parent_id = $request->get('division');
            } elseif ($area_type == 3) { //for thana
                $parent_id = $request->get('district');
            }

            Area::where('area_id', $area_id)->update([
                'area_type' => $area_type,
                'pare_id' => $parent_id,
                'area_nm' => $request->get('area_nm'),
                'area_nm_ban' => $request->get('area_nm_ban'),
            ]);
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function get_thana_by_district_id(Request $request)
    {
        $district_id = $request->get('districtId');
        $thanas = Area::where('PARE_ID', $district_id)->orderBy('AREA_NM', 'ASC')->pluck('AREA_NM', 'AREA_ID')->toArray();
        $data = ['responseCode' => 1, 'data' => $thanas];
        return response()->json($data);
    }

    /**************** Start of UserType functions *********/
    public function userTypeList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $user_types = UserTypes::leftJoin('security_profile', 'security_profile.id', '=', 'user_types.security_profile_id')
            ->select('user_types.id', 'user_types.id as type_id', 'type_name', 'security_profile_id', 'profile_name', 'week_off_days', 'user_types.status');
        if ($search_input) {
            $user_types->where(function ($user_types) use ($search_input) {
                $user_types->where('type_name', 'like', '%' . $search_input . '%');
            });
        }
        $data = $user_types->paginate($limit);
        $data->getCollection()->transform(function ($usertype, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encode($usertype->type_id), 'type_name' => $usertype->type_name,
                'type_id' => $usertype->type_id,
                'profile_name' => $usertype->profile_name, 'week_off_days' => $usertype->week_off_days, 'status' => $usertype->status,
            ];
        });
        return response()->json($data);
    }


    public function editUserType($id)
    {
        $id = Encryption::decode($id);
        //        dd($id);
        $data = UserTypes::where('id', $id)->first();
        return response()->json($data);
    }
    public function getSecurityList()
    {
        $data = SecurityProfile::where('active_status', 'yes')->get();
        return response()->json($data);
    }

    public function updateUserType(Request $request, $id)
    {
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $this->validate($request, [
            'type_name' => 'required',
            'security_profile_id' => 'required',
            'auth_token_type' => 'required',
            'status' => 'required',
        ]);
        //        CommonFunction::createAuditLog('userType.edit', $request);
        $id = Encryption::decode($id);
        //        dd($id);
        try {
            $update_data = array(
                'type_name' => $request->get('type_name'),
                'security_profile_id' => $request->get('security_profile_id'),
                'auth_token_type' => $request->get('auth_token_type'),
                'db_access_data' => Encryption::encode($request->get('db_access_data')),
                'status' => $request->get('status')
            );
            UserTypes::where('id', $id)
                ->update($update_data);

            if ($request->get('status') == 'inactive') {
                $user_ids = UsersModel::where('user_type', $id)->get(['id']);
                foreach ($user_ids as $user_id) {
                    LoginController::killUserSession($user_id);
                }
            }
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    /**************** End of UserType functions *********/


    /**************** Start of Home page slider related functions *********/
    public function HomePageSliderList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = HomePageSlider::orderBy('id', 'desc');
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('slider_url', 'like', '%' . $search_input . '%');
            });
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($silder, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($silder->id), 'slider_image' => $silder->slider_image,
                'slider_title' => $silder->slider_title, 'status' => $silder->status,
            ];
        });

        return response()->json($data);
    }

    public function homePageSliderStore(Request $request)
    {
        //        dd($request->all());
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $this->validate($request, [
            'status' => 'required'
        ]);
        try {

            $image = $request->file('slider_image');
            //            dd($image);
            $path = "uploads/sliderImage";
            if ($request->hasFile('slider_image')) {
                $img_file = $image->getClientOriginalName();
                $mime_type = $image->getClientMimeType();
                if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                    $image->move($path, $img_file);
                    $filepath = $path . '/' . $img_file;
                } else {
                    return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
                }
            }
            //ob#code@start - (galib) remove variable $insert
            $insert = HomePageSlider::create(
            //ob#code@end - (galib)
                array(
                    'slider_title' => $request->get('slider_title'),
                    'slider_url' => $request->get('slider_url'),
                    'slider_type' => $request->get('slider_type'),
                    'status' => $request->get('status'),
                    'slider_image' => $filepath,
                    'created_by' => CommonFunction::getUserId()
                )
            );

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false , 'messages'=>$e->getMessage() ]);
        }
    }

    public function editHomePageSlider($encrypted_id)
    {
        $id = Encryption::decodeId($encrypted_id);
        $data = HomePageSlider::where('id', $id)->first();
        //        $page_header = 'Slider';
        return $data;
    }

    public function updateHomePageSlider(Request $request)
    {
        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $id = Encryption::decodeId($request->id);

        $this->validate($request, [
            'status' => 'required'
        ]);
        try {
            $slider = HomePageSlider::Where('id', $id)->first();
            $image = $request->file('slider_image');
            $path = "uploads/sliderImage";

            if ($request->hasFile('slider_image') && !empty($request->slider_image)) {
                $img_file = $image->getClientOriginalName();
                $mime_type = $image->getClientMimeType();
                if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                    $image->move($path, $img_file);
                    $filepath = $path . '/' . $img_file;
                    $slider->slider_image = $filepath;
                } else {
                    return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
                }
            }

            $slider->slider_title = $request->get('slider_title');
            $slider->slider_url = $request->get('slider_url');
            $slider->status = $request->get('status');
            $slider->created_by = CommonFunction::getUserId();
            $slider->save();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }
    /**************** Ending of Home page slider related functions *********/

    /**************** Start of User Manual related functions *********/

    public function UserManualList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = UserManual::orderBy('typeName', 'desc');
        //        dd($query);
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('typeName', 'like', '%' . $search_input . '%')
                    ->orWhere('termsCondition', 'like', '%' . $search_input . '%');
            });
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($usermanual, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($usermanual->id), 'typeName' => $usermanual->typeName,
                'details' => strip_tags($usermanual->details), 'termsCondition' => $usermanual->termsCondition, 'status' => $usermanual->status,
            ];
        });

        return response()->json($data);
    }

    public function UsermanualStore(Request $request)
    {
        // return $request->all();
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $this->validate($request, [
            'typeName' => 'required',
            'details' => 'required',
            'termsCondition' => 'required',
            'status' => 'required'
        ]);
        try {
            $pdfFile = $request->file('pdfFile');
            $path = "uploads/userManual/";
            if ($request->hasFile('pdfFile')) {
                $pdf_file = $pdfFile->getClientOriginalName();
                $mime_type = $pdfFile->getClientMimeType();
                if ($mime_type == 'application/pdf' || $mime_type == 'application/octet-stream') {
                    $pdfFile->move($path, $pdf_file);
                    $filepath = $path . $pdf_file;
                } else {
                    return response()->json(['status' => false, 'messages' => "File must be pdf format"]);
                }
            }
            UserManual::create(
                array(
                    'typeName' => $request->get('typeName'),
                    'details' => $request->get('details'),
                    'termsCondition' => $request->get('termsCondition'),
                    'status' => $request->get('status'),
                    'pdfFile' => $filepath,
                    'created_by' => CommonFunction::getUserId()
                )
            );

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function editUsermanual($encrypted_id)
    {
        $id = Encryption::decodeId($encrypted_id);
        $data = UserManual::where('id', $id)->first();
        //        $pdf = explode("/", $data->pdfFile);
        //        $filepdf = $pdf[2];
        return $data;
    }

    public function updateUsermanual(Request $request)
    {

        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $id = Encryption::decodeId($request->id);

        $this->validate($request, [
            'typeName' => 'required',
            'details' => 'required',
            'termsCondition' => 'required',
            'status' => 'required'
        ]);
        try {
            $manual = UserManual::Where('id', $id)->first();
            $pdfFile = $request->file('pdfFile');
            $path = "uploads/userManual/";

            if ($request->hasFile('pdfFile')) {
                $pdf_file = $pdfFile->getClientOriginalName();
                $mime_type = $pdfFile->getClientMimeType();
                if ($mime_type == 'application/pdf' || $mime_type == 'application/octet-stream') {
                    $pdfFile->move($path, $pdf_file);
                    $filepath = $path . $pdf_file;
                    $manual->pdfFile = $filepath;
                } else {
                    return response()->json(['status' => false, 'messages' => "File must be pdf format"]);
                }
            }

            $manual->typeName = $request->get('typeName');
            $manual->details = $request->get('details');
            $manual->termsCondition = $request->get('termsCondition');
            $manual->status = $request->get('status');
            $manual->created_by = CommonFunction::getUserId();
            $manual->save();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }
    /**************** Ending of User Manual related functions *********/

    /**************** Start of Home Page Articles related functions *********/

    public function homeArticlesList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = HomePageArticle::orderBy('page_name', 'desc');
        //        dd($query);
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('page_name', 'like', '%' . $search_input . '%');
            });
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($homepagearticles, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($homepagearticles->id), 'page_name' => $homepagearticles->page_name,
                'page_content' => strip_tags($homepagearticles->page_content), 'page_content_en' => strip_tags($homepagearticles->page_content_en)
            ];
        });

        return response()->json($data);
    }

    public function homeArticlesStore(Request $request)
    {
        //         return $request->all();
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $this->validate($request, [
            'page_content_en' => 'required',
            'page_content' => 'required',
            'page_name' => 'required'
        ]);
        try {
            HomePageArticle::create(
                array(
                    'page_content_en' => $request->get('page_content_en'),
                    'page_content' => $request->get('page_content'),
                    'page_name' => $request->get('page_name'),
                    'created_by' => CommonFunction::getUserId()
                )
            );

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function edithomeArticles($encrypted_id)
    {
        $id = Encryption::decodeId($encrypted_id);
        $data = HomePageArticle::where('id', $id)->first();
        //        $pdf = explode("/", $data->pdfFile);
        //        $filepdf = $pdf[2];
        return $data;
    }

    public function updatehomeArticles(Request $request)
    {

        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $id = Encryption::decodeId($request->id);

        $this->validate($request, [
            'page_content' => 'required',
            'page_content_en' => 'required',
            'page_name' => 'required'
        ]);
        try {
            $homearticles = HomePageArticle::Where('id', $id)->first();



            $homearticles->page_name = $request->get('page_name');
            $homearticles->page_content = $request->get('page_content');
            $homearticles->page_content_en = $request->get('page_content_en');
            $homearticles->created_by = CommonFunction::getUserId();
            $homearticles->save();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }
    /**************** Ending of Home Page Articles related functions *********/

    /**************** Start of Home page content related functions *********/
    public function homeContentList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = HomeContent::orderBy('id', 'desc');
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('title', 'like', '%' . $search_input . '%')
                    ->orWhere('heading', 'like', '%' . $search_input . '%')
                    ->orWhere('type', 'like', '%' . $search_input . '%');
            });
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($homecontent, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($homecontent->id), 'title' => $homecontent->title, 'heading' => $homecontent->heading, 'type' => $homecontent->type, 'status' => $homecontent->status,
            ];
        });

        return response()->json($data);
    }
    public function homeContentStore(Request $request)
    {
        if (!ACL::getAccessRight('settings', 'A')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'title_en' => 'required',
            'heading_en' => 'required',
            'heading' => 'required',
            'details' => 'required',
            'details_en' => 'required',
            'details_url' => 'required',
            'order' => 'required',
            'status' => 'required'
        ]);
        try {
            $image = $request->file('image');
            $path = "uploads/homeContent";
            //ob#code@start - (galib) can be common
            if ($request->hasFile('image')) {
                $img_file = $image->getClientOriginalName();
                $mime_type = $image->getClientMimeType();
                if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $image->move($path, $img_file);
                    $filepath = $path . '/' . $img_file;
                } else {
                    return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
                }
            }
            $icon = $request->file('icon');
            if ($request->hasFile('icon')) {
                $img_file = $icon->getClientOriginalName();
                $mime_type = $icon->getClientMimeType();
                if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $icon->move($path, $img_file);
                    $iconfilepath = $path . '/' . $img_file;
                } else {
                    return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
                }
            }
//ob#code@end - (galib)
            //ob#code@start - (galib) $insert variable not needed
            $insert = HomeContent::create(
            //ob#code@end - (galib)
                array(
                    'type' => $request->get('type'),
                    'title' => $request->get('title'),
                    'title_en' => $request->get('title_en'),
                    'heading_en' => $request->get('heading_en'),
                    'heading' => $request->get('heading'),
                    'details_en' => $request->get('details_en'),
                    'details' => $request->get('details'),
                    'details_url' => $request->get('details_url'),
                    'order' => $request->get('order'),
                    'status' => $request->get('status'),
                    'image' => $filepath,
                    'icon' => $iconfilepath,
                    'created_by' => CommonFunction::getUserId()
                )
            );
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }
    public function edithomeContent($encrypted_id)
    {
        $id = Encryption::decodeId($encrypted_id);
        $data = HomeContent::where('id', $id)->first();
        //ob#code@start - (galib) unused
        $page_header = 'Home page Content';
        //ob#code@end - (galib)
        return $data;
    }
    public function updatehomeContent(Request $request)
    {

        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }
        $id = Encryption::decodeId($request->id);
        //        dd($id);

        $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'title_en' => 'required',
            'heading_en' => 'required',
            'heading' => 'required',
            'details' => 'required',
            'details_en' => 'required',
            'details_url' => 'required',
            'order' => 'required',
            'status' => 'required'
        ]);
        $homecontent = HomeContent::Where('id', $id)->first();
        $image = $request->file('image');
        $path = "uploads/homeContent";
//ob#code@start - (galib) should be common and be in try catch
        if ($request->hasFile('image') && !empty($request->image)) {
            $img_file = $image->getClientOriginalName();
            $mime_type = $image->getClientMimeType();
            if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $image->move($path, $img_file);
                $filepath = $path . '/' . $img_file;
                $homecontent->image = $filepath;
            } else {
                return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
            }
        }
        $icon = $request->file('icon');
        $path = "uploads/homeContent";

        if ($request->hasFile('icon') && !empty($request->icon)) {
            $img_file = $icon->getClientOriginalName();
            $mime_type = $icon->getClientMimeType();
            if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $icon->move($path, $img_file);
                $filepath = $path . '/' . $img_file;
                $homecontent->icon = $filepath;
            } else {
                return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
            }
        }
        //ob#code@end - (galib)
        try {
            $homecontent->type = $request->get('type');
            $homecontent->title = $request->get('title');
            $homecontent->title_en = $request->get('title_en');
            $homecontent->heading_en = $request->get('heading_en');
            $homecontent->heading = $request->get('heading');
            $homecontent->details_en = $request->get('details_en');
            $homecontent->details = $request->get('details');
            $homecontent->details_url = $request->get('details_url');
            $homecontent->order = $request->get('order');
            $homecontent->status = $request->get('status');
            $homecontent->created_by = CommonFunction::getUserId();
            $homecontent->save();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }
    /**************** Ending of Home page content related functions *********/

    /**************** Start of Logo related functions *********/

    public function storeLogo(request $request)
    {
        $logo = logo::Where('id', 1)->first();
        $company_logo = $request->file('company_logo');
        $path = "uploads/logo/";
        if ($request->hasFile('company_logo')) {
            $img_file = $company_logo->getClientOriginalName();
            $mime_type = $company_logo->getClientMimeType();
            if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png' || $mime_type == 'image/webp') {
                $company_logo->move($path, $img_file);
                $filepath = $path . $img_file;
                $logo->logo = $filepath;
            } else {
                return response()->json(['status' => false, 'messages' => "Image must be png or jpg or jpeg format"]);
            }
        }
        try {
            $logo->title = $request->get('title');
            $logo->manage_by = $request->get('manage_by');
            $logo->help_link = $request->get('help_link');
            $logo->created_by = CommonFunction::getUserId();
            $logo->save();

            Artisan::call('cache:clear');
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    public function editLogo()
    {
        //        dd(123);
        $data = Logo::where('id', 1)->first();
        return $data;
    }
    /**************** Ending of Logo related functions *********/

    /**************** Start of Email sms queue functions *********/
    public function emailSmsQueueList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = EmailQueue::leftJoin('process_list', function ($join) {
            $join->on('email_queue.services_id', '=', 'process_list.services_id')
                ->on('email_queue.app_id', '=', 'process_list.ref_id');
        })
            ->orderBy('id', 'desc')
            ->select(
                'email_queue.id',
                'email_queue.caption',
                'email_queue.email_to',
                'email_queue.email_status',
                'email_queue.sms_to',
                'email_queue.sms_status',
                'process_list.tracking_no'
            );

        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('caption', 'like', '%' . $search_input . '%')
                    ->orWhere('email_status', 'like', '%' . $search_input . '%')
                    ->orWhere('sms_status', 'like', '%' . $search_input . '%')
                    ->orWhere('tracking_no', 'like', '%' . $search_input . '%');
            });
        }
//        dd(474);
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($emailsms, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($emailsms->id),
                'tracking_no' => $emailsms->tracking_no,
                'email_to' => $emailsms->email_to,
                'email_status' => $emailsms->email_status,
                'sms_status' => $emailsms->sms_status,
                'sms_to' => $emailsms->sms_to,
                'caption' => $emailsms->caption,


            ];
        });

        return response()->json($data);
    }

    public function editEmailSmsQueue($id)
    {
        $decodedId = Encryption::decodeId($id);
        return EmailQueue::leftJoin('process_list', function ($join) {
            $join->on('email_queue.services_id', '=', 'process_list.services_id')
                ->on('email_queue.app_id', '=', 'process_list.ref_id');
        })
            ->where('email_queue.id', $decodedId)
            ->orderBy('id', 'desc')
            ->first([
                'process_list.tracking_no',
                'email_queue.*',
            ]);
    }

    public function updateEmailSmsQueue($id, Request $request)
    {
        if (!ACL::getAccessRight('settings', 'E')) {
            die('You have no access right! Please contact system administration for more information.');
        }

        try {
            $decodedId = Encryption::decodeId($id);

            $this->validate($request, [
                'sms_to' => 'required',
                'sms_content' => 'required',
                'sms_status' => 'required',
                'email_to' => 'required',
                'email_cc' => 'required',
                'email_subject' => 'required',
                'email_content' => 'required',
                'email_status' => 'required'
            ]);

            $email_sms_record = EmailQueue::find($decodedId);
            $email_sms_record->sms_to = $request->get('sms_to');
            $email_sms_record->sms_content = $request->get('sms_content');
            $email_sms_record->sms_status = $request->get('sms_status');
            if ($request->get('sms_status') == 0) {
                $email_sms_record->sms_no_of_try = 0;
            }
            $email_sms_record->email_to = $request->get('email_to');
            $email_sms_record->email_cc = $request->get('email_cc');
            $email_sms_record->email_subject = $request->get('email_subject');
            $email_sms_record->email_content = $request->get('email_content');
            $email_sms_record->email_status = $request->get('email_status');
            if ($request->get('email_status') == 0) {
                $email_sms_record->email_no_of_try = 0;
            }
            $email_sms_record->save();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messages'=>$e->getMessage()]);
        }
    }

    public function resendEmailSmsQueue($id, $type)
    {
        $decodedId = Encryption::decodeId($id);
        $decodedType = $type;

        try {
            $emailSmsInfo = EmailQueue::find($decodedId);

            if (empty($emailSmsInfo)) {
                Session::flash('error', 'Information is not found![REQ-001]');
                return Redirect::back();
            }

            if ($decodedType == 'email') {
                $emailSmsInfo->email_status = 0;
                $emailSmsInfo->email_no_of_try = 0;
            } elseif ($decodedType == 'sms') {
                $emailSmsInfo->sms_status = 0;
                $emailSmsInfo->sms_no_of_try = 0;
            } elseif ($decodedType == 'both') {
                $emailSmsInfo->email_status = 0;
                $emailSmsInfo->sms_status = 0;
                $emailSmsInfo->email_no_of_try = 0;
                $emailSmsInfo->sms_no_of_try = 0;
            } else {
                Session::flash('error', 'Invalid format![REQ-001]');
                return Redirect::back();
            }

            $emailSmsInfo->save();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messages'=>$e->getMessage()]);
        }
    }

    /**************** Start of Security functions *********/
    public function SecurityList(Request $request)
    {

        $search_input = $request->get('search');
        $limit = $request->get('limit');
        $query = SecurityProfile::orderBy('id');
        //        dd($query);
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('profile_name', 'like', '%' . $search_input . '%')
                    ->orWhere('week_off_days', 'like', '%' . $search_input . '%');
            });
        }
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($security, $key) {
            return [
                'si' => $key + 1, 'id' => Encryption::encodeId($security->id),
                'profile_name' => $security->profile_name,
                'allowed_remote_ip' => $security->allowed_remote_ip,
                'week_off_days' => $security->week_off_days,
                'work_hour_start' => $security->work_hour_start,
                'work_hour_end' => $security->work_hour_end,
                'active_status' => $security->active_status,

            ];
        });

        return response()->json($data);
    }

    public function storeSecurity(Request $request)
    {

        $this->validate($request, [
            'profile_name' => 'required',
//            'allowed_remote_ip' => 'required',
            'week_off_days' => 'required',
            'work_hour_start' => 'required',
            'work_hour_end' => 'required',
            'alert_message' => 'required',
//            'active_status' => 'required'
        ]);

        $work_hour_start = date('H:i:s', strtotime($request->get('work_hour_start')));
        $work_hour_end = date('H:i:s', strtotime($request->get('work_hour_end')));

        try {
            $allowed_remote_ip = $request->get('allowed_remote_ip');
            if($allowed_remote_ip == 'null'  || $allowed_remote_ip == null || $allowed_remote_ip == ''){
                $allowed_remote_ip = '';
            }

            SecurityProfile::create(
                array(
                    'profile_name' => $request->get('profile_name'),
                    //                'sp_key' => $request->get('sp_key'),
                    ////                    'user_type' => $request->get('user_type'),
                    'user_email' => $request->get('user_email'),
                    'allowed_remote_ip' => $allowed_remote_ip,
                    'week_off_days' => implode(',', $request->get('week_off_days')),
                    'work_hour_start' => $work_hour_start,
                    'work_hour_end' => $work_hour_end,
                    'active_status' => $request->get('active_status'),
                    'alert_message' => $request->get('alert_message')
                )
            );

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['status' => false]);
        }
    }

    public function editSecurity($id)
    {
        $id = Encryption::decodeId($id);
        $data = SecurityProfile::where('id', $id)->first();
        //        $user_types = UserTypes::pluck('type_name', 'id')->toArray();
        return $data;
    }

    public function updateSecurity($id, Request $request)
    {
        $_id = Encryption::decodeId($id);

        $this->validate($request, [
            'profile_name' => 'required',
            'week_off_days' => 'required',
            'work_hour_start' => 'required',
            'work_hour_end' => 'required',
            'active_status' => 'required',
            'alert_message' => 'required'
        ]);
        try {
            $allowed_remote_ip = $request->get('allowed_remote_ip');
            if($allowed_remote_ip == 'null'  || $allowed_remote_ip == null || $allowed_remote_ip == ''){
                $allowed_remote_ip = '';
            }

            $work_hour_start = date('H:i:s', strtotime($request->get('work_hour_start')));
            $work_hour_end = date('H:i:s', strtotime($request->get('work_hour_end')));
            SecurityProfile::where('id', $_id)->update([
                'profile_name' => $request->get('profile_name'),
                //            'user_type' => $request->get('user_type'),
                'user_email' => $request->get('user_email'),
                'allowed_remote_ip' => $allowed_remote_ip,
                'week_off_days' => implode(',', $request->get('week_off_days')),
                'work_hour_start' => $work_hour_start,
                'work_hour_end' => $work_hour_end,
                'active_status' => $request->get('active_status'),
                'alert_message' => $request->get('alert_message')
            ]);

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            //ob#code@start - (galib) remove dd
            dd($request->all());
            //ob#code@end - (galib)
            return response()->json(['status' => false]);
        }
    }
    /**************** Ending of Security related Functions *********/

    public function getDistrict()
    {
        $disctrict = Area::where('area_type', 2)->orderBy('AREA_NM', 'ASC')->get();

        //        $data = ['responseCode' => 1, 'data' => ];
        return response()->json($disctrict);
    }

    function softDelete($model, $_id)
    {
        try {
            //ob#code@start - (galib) $list unused
            $id = Encryption::decodeId($_id);
            switch (true) {
                case ($model == "Area"):
                    $cond = Area::where('area_id', $id);
                    $list = 'area-list';
                    break;
                case ($model == "Bank"):
                    $cond = Bank::where('id', $id);
                    $list = 'bank-list';
                    break;
                case ($model == "park-info"):
                    $cond = ParkInfo::where('id', $id);
                    $list = 'park-info';
                    break;
                case ($model == "Branch"):
                    $cond = BankBranch::where('id', $id);
                    $list = 'branch-list';
                    break;
                case ($model == "Currency"):
                    $cond = Currencies::where('id', $id);
                    //                    dd($cond);
                    $list = 'currency';
                    break;
                case ($model == "Document"):
                    $cond = \App\Modules\Apps\Models\DocInfo::where('id', $id);
                    $list = 'document';
                    break;
                case ($model == "EcoZone"):
                    $cond = EconomicZones::where('id', $id);
                    $list = 'eco-zones';
                    break;
                case ($model == "HighCommissions"):
                    $cond = HighComissions::where('id', $id);
                    $list = 'high-commission';
                    break;
                case ($model == "hsCode"):
                    $cond = HsCodes::where('id', $id);
                    $list = 'hs-codes';
                    break;
                case ($model == "IndustryCategories"):
                    $cond = IndustryCategories::where('id', $id);
                    $list = 'indus-cat';
                    break;
                case ($model == "Notice"):
                    $cond = Notice::where('id', $id);
                    $list = 'notice';
                    break;
                case ($model == "Port"):
                    $cond = Ports::where('id', $id);
                    $list = 'ports';
                    break;
                case ($model == "Unit"):
                    $cond = Units::where('id', $id);
                    $list = 'units';
                    break;
                default:
                    Session::flash('error', 'Invalid Model! error code (Del-' . $model . ')');
                    return Redirect::back();
            }//ob#code@end - (galib)

            $cond->update([
                'is_archived' => 1,
                'updated_by' => CommonFunction::getUserId()
            ]);


            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }


}
