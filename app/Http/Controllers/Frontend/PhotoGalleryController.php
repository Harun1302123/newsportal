<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhotoGalleryController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data['resource_categories'] = ['all' => 'All'] + HomePageContentCategory::where('type', 'photo')->where('status', '1')->pluck('name', 'id')->toArray();;
        $data['photo_galleries'] =  PhotoGallery::query()
            ->leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'photo_galleries.resource_category')
            ->select('title_en', 'title_bn', 'image', 'photo_galleries.updated_at', 'photo_galleries.created_at', 'resource_category')
            ->orderBy('ordering')
            ->where('photo_galleries.status','1')
            ->where('homepage_content_categories.status','1')
            ->paginate(6);
        return view('frontend.pages.photo_galleries.index', $data);
    }
    public function getPhotoByCategory(Request $request)
    {
         $query = PhotoGallery::leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'photo_galleries.resource_category')
            ->where('photo_galleries.status', '1')
            ->where('homepage_content_categories.status', '1')
            ->orderByDesc('photo_galleries.id', 'desc');

         if($request->categoryId != 'all')
         {
             $query = $query->where('photo_galleries.resource_category', $request->categoryId);
         }

        $data['photo_galleries'] = $query->get(['photo_galleries.*', 'homepage_content_categories.name as category_name']);
        $public_html = strval(view("frontend.pages.photo_galleries.filter-photo", $data));
        return response()->json(['responseCode' => 1, 'html' => $public_html]);
    }

    public function show($decode_id)
    {
        $category_id = Encryption::decodeId($decode_id);
        $data['photo_galleries'] = PhotoGallery::where('resource_category', $category_id)
        ->whereStatus(1)
        ->get();
        return view('frontend.pages.photo_galleries.show', $data);
    }
}
