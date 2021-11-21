@extends('layout.Main')

@section('header')
    لیست آﮔﻬﯽ اﺟﺎره |
@endsection

@section('ownpage_meta')
    <meta name="description" content="18 ﭼﺮخ ﻟﯿﺴﺖ آﮔﻬﯽ اﺟﺎره اﻧﻮاع"ﻣﺎﺷﯿﻦ ﺳﻨﮕﯿﻦ" ﮐﺸﻨﺪه/ﮐﺎﻣﯿﻮﻧﺖ/ﺗﺮﯾﻠﺮ/ﮐﺎﻣﯿﻮن 911 ﺑﺎ راﻧﻨﺪه و ﺑﺪون راﻧﻨﺪه درﺳﺮاﺳﺮ اﯾﺮان.">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H8RBEDDD1D"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-H8RBEDDD1D');
    </script>
@endsection

@section('content')
<div class="content">
    <!--  section  -->
    <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
    <!--  section  end-->
    <!--  section  -->
    <section class="hidden-section">
        <div class="container">
           <div class="row" style="direction:rtl">
                <div class="col-md-9 digit order-1 order-sm-2">
                    <div class="main-sidebar-widget fl-wrap">
                        <div class="search-widget fl-wrap">
                            <form method="get">
                                <div class="position-relative">
                                    <button class="search-submit color-bg mt-0" style="position: absolute; top: 0; left: 0; bottom: 0; width: 7%; height: 44px; font-size: 15px" type="submit" id="submit_btn"><i class="fa fa-search"></i>
                                    </button>
                                    <input name="term" id="se" type="text" class="search-inpt-item w-100" placeholder="جستجو ..."
                                    value="{{$term}}"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- vip section -->
                    <div class="row vip-sec mb-5">
                        <div class="shop-header fl-wrap d-flex justify-content-between align-items-center flex-wrap" dir="rtl">
                            <h4>
                                <i class="fa fa-diamond ml-1"></i>
                                 آگهی های ویژه </h4>
                            <span class="text-white">
                                تعداد آگهی ها :
                            <span>{{count($vip)}}</span>
                        </div>
                        <div class="row justify-content-end mt-2" style="min-width: 100%;">
                        @foreach($vip as $v)
                            <div class="col-md-4 mb-3">
                                <a class="vip-card box"
                                href="/advertises/show/{{$v->id}}/{!! str_replace(' ', '_', $v->subject) !!}" title="#">
                                    <div class="card-img-top position-relative">
                                        <img src="/post_images/related_images_watermark/{{$v->image_path}}" class="img-fluid" alt="pic">
                                        <div class="vip-overlay">
                                            <span> مشاهده بیشتر </span>
                                        </div>
                                        
                                    </div>
                                    <div class="card-body px-3 vip-content">
                                        <div class="vip-content1">
                                                    <span>{{Str::words($v->subject, $words = 4, $end = '...')}}</span>
                                             
                                            <span class="vip-ico"> 
                                                 <i class="fas fa-crown"></i>
                                            </span>
                                        </div>
                                        <div class="vip-content2 mt-3 text-justify" dir="rtl">
                                            <span>
                                                {{Str::words($v->description, $words = 6, $end = '...')}}
                                            </span>
                                            
                                        </div>
                                        <div class="vip-content3 mt-3" dir="rtl">
                                            <span class="text-gold" dir="rtl">
                                                  @if($v->price === null || $v->price === "0")
                                                @if($v->trending == 1)
                                                    معاوضه
                                                @else
                                                    توافقی
                                                @endif
                                            @else
                                                {{number_format((float)$v->price) . " تومان "}}


                                            @endif
                                             </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        </div>
                    </div>
                    <!-- vip section -->
                    <div class="fl-wrap post-container">
                        <div class="shop-header fl-wrap d-flex justify-content-between align-items-center flex-wrap" dir="rtl">
                            <h4> آگهی ها</h4>
                            <span class="text-white">
                                تعداد آگهی ها : 
                                <span id="post-count">{{$count}}</span>
                                
                            </span>
                        </div>
                        <!-- gallery start -->
                        <div class="gallery-items grid-big-pad  lightgallery two-column fl-wrap" id="posts-box">
                            @foreach($all_posts as $posts)
                            <div class="gallery-item">
                                <div class="grid-item-holder hov_zoom">
                                    <a href="/advertises/show/{{$posts->id}}/{!! str_replace(' ', '_', $posts->subject) !!}" class="box-media-zoom "><i class="fal fa-search"></i></a>
                                    <a href="/advertises/show/{{$posts->id}}/{!! str_replace(' ', '_', $posts->subject) !!}"><img src="/post_images/related_images_watermark/{{$posts->image_path}}" alt="{{$posts->subject}}"></a>                                                                        
                                </div>
                                <div class="grid-item-details mydetaile" style="direction: rtl">
                                    <h3><a href="/advertises/show/{{$posts->id}}/{!! str_replace(' ', '_', $posts->subject) !!}">{{Str::words($posts->subject, $words = 4, $end = '...')}}</a>
                                        <span>
                                            {{$posts->is_ladder() == 1 ? "نردبان" : ""}}
                                            </span>
                                    </h3>
                                    <p class="text-right">
                                        {{Str::words($posts->description, $words = 7, $end = '...')}}
                                    </p>
                                    <div class="grid-item_price">
                                        <span>اجاره ای</span>
                                        <a href="/advertises/show/{{$posts->id}}/{!! str_replace(' ', '_', $posts->subject) !!}" class="add_cart">جزییات بیشتر</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <!--  sidebar  -->
                <div class="col-md-3">
                    <!-- main-sidebar -->
                    <div class="main-sidebar fixed-bar fl-wrap">
                        <!-- main-sidebar-widget-->

                        <div class="main-sidebar-widget fl-wrap">
                            <h3 class="d-none d-md-block">فیلترها </h3>
                            <h3 class="d-md-none" data-toggle="collapse" data-target="#demo">فیلترها </h3>
                            <div class="recent-post-widget collapse d-md-block" id="demo">
                                <!--<div class="shop-header_opt">-->
                                <!--    <select name="types" id="types" data-placeholder="Persons"-->
                                <!--        class="chosen-select no-search-select">-->
                                <!--        <option value="">نوع خودرو</option>-->
                                <!--        @foreach($types as $type)-->
                                <!--            <option value="{{$type->id}}">{{$type->name}}</option>-->
                                <!--        @endforeach-->
                                <!--    </select>-->
                                <!--</div>-->

                                <div class="shop-header_opt">
                                    <select name="states" id="states" data-placeholder="Persons"
                                        class="chosen-select no-search-select">

                                        <option value="">انتخاب استان</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="shop-header_opt">
                                    <select name="status" id="status" data-placeholder="Persons"
                                        class="chosen-select no-search-select">

                                        <option value="">وضعیت راننده</option>
                                        <option value="0">فرقی نمیکند</option>
                                        <option value="1">با راننده</option>
                                        <option value="2">بی راننده</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="btn-filter" class="btn btn-success btn-block btn-filter">اعمال
                                        فیلتر
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="main-sidebar-widget fl-wrap">
                            <h3 class="d-none d-md-block">دسته بندی ها</h3>
                            <h3 class="d-md-none" data-toggle="collapse" data-target="#demo2">دسته بندی ها </h3>
                            <div class="category-widget collapse d-md-block" id="demo2">
                                <ul class="cat-item cat-item2">
                                    @foreach($types as $t)
                                        <li><a href="/rent/types/{{$t->id}}/{!! str_replace(' ', '_', $t->name) !!}">{{$t->name}}</a><span>{{count($t->posts())}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    <!-- main-sidebar-widget end-->
                    </div>
                </div>
            <!--  sidebar end-->
            </div>
            <div class="fl-wrap limit-box"></div>
        </div>
        <div class="section-bg">
            <div class="bg" data-bg="images/bg/dec/section-bg.png"></div>
        </div>
    </section>
    <!--  section end  -->
    <div class="brush-dec2 brush-dec_bottom"></div>
    </div>
@endsection

@section('scripts')

    <script src="{{asset('/js/filter.js')}}"></script>

@endsection

