@extends('layout.Main')

@section('header')
    خرید و فروش ماشین سنگین و کشنده |
@endsection

@section('ownpage_meta')
    <meta name="description" content="18 چرخ بازار خرید و فروش بی واسطه و مطمعن و قیمت روز انواع"ماشین سنگین" کشنده/کامیونت/تریلر/کامیون 911 صفر وکارکرده نقد و اقساطی می باشد.">
    <meta name="keywords" content="کامیونت کمپرسی,ماشین سنگین, فروش کامیونت,خرید کامیون,کشنده,فروش کامیون,خرید و فروش ماشین سنگی ماشین سنگین قسطی,خرید ماشین سنگین از دم قسط,تریلر تانکر ماموت,لوله فارسونگاه,بنز 10 تن, ترکتورتوربردار, wd2 800itm" />
    <meta name="robots" content="index, follow>
    
    
@endsection

@section('content')
    {{-- <div class="modall">
        <div class="popUP" >
            <div class="container-fluid">
                <div class="row" style=" place-content: center;">
                        <div class="popUPContent" >
                            <div class="row">
                                <div class="col-lg-12 col-ms-12 col-sm-12 col-xs-12  text-light text-right" >
                                    <span class="headerPopUp" aria-hidden="true" onclick="closePopUp()">&times;</span>
                                </div>
                            </div>
                             <div  class="col-lg-11 col-ms-11 col-sm-11 col-10 text-center " style="margin: 0 auto; float: none !important;">
                                <img src="{{asset('/images/bg/GhoreKeshi.jpg')}}" alt="not load" class="img-fluid img-popUp"/>
                                <img src="{{asset('/images/bg-mobile/QoreKeshiMobile.jpg')}}" alt="not load" class="img-fluid img-popUpRes"/>
                            </div>
                            <div class="col-lg-12 col-ms-12 col-sm-12 col-xs-12 text-center">                                
                                <a class="popUpBtn" href="/advertises/create">شرکت در قرعه کشی</a>                                
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </div> --}}
    <div class="hero-wrap fl-wrap full-height">

          <div id="carouselExampleCaptions" class="carousel slide h-100" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner h-100">
    <div class="carousel-item h-100 active">
      <img data-src="{{asset('/images/bg/truck-truck.jpg')}}" class="lazyload d-none d-sm-block w-100 h-100 img-fluid" alt="...">
      <img data-src="{{asset('/images/bg-mobile/bgM1.jpg')}}" class="lazyload d-sm-none w-100 h-100 img-fluid" alt="...">
     
      <div class="overlay"></div>
      <div class="carousel-caption  d-md-block grid-carousel-title">
            <h3>لیست آگهی فروش</h3>
            <div class="clearfix"></div>
            <div class="bold-separator"></div>
            <h4>بهترین خدمات برای خرید و فروش</h4>
            <a href="/advertises/all" class="hero_btn custom-scroll-link">
                <i class="fa fa-arrow-left ml-0 mr-2"></i>
                لیست آگهی فروش
            </a>
        </div>
    </div>
    <div class="carousel-item h-100">
      <img data-src="{{asset('/images/bg/Volvo-SuperTruck-1.jpg')}}" data-swiper-parallax="40%" class="lazyload d-none d-sm-block w-100 h-100 img-fluid" alt="...">
      <img data-src="{{asset('/images/bg-mobile/bgM2.jpg')}}" class="lazyload d-sm-none w-100 h-100 img-fluid" alt="...">
                                    <div class="overlay"></div>
      <div class="carousel-caption  d-md-block grid-carousel-title">
                                    <h3>ثبت آگهی فروش</h3>
                                    <div class="clearfix"></div>
                                    <div class="bold-separator"></div>
                                    <h4>تخصصی ترین مرجع ثبت آگهی فروش</h4>
                                            <a href="/advertises/create" class="hero_btn custom-scroll-link">
                                        <i class="fa fa-arrow-left ml-0 mr-2"></i>
                                       ثبت آگهی فروش
                                    </a>
                                </div>
                            
      
    </div>
    <div class="carousel-item h-100">
     <img data-src="{{asset('/images/bg/scania-symbolbild.jpg')}}" data-swiper-parallax="40%" class="lazyload d-none d-sm-block w-100 h-100 img-fluid" alt="...">
      <img data-src="{{asset('/images/bg-mobile/bgM3.jpg')}}" class="lazyload d-sm-none w-100 h-100 img-fluid" alt="...">
      <div class="overlay"></div>
      <div class="carousel-caption  d-md-block grid-carousel-title">
          
                                    <h3>ثبت رایگان آگهی اجاره</h3>
                                    <div class="clearfix"></div>
                                    <div class="bold-separator"></div>
                                    <h4>فروش و اجاره ماشین سنگین</h4>
                                            <a href="/rent/create" class="hero_btn custom-scroll-link">
                                        <i class="fa fa-arrow-left ml-0 mr-2"></i>
                                        ثبت آگهی اجاره
                                    </a>
                                </div>
     
    </div>
  </div>
  <a class="carousel-control-prev" style="z-index: 90000" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" style="z-index: 90000" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    </div>
    <div class="content">
                <!--  section    -->
        <section data-scrollax-parent="true">
            <div class="container text-center">
                <div class="section-title">
                    <h4>وجه تمایز ما در خدمت رسانی تخصصی</h4>
                    <h2>دلیل انتخاب 18 چرخ توسط مردم</h2>
                    <div class="dots-separator fl-wrap"><span></span></div>
                </div>
                <div class="cards-wrap fl-wrap">
                    <div class="row justify-content-center">
                        <!--card item -->
                        <div class="col-md-6 col-lg-4">
                            <div class="content-inner fl-wrap">
                                <div class="content-front">
                                    <div class="cf-inner">
                                        <div class="bg " style="filter: brightness(0.5);" data-bg="{{asset('/images/services/7430392.jpg')}}">
                                        </div>
                                        <div class="overlay"></div>
                                        <div class="inner">
                                            <h2>خدمات بیمه</h2>
                                            <h4>معرفی معتبرتین مراکز بیمه خودرو سنگین و نیمه سنگین</h4>
                                        </div>
    
                                    </div>
                                </div>
                                <a href="/insurance" class="content-back">
                                    <div class="cf-inner">
                                        <div class="inner">
                                            <div class="dec-icon">
                                                <img data-src="{{asset('/images/icons/brand.png')}}" class="lazyload" alt="brand">
                                            </div>
                                            <p>ما برای دسترسی راحت شما عزیزان شرایطی فراهم آورده ایم تا نزدیکترین مراکز بیمه به خود را از این طریق بیابید و سلامت جان ومال خود را تامین کنید </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--card item end -->
                        <!--card item -->
                        <div class="col-md-6 col-lg-4">
                            <div class="content-inner fl-wrap">
                                <div class="content-front">
                                    <div class="cf-inner">
                                        <div class="bg " style="filter: brightness(0.5);" data-bg="{{asset('/images/services/74645307_113518600089781_8403956185891340288_o.jpg')}}">
                                        </div>
                                        <div class="overlay"></div>
                                        <div class="inner">
                                            <h2>کیفیت ضامن سلامتی و حفظ جان</h2>
                                            <h4>معرفی معتبرترین مراکز لوازم یدکی در سراسر کشور</h4>
                                        </div>
                                      
                                    </div>
                                </div>
                                <a href="/accessory" class="content-back">
                                    <div class="cf-inner">
                                        <div class="inner">
                                            <div class="dec-icon">
                                                <img data-src="{{asset('/images/icons/spring.png')}}" class="lazyload" alt="spring"> 
                                            </div>
                                            <p>تهیه مرغوب ترین و با کیفبت ترین اجناس و قطعات خودرو با معرفی لوازم یدکی
                                                های معتبر سطح شهر.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--card item end -->
                        <!--card item -->
                        <div class="col-md-6 col-lg-4">
                            <div class="content-inner fl-wrap">
                                <div class="content-front">
                                    <div class="cf-inner">
                                        <div class="bg " style="filter: brightness(0.5);" data-bg="{{asset('/images/services/mercedes-unveils-luxurious-new-actros-trust-edition-semi-for-euro2.jpg')}}">
                                        </div>
                                        <div class="overlay"></div>
                                        <div class="inner">
                                            <h2>لوازم لوکس و اسپرت</h2>
                                          <h4>معرفی بهترین و به روزترین  نمایندگی های  لوکس فروشی   </h4>
                                                                          </div>
                                        
                                    </div>
                                </div>
                                <a href="/lux" class="content-back">
                                    <div class="cf-inner">
                                        <div class="inner">
                                            <div class="dec-icon">
                                                <img data-src="{{asset('/images/icons/construction-machine.png')}}" class="lazyload" alt="construction-machine">
                                            </div>
                                            <p>
                                                معرفی فروشگاه های لوازم لوکس و اسپرت خودروهای سنگین و نیمه سنگین به صورت
                                                لیست. شما میتوانید نزدیک ترین فروشگاه ها به خود بیابید و با مراجعه به آن
                                                خرید خود را انجام دهید.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--card item end -->
                    </div>

                </div>
                <a href="https://18charkh.com/about" style="font-size:initial" class="hero_btn categories float-none">
                    <i  class="fa fa-arrow-left"></i>
                    درباره ما بیشتر بدانید
                </a>
                <div class="images-collage-item col_par" style="width:120px" data-position-left="83" data-position-top="87" data-zindex="1" data-scrollax="properties: { translateY: '150px' }">
                    <img data-src="images/cube.png" class="lazyload" alt="cube"></div>
            </div>
            <div class="section-bg">
                <div class="bg" data-bg="images/bg/dec/section-bg.png"></div>
            </div>
        </section>
        <!--  section end  -->
               
        <section class="hidden-section big-padding" data-scrollax-parent="true" id="sec2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-title text-align_center text-center">
                            <h4>پلتفرم تخصصی</h4>
                            <h2>اطلاعات مختصر درباره ما</h2>
                            <div class="dots-separator fl-wrap"><span></span></div>
                        </div>
                        <div class="text-block">
                            <a href="https://18charkh.com/"><h4 class="mb-3" style="color: #F2BD2B">خرید کامیون</h4></a>
                            <p>
                                سایت 18 چرخ با توجه به بررسی بازار خرید و فروش ماشین سنگین علی الخصوص خرید کامیون و نیاز جامعه به یکپارچه سازی
                                صنعت
                                معاملات ماشین سنگین در سطح کشور اقدام به راه اندازی محیطی زیبا و تخصصی در امر ماشین
                                سنگین و نیمه سنگین
                                و همچنین ماشین آلات راه و شهرسازی نموده است تا هموطنان عزیز با بررسی آگهی های ثبت شده
                                خریدی امن را تجربه کنند.
                            </p>
                            <a href="https://18charkh.com/" rel="nofollow"><h5 class="mb-3" style="color: #F2BD2B">فروش کامیونت</h5></a>
                            <p>
                                شما میتوانید تمام آنچه که مربوط به ماشین سنگین، فروش کامیونت و انواع ماشین آلات ساختمانی و ... را در 18 چرخ مشاهده کنید و از خدمات ارائه شده استفاده مطلوب ببرید.
                            </p>                            
                            <a href="https://18charkh.com/about" class="btn fl-btn more-present">
                                با ما بیشتر آشنا شوید
                                <i class="fa fa-arrow-left ml-0"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 order-first order-md-last mb-5 mb-md-0">
                        <div class="image-collge-wrap fl-wrap">
                            <div class="main-iamge">
                                <img data-src="{{asset('/images/bg/img5.png')}}" class="lazyload" alt="back2">
                            </div>
                            <div class="images-collage-item" style="width:65%" data-position-left="84" data-position-top="-15" data-zindex="2" data-opacity="0.3">
                                <img data-src="{{asset('/images/bg/wheel.png')}}" class="lazyload" alt="wp2666177"></div>
                            <div class="images-collage-item col_par" style="width:120px" data-position-left="-23" data-position-top="-17" data-zindex="9" data-scrollax="properties: { translateY: '150px' }">
                                <img data-src="{{asset('/images/cube.png')}}" class="lazyload" alt="cube">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-dec sec-dec_top"></div>
                <div class="wave-bg" data-scrollax="properties: { translateY: '-150px' }"></div>
            </div>
        </section>
        <!--  section end  -->
        

        <!--  section  -->
        <section class="parallax-section bg-darkk hidden-section" data-scrollax-parent="true">
            <div class="brush-dec2"></div>
            <div class="bg par-elem bg_tabs app-bg" style=" background-image: linear-gradient(rgb(225, 174, 6), rgb(241, 185, 3), rgb(241, 185, 3));
    border-bottom-left-radius: 95%;" data-scrollax="properties: { translateY: '30%' }">
            </div>
            <div class="cd-tabs-layer" data-frame="10">
                <div class="tabs-layer"></div>
            </div>
            
            <div class="container">
                <div class="section-title">
                    <div class="row">
                     <div class="col-md-6 col-lg-6">
                         <div class="row text-right pr-3" style=" place-content: right;">
                          <div><img data-src="images/app/App1.png" class="app-img2 lazyload" alt=""></div>
                          <div><img data-src="images/app/18Charkh.png" class="app-img lazyload" alt=""></div>
                     </div>
                   
                     <div class="row justify-content-center justify-content-lg-between mt-4">
                        <!--  hero-menu_header-->
                       
                            <div class="more-info-app">
                                   <p class="p_App">
                                اپلیکیشن و سایت 18 چرخ،محل انتشار رایگان انواع آگهی و نیازمندی خریدوفروش ماشین سنگین و نیمه سنگین است.
                                با اپ 18 چرخ، در هر کجای ایران که هستید در کوتاه‌ترین زمان ماشین خود را بفروشید یا ماشین موردنظر خود را برای خرید پیدا کنید.
                            </p>

                                <div class="dl-app mt-5 text-right text-decoration-none">
                                    <a class="ml-4 app_link" href="#" title="#">
                                        <img data-src="images/app/google-play.png" class="ml-2 lazyload" alt="google-play">
                                        دانلود از گوگل پلی
                                    </a>
                                    <a class="ml-4 app_link" href="https://cafebazaar.ir/app/com.example.a18charkh" title="#">
                                        <img data-src="images/app/app-store.png" class="ml-2 lazyload" alt="app-store">
                                        دانلود از بازار
                                    </a>
                                    <a class="app_link" href="/download/app">
                                        <img data-src="images/app/18charkhApp.png" class="ml-2 lazyload" alt="18charkh">
                                        دانلود مستقیم
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
                <!--  hero-menu_header  end-->
                
                   
                        <!--  hero-menu_header  end-->
                        <!--  hero-menu_content   -->
                        <div class="col-9 col-md-6 col-lg-6 order-first order-md-last mb-5 mb-md-0 apps" style="
    text-align: center;
    place-content: center;
    margin: auto;
