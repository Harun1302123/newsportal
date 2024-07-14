<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use App\Modules\WebPortal\Models\Publication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicationController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data['categories'] = ['all'=>'All']+HomePageContentCategory::where('type','publication')->pluck('name', 'id')->toArray();
        $data['publications'] = Publication::query()
            ->select('publications.id', 'title_en', 'title_bn', 'description_en', 'description_bn', 'image', 'publications.updated_at')
            ->leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'publications.category_id')
            ->orderByDesc('id')
            ->where('publications.status','1')
            ->where('homepage_content_categories.status','1')
            ->paginate(5);
        return view('frontend.pages.publication.index', $data);
    }
    public function show($decode_id)
    {
        $id = Encryption::decodeId($decode_id);
        $data['publication'] = Publication::where('id', $id)->first();
        $cat_id=$data['publication']->category_id;
        $data['related'] = Publication::where('category_id',$cat_id)->whereStatus(1)->paginate(5);
        return view('frontend.pages.publication.show', $data);
    }

    public function getPublicationByCategory(Request $request): JsonResponse
    {
        $query = Publication::leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'publications.category_id')
            ->where('publications.status', '1')
            ->where('homepage_content_categories.status', '1')
            ->orderByDesc('publications.id', 'desc');

        if($request->categoryId != 'all')
        {
            $query = $query->where('publications.category_id', $request->categoryId);
        }

        $data['publications'] = $query->get(['publications.*', 'homepage_content_categories.name as category_name']);
        $public_html = strval(view("frontend.pages.publication.filter-publication", $data));
        return response()->json(['responseCode' => 1, 'html' => $public_html]);

    }
}
