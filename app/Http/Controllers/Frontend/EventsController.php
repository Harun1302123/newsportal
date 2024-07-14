<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\WebPortal\Models\Event;
use App\Modules\WebPortal\Models\HomePageContentCategory;
use Illuminate\View\View;

class EventsController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $data['Event_categories'] = HomePageContentCategory::pluck('name', 'id')->toArray();
        $data['event'] = Event::query()
            ->leftJoin('homepage_content_categories', 'homepage_content_categories.id', 'events.event_category')
            ->select('events.id', 'heading_en','heading_bn','details_en','details_bn', 'image', 'events.updated_at')
        ->orderByDesc('events.id')
        ->where('events.status', '1')
        ->paginate(6);
        return view('frontend.pages.event.index', $data);
    }
    public function show($decode_id)
    {
        $id = Encryption::decodeId($decode_id);
        $data['event'] = Event::where('id', $id)->first();
        $cat_id=$data['event']->event_category;
        $data['recent'] = Event::where('id', '<>', $id)
        ->whereStatus(1)
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->get();

        $data['related'] = Event::where('event_category',$cat_id)->whereStatus(1)->take(3)->get();
        return view('frontend.pages.event.show', $data);
    }
}