">
                            <img data-src="images/app/Untitled-1.png" class="img-fluid lazyload" alt="app">
                        </div>
                    </div>
                
                <!--  hero-menu  end-->
            </div>
            </div>
        </section>
        <!--  section  end-->
         <!-- section   -->
        <section class="column-section no-padding hidden-section" data-scrollax-parent="true" id="sec4">
            <div class="column-section-wrap  dark-bg">
                <div class="container w-100 text-center">
                    <div class="column-text">
                        <div class="section-title" style="margin-top:0 !important">
                            <h4>پشتیبانی 24 ساعته</h4>
                            <h2>ساعات کاری ما</h2>
                            <div class="dots-separator fl-wrap"><span></span></div>
                        </div>
                        <div class="work-time fl-wrap">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 style="font-size:25px">شنبه تا چهارشنبه</h3>
                                    <div class="hours" style="">
                                        09:30<br>
                                        18:30
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h3 style="font-size:25px">پنجشنبه</h3>
                                    <div class="hours numb" style="">
                                        09:30<br>
                                        14:30
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="big-number"><a href="tel:+982166037554" style="">02166037554</a></div>
                    </div>
                </div>
                <div class="illustration_bg">
                    <div class="bg" data-bg="images/bg/dec/7.png"></div>
                </div>
            </div>
            <div class="column-wrap-bg left-wrap">
                <div class="bg par-elem " data-bg="images/bg/120.jpg" data-scrollax="properties: { translateY: '30%' }">
                </div>
                <div class="overlay"></div>
                 <div class="quote-box text-justify" style="direction: rtl">
                     <a href="https://18charkh.com/" rel="nofollow"><h1 class="mb-2" style="color: #F2BD2B">خرید و فروش ماشین سنگین</h1></a>
                     <p>ما بر این باور هستیم که میتوانیم با فراهم کردن بستری تخصصی در امر ماشین سنگین گام های سازنده ای برای متقاضیان فراهم کنیم به همین دلیل خدمات ارائه شئه در این سایت تخصصی و متناسب با نوع فعالیت ماست.</p>

                     <a href="https://18charkh.com/" rel="nofollow"><h2 class="mb-2" style="color: #F2BD2B">فروش کامیون</h2></a>
                     <p>خرید و فروش انواع ماشین سنگین صفر و کارکرده، کامیون، اسکانیا، اتوبوس، تریلی، لودر، کشنده، مینی بوس، بولدوزر، کامیونت و ... در 18 چرخ</p>

                     <a href="https://18charkh.com/" rel="nofollow"><h3 class="mb-2" style="color: #F2BD2B">کشنده</h3></a>
                     <p>اگر به دنبال مشاهده آگهی‌های انواع کشنده و یا خرید و فروش انواع کشنده در کل ایران هستید، 18 چرخ بهترین پیشنهادها را برای شما دارد.</p>
                
                </div>
            </div>
        </section>
        <!-- section end -->
        
        <!-- section   -->
        <section>
            <div class="brush-dec2 brush-dec_bottom"></div>
            <div class="container text-center">
                <div class="section-title" dir="rtl">
                    <h4>حرف های پشت سر ما !!</h4>
                    <a href="https://18charkh.com/contact"><h2>نظـرات کـاربـران</h2></a>
                    <div class="dots-separator fl-wrap"><span></span></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="testimonilas-carousel-wrap fl-wrap text-center">
                <div class="tc-button tc-button-next"><i class="fa fa-caret-right"></i></div>
                <div class="tc-button tc-button-prev"><i class="fa fa-caret-left"></i></div>
                <div class="testimonilas-carousel">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($contact as $c)
                            <div class="swiper-slide">
                                <div class="testi-item fl-wrap">
                                    <div class="testi-avatar"><img data-src="images/user.png" class="lazyload" alt="avatar"></div>
                                    <div class="testimonilas-text txtComment fl-wrap" style="
    background-image: url(images/bg/00.jpg) !important;
">
                                        <h3>{{$c->email ? $c->email : "کاربر مهمان"}}</h3>
                                        <div class="star-rating" data-starrating="5"> </div>
                                        <p>
                                            {{$c->content}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="tc-pagination"></div>
            </div>
        </section>
        <!-- section end  -->
    </div>
    
@endsection

@section('scripts')
    {{-- <script>
        $("body").addClass("scrolllock");
 
       function closePopUp() {
           {
               $(".popUP").fadeOut(2000);
               
               $(".modall").fadeOut(2000);
    
               $("body").removeClass("scrolllock");
               
           }
           
       }
    </script> --}}
@endsection