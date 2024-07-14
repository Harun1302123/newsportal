@php
    $user_type = Auth::user()->user_type;
    $Segment = Request::segment(3);
@endphp

<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('frontend.home') }}" target="_blank" class="brand-link logo-switch">
        <img src="{{ asset('images/logo-small.png') }}" alt="{{ config('app.name') }}" class="brand-image-xl logo-xs">

        @if (Session::has('global_setting'))
            <img src="/{{ Session::get('global_setting')->logo }}" alt="{{ config('app.name') }}" class="brand-image-xs logo-xl" style="left: 12px">
        @else
            <img src="{{ asset('images/logo-group.svg') }}" alt="{{ config('app.name') }}" class="brand-image-xs logo-xl" style="left: 12px">

        @endif
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            @if(Auth::user()->user_type == 1 || Auth::user()->user_role_id != 0)
                <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item ">
                        <a href="{{ url('/dashboard') }}"
                           class="nav-link {{ Request::is('dashboard') || Request::is('dashboard/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @if (Session::has('permitted_services'))
                        @foreach (Session::get('permitted_services') as $group_name => $service_list)
                            <?php $active_filter_list = array_column($service_list, 'form_url'); ?>
                            @if (!empty($group_name) && $group_name != '')
                                <li
                                    class="nav-item {{ in_array(Request::segment(1), $active_filter_list) || in_array(Request::segment(2), $active_filter_list) ? 'menu-is-opening menu-open' : '' }}">
                                    <a href="javascript:void(0)"
                                        class="nav-link {{ in_array(Request::segment(1), $active_filter_list) || in_array(Request::segment(2), $active_filter_list) ? 'active' : '' }}">

                                        @if ($group_name == 'Manual Data Entry')
                                            <i class="fas fa-database nav-icon"></i>
                                        @elseif($group_name == 'Monitoring Framework')
                                            <i class="fas fa-chalkboard nav-icon"></i>
                                        @elseif($group_name == 'Users')
                                            <i class="fas fa-user-tie nav-icon"></i>
                                        @elseif($group_name == 'Web Portal')
                                            <i class="fas fa-tasks nav-icon"></i>
                                        @else
                                            <i class="fa fa-circle nav-icon"></i>
                                        @endif
                                        <p>{{ $group_name }}</p>
                                        <i class="fas fa-angle-left right"></i>
                                    </a>
                                    <ul class="nav-item nav-treeview" style="list-style-type: none;">
                                        @foreach ($service_list as $key => $service)
                                            <li class="nav-item">
                                                <a class="nav-link {{ Request::segment(1) == $service['form_url'] || Request::segment(2) == $service['form_url'] ? 'active' : '' }}" href="{{ url($service['form_url'] . '/list/') }}">
                                                    <i class="nav-icon {{ $service['icon'] }}"></i>
                                                    <p>{{ $service['name'] }} </p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                @foreach ($service_list as $key => $service)
                                    <li class="nav-item">
                                        <a href="{{ url($service['form_url'] . '/list/') }}"
                                            class="nav-link  {{ Request::segment(1) == $service['form_url'] || Request::segment(2) == $service['form_url'] ? 'active' : '' }}">
                                            <i class="nav-icon {{ $service['icon'] }}"></i>
                                            <p>{{ $service['name'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </ul>
            @endif
        </nav>
    </div>
</aside>
