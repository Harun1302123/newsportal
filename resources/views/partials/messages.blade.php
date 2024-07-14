@if (session()->has('success'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif
