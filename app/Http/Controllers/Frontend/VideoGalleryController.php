<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Models\VideoGallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoGalleryController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data['tutorial_categories'] = ['all' => 'All'] + HomePageContentCategory::where('type', 'video')->pluck('name', 'id')->toArray();
        $data['video_galleries'] =  VideoGallery::query()
            ->select('title_en', 'title_bn', 'url', 'video_length', 'image', 'video_galleries.updated_at', 'video_galleries.created_at')
            ->leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'video_galleries.tutorial_category')
            ->orderBy('ordering')
            ->where('video_galleries.status', '1')
            ->where('homepage_content_categories.status', '1')
            ->paginate(4);
        return view('frontend.pages.video_galleries.index', $data);
    }

    public function getVideoByCategory(Request $request)
    {
        $query = VideoGallery::leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'video_galleries.tutorial_category')
            ->orderBy('ordering')
            ->where('video_galleries.status','=','1');

        if(!($request->categoryId == 'all'))
        {
            $query = $query->where('video_galleries.tutorial_category', $request->categoryId);
        }
        $data['video_galleries'] = $query->get(['video_galleries.*', 'homepage_content_categories.name as category_name']);
        $public_html = strval(view("frontend.pages.video_galleries.filter-video", $data));
        return response()->json(['responseCode' => 1, 'html' => $public_html]);
    }
}
