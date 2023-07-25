@if (Session::has('succes'))
<div class="alert alert-succes text-center" role="alert">
    {{ Session::get('succes') }}
</div>
@endif

@if (Session::has('danger'))
<div class="alert alert-danger text-center" role="alert">
    {{ Session::get('danger') }}
</div>
@endif

@if (Session::has('warning'))
<div class="alert alert-warning text-center" role="alert">
    {{ Session::get('warning') }}
</div>
@endif
