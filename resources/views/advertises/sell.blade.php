@extends('layout.Main')

@section('header')
    لیست آگهی فروش |
@endsection

@section('ownpage_meta')
    <meta name="description" content="18 ﭼﺮخ ﻟﯿﺴﺖ آﮔﻬﯽ ﻓﺮوش اﻧﻮاع"ﻣﺎﺷﯿﻦ ﺳﻨﮕﯿﻦ" ﮐﺸﻨﺪه/ﮐﺎﻣﯿﻮﻧﺖ/ﺗﺮﯾﻠﺮ/ﮐﺎﻣﯿﻮن 911 ﺻﻔﺮ و ﮐﺎرﮐﺮده ﻧﻘﺪ و اﻗﺴﺎﻃﯽ ﺳﺮاﺳﺮ اﯾﺮان.">
    
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
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fal fa-angle-double-up"></i></button>
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
                    <div class="vip-sec mb-5">
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
                                <a class="vip-card box" title=""
                                    href="/advertises/show/{{$v->id}}/{!! str_replace([' ' , '/'], '_', $v->subject) !!}">

                                    <div class="card-img-top position-relative">
                                        <img src="/post_images/related_images_watermark/{{$v->image_path}}"
                                        class="img-fluid" alt="pic">
                                        <div class="vip-overlay">
                                            <span> مشاهده بیشتر </span>
                                        </div>
                                        
                                    </div>
                                    <div class="card-body px-3 vip-content">
                                        <div class="vip-content1">
                                            <span>{{Str::words($v->subject, $words = 4, $end = '...')}}</span>
                                             
                                            <span class="vip-ico"> 
                                                ویژه
                                                <!--<i class="fa fa-crown"></i>-->
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
                        </div>
                        <!-- gallery start -->
                        <div class="gallery-items grid-big-pad  lightgallery two-column fl-wrap" id="posts-box">
                            @foreach($posts as $posts)
                            <div class="gallery-item wow animate__animated animate__fadeIn" style="position: absolute; right: unset !important; left: unset !important">
                                <div class="grid-item-holder hov_zoom">
                                    <a href="/advertises/show/{{$posts->id}}/{!! str_replace([' ' , '/'], '_', $posts->subject) !!}" class="box-media-zoom "><i class="fa fa-search"></i></a>
                                    <a href="/advertises/show/{{$posts->id}}/{!! str_replace([' ' , '/'], '_', $posts->subject) !!}"><img src="/post_images/related_images_watermark/{{$posts->image_path}}" alt="{{$posts->subject}}"></a>
                                </div>
                                <div class="grid-item-details mydetaile" style="direction: rtl">
                                    <h3><a href="/advertises/show/{{$posts->id}}/{!! str_replace([' ' , '/'], '_', $posts->subject) !!}">{{Str::words($posts->subject, $words = 4, $end = ' ...')}}</a>
                                        <span>
                                            {{$posts->is_ladder() == 1 ? "نردبان" : ""}}
                                        </span>
                                        <span>
                                            {{$posts->urgent == 1 ? "فوری" : ""}}
                                        </span>
                                    </h3>
                                    <p class="text-right">
                                        {{Str::words($posts->description, $words = 6, $end = ' ...')}}</p>
                                    <div class="reviews text-right">
                                        <span style="float: right !important; font-size: 15px; color: rgba(255, 255, 255, 0.8);">
                                            <i class="fa fa-calendar-alt align-middle ml-2"></i>
                                            تاریخ انتشار :
                                            {{\Morilog\Jalali\Jalalian::forge($posts->created_at)->format('Y/m/d')}}
                                        </span>
                                    </div>
                                    <div class="grid-item_price">
                                        <span class="text-gold">
                                            @if($posts->price === null || $posts->price === "0")
                                                @if($posts->trending == 1)
                                                    معاوضه
                                                @else
                                                    توافقی
                                                @endif
                                            @else
                                                {{number_format((float)$posts->price) . " تومان "}}


                                            @endif
                                        </span>
                                        <a href="/advertises/show/{{$posts->id}}/{!! str_replace([' ' , '/'], '_', $posts->subject) !!}" class="add_cart">جزییات بیشتر</a>
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
                    <div class="main-sidebar fixed-bar fl-wrap stickSidebar">

                        <div class="main-sidebar-widget fl-wrap">
                            <h3 class="d-none d-md-block">فیلترها </h3>
                            <h3 class="d-md-none" data-toggle="collapse" data-target="#demo">فیلترها </h3>
                            <div class="all_filters collapse d-md-block" id="demo">
                                <div class="price-rage-wrap shop-rage-wrap fl-wrap">
                                    
                                    <h5 class="text-white text-right mb-3 pb-2">
                                        <i class="fa fa-plus ml-1 align-middle" style="font-size: 13px;"></i>
                                        تعیین قیمت
                                        <small style="font-size: 13px;"> ( تومان ) </small>
                                    </h5>
    
                                    <div class="price-rage-item fl-wrap w-100" style="direction: ltr">
                                        <input type="text" class="shop-price" data-min="100000000" data-max="10000000000"
                                               id="filter_price" data-step="100000000" value=" تومان ">
                                    </div>
                                </div>
    
                                <div class="recent-post-widget">
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
                                        <select name="brands" id="brands"  data-placeholder="Persons"
                                            class="chosen-select no-search-select">
                                            <option value=""> انتخاب برند</option>
                                            @foreach ($cbrands as $cbrand)
                                                <option value="{{$cbrand->id}}">
                                                    {{$cbrand->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="shop-header_opt">
                                        <select class="chosen-select no-search-select" name="models" id="models" data-placeholder="Persons">
                                            <option value="">مدل</option>
                                        </select>
                                    </div>
                                    <div class="shop-header_opt">
                                        <select name="years" id="years" data-placeholder="Persons"
                                            class="chosen-select no-search-select">
    
                                            <option value="">انتخاب سال </option>
                                            @foreach($years as $year)
                                                <option value="{{$year->id}}">{{$year->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="shop-header_opt">
                                        <select name="gearboxes" id="gearboxes" data-placeholder="Persons"
                                            class="chosen-select no-search-select">
                                            <option value="">انتخاب گیربکس</option>
                                            @foreach($gearboxes as $gearbox)
                                                <option value="{{$gearbox->id}}">{{$gearbox->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="shop-header_opt">
                                        <select name="colors" id="colors" data-placeholder="Persons"
                                            class="chosen-select no-search-select">
                                            <option value="">انتخاب رنگ</option>
                                            @foreach($colors as $color)
                                                <option value="{{$color->id}}">{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <ul>
                                                    <li>
                                                        <div class="recent-post-img"><a href="#"><img
                                                                    src="{{ asset('images/menu/3.jpg') }}" alt="recent-post-img"></a>
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="#">Victoria's Filet Mignon</a></h4>
                                    <div class="recent-post-opt">
                                        <span class="post-date">Price: <strong>$25</strong></span>
                                        <a href="#" class="post-comments">0 Reviews</a>
                                    </div>
                                </div>
                                </li>
                                <li>
                                    <div class="recent-post-img"><a href="#"><img src="{{ asset('images/menu/3.jpg') }}"
                                                alt="recent-post-img"></a></div>
                                    <div class="recent-post-content">
                                        <h4><a href="#">Prime Cuts of Beef</a></h4>
                                        <div class="recent-post-opt">
                                            <span class="post-date">Price: <strong>$54</strong></span>
                                            <a href="#" class="post-comments">2 Reviews</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="recent-post-img"><a href="#"><img src="{{ asset('images/menu/3.jpg') }}"
                                                alt="recent-post-img"></a></div>
                                    <div class="recent-post-content">
                                        <h4><a href="#">Meatball tagliatelle</a></h4>
                                        <div class="recent-post-opt">
                                            <span class="post-date">Price: <strong>$47</strong></span>
                                            <a href="#" class="post-comments">5 Reviews</a>
                                        </div>
                                    </div>
                                </li>
                                </ul> --}}
    
                                    <div class="form-group">
                                        <button type="button" id="btn-filter" class="btn btn-success btn-block btn-filter">اعمال
                                            فیلتر
                                        </button>
                                    </div>
    
                            </div>
                            </div>
                        </div>
                    <!-- main-sidebar-widget end-->
                    <!-- main-sidebar-widget-->
                    <div class="main-sidebar-widget fl-wrap">
                        <h3 class="d-none d-md-block">دسته بندی ها</h3>
                        <h3 class="d-md-none" data-toggle="collapse" data-target="#demo2">دسته بندی ها </h3>
                        <div class="category-widget collapse d-md-block" id="demo2">
                            <ul class="cat-item cat-item2">
                                @foreach($types as $t)
                                <li><a href="/advertises/types/{{$t->id}}/{!! str_replace(' ', '_', $t->name) !!}">{{$t->name}}</a><span>{{count($t->posts())}}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- main-sidebar-widget end-->
                    <!-- main-sidebar-widget-->
                    {{-- <div class="main-sidebar-widget fl-wrap">
                                        <h3>Resent tags </h3>
                                        <div class="tags-widget">
                                            <div class="tagcloud">
                                                <a href="#">Lifystyle</a>
                                                <a href="#">Travel</a>
                                                <a href="#">Trip</a>
                                                <a href="#">Outdoor</a>
                                                <a href="#">Camping</a>
                                                <a href="#">Photos</a>
                                                <a href="#">Adventure</a>
                                            </div>
                                        </div>
                                    </div> --}}
                    <!-- main-sidebar-widget end-->
                </div>
                <!-- main-sidebar end-->
            </div>
            <!--  sidebar end-->
        </div>
        <div class="fl-wrap limit-box"></div>
</div>
</section>
<!--  section end  -->
<div class="brush-dec2 brush-dec_bottom"></div>
</div>
@endsection

@section('scripts')

    <script src="{{asset('/js/filter.js')}}"></script>
    
    <script>
        
        $('#brands').on('change', function () {
            var cbrandId = $(this).val();
            $('#models').closest('.shop-header_opt').find('.list').empty();
            if (cbrandId == "")
                return;
            var pdata = {"cbrandId": cbrandId};
            $.ajax({
                url: '/posts/ajax/models',
                data: pdata,
                method: 'post',
                success: function (x) {
                    var opt = ""
                    var models_item = ""
                    x.data.forEach(op => {
                        opt += `<option class="list_dropdown_option" value='${op.id}'>${op.name}</option>`
                        models_item += `<li class="option" data-value='${op.id}'>${op.name}</li>`
                    });
                    $("#models").append(opt);
                    $('#models').closest('.shop-header_opt').find('.list').empty();
                    $('#models').closest('.shop-header_opt').find('.list').append(`<li class="option selected">مدل</li>`);
                    $('#models').closest('.shop-header_opt').find('.list').append(models_item);
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });
         //Get the button
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        
    </script>
    
@endsection
