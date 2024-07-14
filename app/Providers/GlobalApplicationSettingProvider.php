<?php

namespace App\Providers;

use App\Libraries\BanglaDate;
use App\Libraries\CommonFunction;
use App\Modules\Settings\Models\ContactSetting;
use App\Modules\WebPortal\Models\MenuItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class GlobalApplicationSettingProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('frontend/partials/header', function ($view) {

            $menulist = MenuItem::query()
                ->leftJoin('menu_items as child_level_one', function ($join) {
                    $join->on('menu_items.id', '=', 'child_level_one.parent_id')
                        ->where('child_level_one.status', '=', '1');
                })
                ->leftJoin('menu_items as child_level_two', function ($join) {
                    $join->on('child_level_one.id', '=', 'child_level_two.parent_id')
                        ->where('child_level_two.status', '=', '1');
                })
                ->select('menu_items.id', 'menu_items.name as name', 'menu_items.slug as slug', 'menu_items.status as status', 'menu_items.name_bn as name_bn',
                    'child_level_one.id as level_one_id', 'child_level_one.name as level_one_name', 'child_level_one.slug as level_one_slug', 'child_level_one.status as status_one', 'child_level_one.name_bn as name_bn_one',
                    'child_level_two.id as level_two_id', 'child_level_two.name as level_two_name', 'child_level_two.slug as level_two_slug', 'child_level_two.status as status_two', 'child_level_two.name_bn as name_bn_two')
                ->where('menu_items.parent_id', '=', '0')
                ->where('menu_items.status', '=', '1')
                ->where(function ($query) {
                    $query->where('child_level_one.status', '=', '1')
                        ->orWhereNull('child_level_one.id');
                })
                ->where(function ($query) {
                    $query->where('child_level_two.status', '=', '1')
                        ->orWhereNull('child_level_two.id');
                })
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
                        $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['menu_name_bn'] = $menudata['name_bn_two'];
                        $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['slug_name'] = $menudata['level_two_slug'];
                        $menu_prepared_data[$menudata['id']]['level_one_menus'][$menudata['level_one_id']]['level_two_menus'][$menudata['level_two_id']]['status'] = $menudata['status_two'];
                    }
                }
            }

            $data['menu_items'] = $menu_prepared_data;
            $bn_date = new BanglaDate(time());
            $data['bn_date'] = $bn_date->get_date();
            CommonFunction::getOrSetSettingsData();

            $view->with($data);
        });


        /* cache logo info for one month */

        return Cache::remember('contact-info', 60 * 60 * 24 * 30, function () {
            $contactSettingInfo = ContactSetting::where('is_archived', 0)->first();
            if ($contactSettingInfo == null) {
                $contactSettingInfo = (object)[];
                $contactSettingInfo->logo = 'images/no_image.png';
            } else {
                $is_logo_exists = file_exists(public_path() . '/' . $contactSettingInfo->logo);
                if ((config('app.APP_ENV') != 'local' && $is_logo_exists != true)) {
                    $contactSettingInfo->logo = 'images/no_image.png';
                }
            }
            return $contactSettingInfo;
        });


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
