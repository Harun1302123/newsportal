<?php

namespace App\Modules\Settings\Http\Controllers;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Modules\Settings\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use Illuminate\Support\Facades\Redirect;


class AchievementController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $list = Achievement::orderBy('id', 'desc')->get([
                'id',
                'title_en',
                'image',
                'number_en',
                'status'
            ]);

            return Datatables::of($list)
                ->addColumn('SL', function () {
                    static $count = 1;
                    return $count++;
                })
                ->editColumn('image', function ($list) {
                    return "<img src=" . asset($list->image) . " alt='No icon found' width='100px' height='100px'>";
                })               
                ->editColumn('status', function ($list) {
                    if ($list->status == 1) {
                        return "<span class='badge badge-success'>Active</span>";
                    } elseif ($list->status == 0) {
                        return "<span class='badge badge-danger'>Inactive</span>";
                    }
                })
                ->addColumn('action', function ($list) {
                    return '<a href="' . url('/achievements/' . Encryption::encodeId($list->id)) . '/edit/' . '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);

        } else {
            return view('Settings::achievement.list');

        }
    }


    public function create(Request $request)
    {
        return view('Settings::achievement.create');
    }

    public function store(Request $request)

    {
        try {
            $achievement = new Achievement();
            $achievement->title_en = $request->get('title_en');
            $achievement->title_bn = $request->get('title_bn');
            $achievement->number_en = $request->get('number_en');
            $achievement->number_bn = $request->get('number_bn');
            $achievement->status = $request->get('status');
            $achievement_image = $request->file('icon');
            $path = 'uploads/achievement/';
            $file_name = 'achievement_image_' . md5(uniqid()) . '.' . $achievement_image->getClientOriginalExtension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $achievement_image->move($path, $file_name);
            $achievement->image = $path . $file_name;
            $achievement->save();
            Session::flash('success', 'Data save successfully!');
            return redirect('/achievements');
        } catch (\Exception $e) {
            Session::flash('error', "Something went wrong during application data store [achievement-101]");
            return Redirect::back()->withInput();
        }
    }

    public function edit($id)
    {
        $decode_id = Encryption::decodeId($id);
        $data = Achievement::where('id', $decode_id)->first();
        return view('Settings::achievement.edit', compact('data'));
    }

    public function update(Request $request)
    {
        try {
            $achievement_id = Encryption::decodeId($request->get('id'));
            $achievement = Achievement::find($achievement_id);
            $achievement->title_en = $request->get('title_en');
            $achievement->title_bn = $request->get('title_bn');
            $achievement->status = $request->get('status');
            $achievement->number_en = $request->get('number_en');
            $achievement->number_bn = $request->get('number_bn');
            if (!empty($request->file('icon'))) {
                $achievement_image = $request->file('icon');
                $path = 'uploads/achievement/';
                $file_name =  'achievement_image_' . md5(uniqid()) . '.' . $achievement_image->getClientOriginalExtension();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $achievement_image->move($path, $file_name);
                $achievement->image = $path . $file_name;
            }
            $achievement->save();
            Session::flash('success', 'Data Updated successfully!');
            return redirect('/achievements');
        } catch (\Exception $e) {
            Session::flash('error', "Something went wrong during application data store [achievement-101]");
            return Redirect::back()->withInput();
        }
    }
}
