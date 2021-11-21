@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger disapear" style="direction: rtl; text-align: right">
            <i class="fa fa-times"></i>
            {{$error}}
        </div>
    @endforeach
@endif


@if (session('success'))
    <div class="alert alert-success" style="direction: rtl; text-align: right">
        {{session('success')}}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger disapear" style="direction: rtl; text-align: right">
        {{session('error')}}
    </div>
@endif