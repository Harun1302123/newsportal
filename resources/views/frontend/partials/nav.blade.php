@if(!config('app.is_mobile'))
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="site-nav-box">
            <a class="navbar-brand" href="{{ route('frontend.home') }}">
                <div class="nfis-logo">
                    <span class="nfis-logo-img">
                        @if (Session::has('global_setting'))
                            <img src="/{{ Session::get('global_setting')->logo }}" alt="{{ config('app.name') }}" onerror="this.src=`{{asset('images/no_image.webp')}}`">
                        @else
                            <img src="{{ asset('images/logo-group.svg') }}" alt="{{ config('app.name') }}" onerror="this.src=`{{asset('images/no_image.webp')}}`">
                        @endif
                    </span>
                </div>
            </a>

            <div class=" topBtnSrc py-2 px-3 rounded" href="#" style="border: solid 1px darkgreen;">
                    <span>
                        <span class="menu-src-text hide-search">{{ languageStatus() == 'en' ? 'Search' : "অনুসন্ধান" }}</span>
                        <i class="fas fa-search"></i>
                    </span>
            </div>

            <button class="navbar-toggler resView collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            {{-- <div class="nfis-search resView">
                <form action="">
                    <div class="nav-search-group">
                        <span class="nav-src-icon"></span>
                        <input class="nav-src-input" type="text" placeholder="{{ languageStatus() == 'en' ? 'Search-keyword' : "অনুসন্ধান-কীওয়ার্ড" }}">
                        <button type="submit" class="nav-src-btn">{{ languageStatus() == 'en' ? 'Search' : "অনুসন্ধান" }}</button>
                    </div>
                </form>
            </div> --}}

            <ul class="navbar-nav mb-2 mb-md-0">

                @foreach($menu_items as $menudata)
                    @if($menudata['status'] == '1')
                        <li class="nav-item  @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0) nfis-dropdown  @endif">
                            <a class="nav-link
                            @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0) dd-toggle @endif"
                               @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0)
                                href="#"
                               @else
                                    @if($menudata['slug_name']=="#nfisStrategicGoal")
                                        href="/#nfisStrategicGoal"
                                    @else
                                        href="/menu/{{ $menudata['slug_name'] }}"
                                    @endif
                                @endif >
                                {{ languageStatus() == 'en' ? $menudata['menu_name'] : ($menudata['menu_name_bn'] ? $menudata['menu_name_bn'] : $menudata['menu_name'] )  }}
                            </a>
                            @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0)
                                <ul class="nfis-dd-menu">
                                    @foreach($menudata['level_one_menus'] as $level_one_menu)
                                        @if($level_one_menu['status'] == '1')
                                            <li class="@if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) dd-submenu @endif">
                                                <a @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) href="#" @else href="/menu/{{ $level_one_menu['slug_name'] }}"
                                                   @endif
                                                   class="dd-item @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) dd-toggle @endif">
                                                    {{ languageStatus() == 'en' ? $level_one_menu['menu_name'] : ($level_one_menu['menu_name_bn'] ? $level_one_menu['menu_name_bn'] : $level_one_menu['menu_name'] )  }}
                                                </a>
                                                @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0)
                                                    <ul class="nfis-dd-menu">
                                                        @foreach($level_one_menu['level_two_menus'] as $level_two_menu)
                                                            @if($level_two_menu['status'] == '1')
                                                                <li><a href="/menu/{{ $level_two_menu['slug_name'] }}"
                                                                       class="dd-item">
                                                                        {{ languageStatus() == 'en' ? $level_two_menu['menu_name'] : ($level_two_menu['menu_name_bn'] ? $level_two_menu['menu_name_bn'] : $level_two_menu['menu_name'] )  }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
@else
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="site-nav-box">
            <a class="navbar-brand" href="{{ route('frontend.home') }}">
                <div class="nfis-logo">
                    <span class="nfis-logo-img">
                        @if (Session::has('global_setting'))
                            <img src="/{{ Session::get('global_setting')->logo }}" alt="{{ config('app.name') }}" onerror="this.src=`{{asset('images/no_image.webp')}}`">
                        @else
                            <img src="{{ asset('images/logo-group.svg') }}" alt="{{ config('app.name') }}" onerror="this.src=`{{asset('images/no_image.webp')}}`">
                        @endif
                    </span>
                </div>
            </a>

            <button class="navbar-toggler resView collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="htop-right d-flex float-right">
                @if(Auth::user())
                    <a href="{{ route('dashboard') }}" class="nfis-btn dashboard-btn"><i class="far fa-id-card"></i></a>
                @else
                    <a href="{{ route('login') }}" class="nfis-btn"><span class="icon-btn-arrow-white"></span> {{ languageStatus() == 'en' ? 'Login' : "লগইন" }}</a>
                @endif
            </div>
            <ul class="navbar-nav mb-2 mb-md-0">
                @foreach($menu_items as $menudata)
                    @if($menudata['status'] == '1')
                        <li class="nav-item  @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0) nfis-dropdown  @endif">
                            <a class="nav-link
                            @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0) dd-toggle @endif"
                               @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0)
                                href="#"
                               @else
                                    @if($menudata['slug_name']=="#nfisStrategicGoal")
                                        href="/#nfisStrategicGoal"
                                    @else
                                        href="/menu/{{ $menudata['slug_name'] }}"
                                    @endif
                                @endif >
                                {{ languageStatus() == 'en' ? $menudata['menu_name'] : ($menudata['menu_name_bn'] ? $menudata['menu_name_bn'] : $menudata['menu_name'] )  }}
                            </a>
                            @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0)
                                <ul class="nfis-dd-menu">
                                    @foreach($menudata['level_one_menus'] as $level_one_menu)
                                        @if($level_one_menu['status'] == '1')
                                            <li class="@if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) dd-submenu @endif">
                                                <a @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) href="#" @else href="/menu/{{ $level_one_menu['slug_name'] }}"
                                                   @endif
                                                   class="dd-item @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) dd-toggle @endif">
                                                    {{ languageStatus() == 'en' ? $level_one_menu['menu_name'] : ($level_one_menu['menu_name_bn'] ? $level_one_menu['menu_name_bn'] : $level_one_menu['menu_name'] )  }}
                                                </a>
                                                @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0)
                                                    <ul class="nfis-dd-menu">
                                                        @foreach($level_one_menu['level_two_menus'] as $level_two_menu)
                                                            @if($level_two_menu['status'] == '1')
                                                                <li><a href="/menu/{{ $level_two_menu['slug_name'] }}"
                                                                       class="dd-item">
                                                                        {{ languageStatus() == 'en' ? $level_two_menu['menu_name'] : ($level_two_menu['menu_name_bn'] ? $level_two_menu['menu_name_bn'] : $level_two_menu['menu_name'] )  }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
@endif