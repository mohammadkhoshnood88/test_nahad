@extends('layout.Main')

@section('content')
    <div class="content full-height position-fixed">
        <div class="body-bg" style="filter: brightness(0.4);">
             <div class="bg" data-bg="{{asset('/images/bg/truck-truck.jpg')}}"></div>
            <div class="overlay"></div>
        </div>
        <!--error-wrap-->
        <div class="error-wrap fl-wrap">
            <div class="container">
                <h2>505</h2>
                <p class="perror"> .متاسفیم ، صفحه مورد نظر شما یافت نشد</p>
                <div class="clearfix"></div>
                <div class="dots-separator fl-wrap"><span></span></div>
                <a href="/" class="btn">بازگشت به خانه <i class="fas fa-arrow-left"></i></a>
                <div class="section-dec sec-dec_top"></div>
                <div class="section-dec sec-dec_bottom"></div>
            </div>
        </div>
        <!--error-wrap end-->                                    
    </div>
@endsection