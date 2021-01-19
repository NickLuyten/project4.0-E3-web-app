{{-- session key = success --}}
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="display: none">×</span>
        </button>
        <p>{!! session()->get('success') !!}</p>
    </div>
@endif

{{-- session key = danger --}}
@if (session()->has('danger'))
    <div class="alert alert-danger alert-dismissible ">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="display: none">×</span>
        </button>
        <p>{!! session()->get('danger') !!}</p>
    </div>
@endif