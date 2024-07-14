<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Libraries\Encryption;
use App\Modules\FinancialInclusion\Models\FinancialInclusion;
use App\Modules\Goals\Models\Goal;
use App\Modules\Polls\Models\Poll;
use App\Modules\WebPortal\Models\Comment;
use App\Modules\WebPortal\Models\Credit;
use App\Modules\WebPortal\Models\Event;
use App\Modules\WebPortal\Models\MenuItem;
use App\Modules\WebPortal\Models\NationalStrategiesNFIS;
use App\Modules\WebPortal\Models\News;
use App\Modules\WebPortal\Models\Banner;
use App\Modules\WebPortal\Models\Biography;
use App\Modules\WebPortal\Models\ImportantLink;
use App\Modules\WebPortal\Models\PhotoGallery;
use App\Modules\WebPortal\Models\RulesRegulations;
use App\Modules\WebPortal\Models\VideoGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Modules\WebPortal\Models\Resource;
use App\Modules\MonitoringFramework\Models\MefIndicator;
use App\Modules\Targets\Models\Target;

class HomePageController extends Controller
{
    const ACTIVE_STATUS = 1;
    /**
     * @return view
     */
    public function home(): View
    {
        $data = [];

        $data['banners'] = Banner::query()
            ->select('description_en', 'description_bn', 'title_en', 'title_bn', 'image')
            ->orderByDesc('id')
            ->whereStatus(self::ACTIVE_STATUS)
            ->get();

        $data['biographies'] = Biography::query()
            ->select('id', 'name_en', 'name_bn', 'designation_en', 'designation_bn', 'organization_en', 'organization_bn', 'image')
            ->orderByDesc('id')
            ->whereStatus(self::ACTIVE_STATUS)
            ->take(2)
            ->get();

        $data['goals'] = Goal::query()
            ->select('title_en', 'title_bn', 'hex_color', 'bg_image', 'target', 'order')
            ->orderBy('order')
            ->whereStatus(self::ACTIVE_STATUS)
            ->get();

        $data['article'] = News::query()
            ->select('id', 'title_en', 'title_bn', 'image', 'updated_at')
            ->orderByDesc('id')
            ->whereStatus(self::ACTIVE_STATUS)
            ->take(3)
            ->get();

        $data['photo_galleries'] = PhotoGallery::query()
            ->select('title_en', 'title_bn', 'resource_category', 'image', 'photo_galleries.updated_at', 'photo_galleries.created_at')
            ->join('homepage_content_categories', 'homepage_content_categories.id', '=', 'photo_galleries.resource_category')
            ->orderByDesc('photo_galleries.id')
            ->where('homepage_content_categories.type', '=', 'photo')
            ->where('homepage_content_categories.status', '=', '1')
            ->where('photo_galleries.status', '=', '1')
            ->groupBy('resource_category')
            ->take(4)
            ->get();

        $data['event'] = Event::query()
            ->orderBy('event_date')
            ->whereStatus(self::ACTIVE_STATUS)
            ->where('event_date', '>', now())
            ->first(['heading_en', 'heading_bn', 'image', 'event_date']);

        $data['video_galleries'] = VideoGallery::query()
            ->select('title_en', 'title_bn', 'url', 'video_length', 'image', 'video_galleries.updated_at', 'video_galleries.created_at')
            ->join('homepage_content_categories', 'homepage_content_categories.id', '=', 'video_galleries.tutorial_category')
            ->where('homepage_content_categories.type', '=', 'video')
            ->where('homepage_content_categories.status', '=', '1')
            ->where('video_galleries.status', '=', '1')
            ->orderBy('ordering')
            ->take(4)
            ->get();

        $data['financial_inclusion_bank'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 1)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        $data['financial_inclusion_nbfi'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 2)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        $data['financial_inclusion_mfs'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 3)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        $data['financial_inclusion_mfis'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 4)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        $data['financial_inclusion_insurance'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 5)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        $data['financial_inclusion_cmis'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 6)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        $data['financial_inclusion_cooperatives'] = FinancialInclusion::with('quarter', 'organization_types')
            ->where('organization_type_id', 7)
            ->where('status', self::ACTIVE_STATUS)
            ->orderByDesc('mef_year')
            ->orderByDesc('mef_quarter_id')->first([
                'id',
                'total'
            ]);

        return view('frontend.pages.home.index', $data);

    }
    public function globalSearch(Request $request)
    {
        $photo_galleries = PhotoGallery::where('status', 1)
            ->where('title_en','LIKE',"%{$request->search_data}%")
            ->orWhere('title_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'title_en','title_bn']);
        $biographies = Biography::where('status', 1)
            ->where('name_en','LIKE',"%{$request->search_data}%")
            ->orWhere('name_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'name_en', 'name_bn']);
        $articles = News::where('status', 1)
            ->where('title_en','LIKE',"%{$request->search_data}%")
            ->orWhere('title_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'title_en','title_bn']);
        $video_galleries = VideoGallery::where('status', 1)
            ->where('title_en','LIKE',"%{$request->search_data}%")
            ->orWhere('title_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'title_en','title_bn']);
        $goals = Goal::where('status', 1)
            ->where('title_en','LIKE',"%{$request->search_data}%")
            ->orWhere('title_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'title_en','title_bn']);
        $indicators = MefIndicator::where('status', 1)
            ->where('name','LIKE',"%{$request->search_data}%")
            ->orWhere('name_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'name', 'name_bn']);
        $targets = Target::where('status', 1)
            ->where('title_en','LIKE',"%{$request->search_data}%")
            ->orWhere('title_bn','LIKE',"%{$request->search_data}%")
            ->get(['id', 'title_en','title_bn']);
 
        $public_html = strval(view("search-results",  compact('photo_galleries', 'biographies', 'articles','video_galleries','goals','indicators','targets')));

        return response()->json(['responseCode'=>1, 'html'=>$public_html]);
    }
    
    /**
     * @param @slug
     * @return View|RedirectResponse
     */
    public function dynamicMenuShow($slug): View|RedirectResponse
    {
        $data['page'] = MenuItem::where(['slug' => $slug, 'status' => 1])->orderBy('ordering', 'asc')->first();
        switch ($slug) {
            case "m-and-e-framework":
                return redirect()->action([MandEFrameworkController::class, 'index']);
                break;
            case "stakeholders":
                return redirect()->action([StakeholderController::class, 'index']);
                break;
            case "#nfisStrategicGoal":
                return redirect()->action([HomePageController::class, 'home']);
                break;
            case "publication":
                return redirect()->action([PublicationController::class, 'index']);
                break;
            case "sdg-nfis":
                return redirect()->action([SdgNfisController::class, 'index']);
                break;
            case "national-strategies-and-nfis":
                return $this->nationalStrategiesAndNfis();
                break;

            case "rules-and-regulations":
                return $this->rulesAndRegulations();
                break;


            default:
                if (!$data['page']) {
                    abort(404);
                }
                return view('frontend.pages.dynamic_menu.index', $data);
        }

    }

    public function ImportantLink()
    {
        $data['links'] = ImportantLink::query()
            ->select('id', 'title_en', 'title_bn', 'important_link')
            ->orderByDesc('id')
            ->whereStatus(1)
            ->paginate(6);
        return view('frontend.pages.important_link.important_link', $data);
    }

    public function pollDetails()
    {
        $data['polls'] = Poll::query()
            ->select('id', 'title_en', 'title_bn', 'description_en', 'description_bn', 'image', 'start_at', 'end_at', 'status')
            ->orderByDesc('id')
            ->whereStatus(1)
            ->where('start_at', '<', date("Y-m-d H:s:i"))
            ->where('end_at', '>', date("Y-m-d H:s:i"))
            ->paginate(6);
        return view('frontend.pages.polls.poll_details', $data);
    }

    public function Resource()
    {
        $data['resource'] = Resource::query()
            ->select('id', 'title_en', 'title_bn', 'attachment')
            ->orderByDesc('id')
            ->whereStatus(1)
            ->paginate(5);
        return view('frontend.pages.resource.resource', $data);
    }

    public function BiographyDetail($encode_id)
    {
        $decode_id = Encryption::decodeId($encode_id);
        $data['biography'] = Biography::where('id', $decode_id)
            ->orderByDesc('id')
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.pages.biography_details.index', $data);

    }

    public function sitemap(): View
    {
        $menulist = MenuItem::query()
            ->join('menu_items as child_level_one', 'menu_items.id', '=', 'child_level_one.parent_id', 'left outer')
            ->join('menu_items as child_level_two', 'child_level_one.id', '=', 'child_level_two.parent_id', 'left outer')
            ->select('menu_items.id', 'menu_items.name as name', 'menu_items.slug as slug', 'menu_items.status as status', 'menu_items.name_bn as name_bn',
                'child_level_one.id as level_one_id', 'child_level_one.name as level_one_name', 'child_level_one.slug as level_one_slug', 'child_level_one.status as status_one', 'child_level_one.name_bn as name_bn_one',
                'child_level_two.id as level_two_id', 'child_level_two.name as level_two_name', 'child_level_two.slug as level_two_slug', 'child_level_two.status as status_two', 'child_level_two.name_bn as name_bn_two')
            ->where('menu_items.parent_id', '=', '0')
            ->where('menu_items.status', '=', '1')
            ->orderBy('menu_items.ordering', 'asc')
            ->orderBy('child_level_one.ordering', 'asc')
            ->orderBy('child_level_two.ordering', 'asc')
            ->get()
            ->toArray();

        $menu_prepared_data = [];
        foreach ($menulist as $menudata) {
            $menu_prepared_data[$menudata['id']]['menu_name'] = $menudata['name'];
            $menu_prepared_data[$menudata['id']]['menu_name_bn'] = $menudata['name_bn'];
            $menu_prepared_data[$menudata['id']]['slug_name'] = $menudata['slug'];
            $menu_prepared_data[$menudata['id']]['status'] = $menudata['status'];
            if (!empty($menudata['level_one_name'])) {
                $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['menu_name'] = $menudata['level_one_name'];
                $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['menu_name_bn'] = $menudata['name_bn_one'];
                $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['slug_name'] = $menudata['level_one_slug'];
                $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['status'] = $menudata['status_one'];
                if (!empty($menudata['level_two_name'])) {
                    $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['menu_name'] = $menudata['level_two_name'];
                    $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['menu_name_bn'] = $menudata['name_bn_one'];
                    $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['slug_name'] = $menudata['level_two_slug'];
                    $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['status'] = $menudata['status_two'];
                }
            }
        }

        $data['menu_items'] = $menu_prepared_data;

        return view('frontend.pages.sitemap.index', $data);
    }

    public function citizenCharter(): View
    {

        return view('frontend.pages.citizen_charter.index');
    }

    public function comments(): View
    {
        return view('frontend.pages.comment.index');
    }

    public function commentStore(CommentRequest $request): RedirectResponse
    {
        $comment = new Comment();
        $comment->name = $request->get('name');
        $comment->email = $request->get('email');
        $comment->number = $request->get('number');
        $comment->details = $request->get('details');
        $comment->save();

        Session::flash('success', 'Comment Submit successfully!');
        return redirect()->route("frontend.comments");
    }

    public function contactUs(): View
    {
        return view('frontend.pages.contact_us.index');
    }

    public function credit(): View
    {
        $data['a2i_team'] = Credit::where('type', 'aspire_to_innovate')->get();
        $data['dev_maintenance_team'] = Credit::where('type', 'nfis_tracker_development_&_maintenance_team')->get();
        $data['ba_team'] = Credit::where('type', 'business_automation_ltd')->get();
        return view('frontend.pages.credit.index', $data);
    }

    public static function nationalStrategiesAndNfis(): View
    {
        $data['data'] = NationalStrategiesNFIS::where('status', 1)->get();

        return view('frontend.pages.national_strategies_nfis.index', $data);
    }

    public static function rulesAndRegulations(): View
    {
        $data['data'] = RulesRegulations::where('status', 1)->get();

        return view('frontend.pages.rules_regulations.index', $data);
    }
}
