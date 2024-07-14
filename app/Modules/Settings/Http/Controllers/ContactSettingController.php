<?php

namespace App\Modules\Settings\Http\Controllers;
use App\Http\Requests\ContactSettingRequest;
use App\Libraries\ACL;
use App\Libraries\Encryption;
use App\Modules\Settings\Models\ContactSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ContactSettingController
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;

    public function __construct()
    {
        $this->service_id = 25;
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

     public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
     {
         $data = ContactSetting::where('is_archived', 0)->first();
         $edit_permission = $this->edit_permission;
         return view('Settings::contact-setting.list', compact('data', 'edit_permission'));
    }


    public function edit(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = ContactSetting::where('is_archived', 0)->first();
        $edit_permission = $this->edit_permission;
        return view('Settings::contact-setting.edit' , compact('data', 'edit_permission'));
    }
    public function update(ContactSettingRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        try {
            if($this->edit_permission) {
                $id = Encryption::decodeId($request->id);
                $general_setting = ContactSetting::find($id);
                $general_setting->manage_by = $request->get('manage_by');
                $general_setting->support_link = $request->get('support_link');
                $general_setting->associate = $request->get('associate');
                $general_setting->at_a_glance_link = $request->get('at_a_glance_link');
                $general_setting->contact_person_one_name_en = $request->get('contact_person_one_name_en');
                $general_setting->contact_person_one_name_bn = $request->get('contact_person_one_name_bn');
                $general_setting->contact_person_one_designation_en = $request->get('contact_person_one_designation_en');
                $general_setting->contact_person_one_designation_bn = $request->get('contact_person_one_designation_bn');
                $general_setting->contact_person_one_phone = $request->get('contact_person_one_phone');
                $general_setting->contact_person_one_email = $request->get('contact_person_one_email');

                $general_setting->contact_person_two_name_en = $request->get('contact_person_two_name_en');
                $general_setting->contact_person_two_name_bn = $request->get('contact_person_two_name_bn');
                $general_setting->contact_person_two_designation_en = $request->get('contact_person_two_designation_en');
                $general_setting->contact_person_two_designation_bn = $request->get('contact_person_two_designation_bn');
                $general_setting->contact_person_two_phone = $request->get('contact_person_two_phone');
                $general_setting->contact_person_two_email = $request->get('contact_person_two_email');

                $general_setting->contact_person_three_name_en = $request->get('contact_person_three_name_en');
                $general_setting->contact_person_three_name_bn = $request->get('contact_person_three_name_bn');
                $general_setting->contact_person_three_designation_en = $request->get('contact_person_three_designation_en');
                $general_setting->contact_person_three_designation_bn = $request->get('contact_person_three_designation_bn');
                $general_setting->contact_person_three_phone = $request->get('contact_person_three_phone');
                $general_setting->contact_person_three_email = $request->get('contact_person_three_email');

                if ($request->hasFile('logo')) {
                    $general_setting_photo = $request->file('logo');
                    $yearMonth = date("Y") . "/" . date("m") . "/";
                    $path = config('app.upload_doc_path') . $yearMonth;
                    $file_name = 'logo_' . md5(uniqid()) . '.' . $general_setting_photo->getClientOriginalExtension();
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $general_setting_photo->move($path, $file_name);
                    $general_setting->logo = $path . $file_name;
                }

                $general_setting->save();
                Session::forget('global_setting');
                Session::flash('success', 'Data updated successfully!');
                return redirect('/contact-setting/list');
            }
            Session::flash('error', "Don't have edit permission" );
            return redirect('/contact-setting/list');
        } catch (\Exception $e) {
            Log::error("Error occurred in ContactSettingController@update ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            Session::flash('error', "Something went wrong during application data update [G.Setting-102]");
            return Redirect::back()->withInput();
        }
    }
}
