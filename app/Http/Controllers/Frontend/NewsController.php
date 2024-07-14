<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data['news_categories'] = HomePageContentCategory::where('type','video')->pluck('name', 'id')->toArray();
        $data['article'] = News::query()
        ->select('news.id', 'title_en', 'title_bn', 'content_en', 'content_bn', 'image', 'news.updated_at')
        ->leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'news.category_id')
        ->orderByDesc('id')
        ->where('news.status','1')
        ->where('homepage_content_categories.status','1')
        ->paginate(8);
        return view('frontend.pages.news.index', $data);
    }
    public function show($decode_id)
    {
        $id = Encryption::decodeId($decode_id);
        $data['article'] = News::where('id', $id)->first();
        $cat_id=$data['article']->category_id;
        $data['recent'] = News::where('id', '<>', $id)
        ->whereStatus(1)
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->get();
        $data['related'] = News::where('category_id',$cat_id)->whereStatus(1)->take(3)->get();
        return view('frontend.pages.news.show', $data);
    }
}
