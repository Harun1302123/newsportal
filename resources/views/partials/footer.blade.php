<footer class="main-footer text-center">
    <div class="float-left d-none d-sm-inline-block">
        <a href=" @if (Session::has('global_setting'))
                {{ Session::get('global_setting')->support_link }}
            @endif">
            <img height="25" src="{{ asset('images/business_automation.png')}}" alt="Logo">
        </a>
    </div>

    <strong class="text-center"> Managed by  <a href="@if (Session::has('global_setting'))
                {{ Session::get('global_setting')->support_link }}
            @endif">
            @if (Session::has('global_setting'))
                {{ Session::get('global_setting')->manage_by }}
            @endif
        </a>. with associate
        @if (Session::has('global_setting'))
            {{ Session::get('global_setting')->associate }}
        @endif </strong>

    <div class="float-right d-none d-sm-inline-block">
        <a class="dlb-logo" href="https://a2i.gov.bd/">
            <img height="25" src="{{ asset('images/a2i.jpg')}}" alt="Logo">
        </a>
    </div>
</footer>
