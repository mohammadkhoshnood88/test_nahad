@extends('layout.Main')

@section('content')
    <div class="content full-height">
        <div class="body-bg">
            <div class="bg"  data-bg="images/bg/truck-truck.jpg"></div>
            <div class="overlay"></div>
        </div>
        <!--error-wrap-->
        <div class="error-wrap fl-wrap">
            <div class="container">
                <p class="perror">سایت در حال به روز رسانی است، لطفا منتظر بمانید</p>
                <h4>از شکیبایی شما متشکریم</h4>

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