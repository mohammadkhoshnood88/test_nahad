@extends('layout.Main')

@section('style')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>

    <style>
        .leaflet-popup-content-wrapper {
            background: linear-gradient(60deg, yellowgreen, greenyellow);
        }

        .leaflet-popup-content-wrapper .leaflet-popup-content {
        }

        .leaflet-popup-tip-container {dots-separator fl-wrap
        }
         #contact_phone{
            cursor: pointer;
        }
        #contact_phone:hover{
            cursor: pointer;
            color: #C19D60;
        }
    </style>

        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>


@endsection
    
@section('content')
<div class="content">
    <!--  section  -->
    <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
     <!--<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fal fa-angle-double-up"></i></button>-->
     <a id="myBtn2"></a>
    <!--  section  end-->
    <!--  section  -->
    <section class="hidden-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="fl-wrap post-container">
                        <!-- post -->
                        <div class="post fl-wrap fw-post">
                            <div class="shop-header-title fl-wrap">
                                <h2 style="color: #C19D60;">{{$posts->subject}}</h2>
                                <div class="shop-header-title_opt w-100">
                                    <ul>
                                        <li>
                                            
                                                      @if($posts->price === null || $posts->price === "0")
                                                @if($posts->trending == 1)
                                                    
                                                    <span class="menu-single-preice">
                                                
                                                <strong>
                                                    مایل به معاوضه
                                                </strong>
                                                
                                                </span>
                                                    
                                                @else
                                                    <span class="menu-single-preice">قیمت :
                                                
                                                <strong>
                                                    توافقی
                                                </strong>
                                                
                                                </span>
                                                @endif
                                            @else
                                                
                                                <span class="menu-single-preice">قیمت :
                                                
                                                <strong>
                                                    {{number_format((float)$posts->price) . " تومان "}}    
                                                </strong>
                                                
                                                </span>

                                            @endif
                                            
                                            
                                            
                                        </li>
                                        
                                    </ul>
                                    <span style="color: #fff; font-size: 15px; float: left;">
                                        تاریخ انتشار:
                                        {{\Morilog\Jalali\Jalalian::forge($posts->created_at)->format('Y/m/d')}}
                                    </span>
                                </div>
                            </div>
                            <div class="blog-media fl-wrap">
                                <div class="single-slider-wrap">
                                    <div class="single-slider fl-wrap">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper lightgallery">

                                                @foreach ($images as $image)

                                                <div class="swiper-slide hov_zoom">
                                                    <img class="posts_img" src="/post_images/related_images_watermark/{{$image->path}}" alt="{{$posts->subject}}">
                                                    <a href="/post_images/related_images_watermark/{{$image->path}}" class="box-media-zoom popup-image">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </div>

                                                @endforeach

                                            </div>
                                            <div class="ss-slider-pagination"></div>
                                            <div class="ss-slider-cont ss-slider-cont-prev"><i class="fa fa-caret-left"></i></div>
                                            <div class="ss-slider-cont ss-slider-cont-next"><i class="fa fa-caret-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="blog-text fl-wrap">
                                <div class="pr-tags fl-wrap">
                                    <span> نوع خودرو : </span>
                                    <ul>
                                        <li>
                                            @if($posts->is_rent == 0)
                                                <a href="/advertises/types/{{$posts->type}}/{!! str_replace(' ', '_', $posts->type_name->name) !!}">{{$posts->type_name->name}}</a>
                                            @else
                                                <a href="/rent/types/{{$posts->type}}/{!! str_replace(' ', '_', $posts->type_name->name) !!}">{{$posts->type_name->name}}</a>
                                            @endif
                                        </li>
                                    </ul>
                                    @if($posts->urgent == 1)
                                    <p class="fori-me animate__animated animate__flash animate__slow animate__infinite"> فوری </p>
                                    @endif
                                </div>
                                <p style="white-space: pre-line;">
                                    {{$posts->description}}
                                </p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="bold-separator bold-separator_dark"><span></span></div>
                            <div class="clearfix"></div>
                            @if($posts->location != null)
                            <div class="col-sm-12 mb-5">
                                <div class="map" id="maps_show">

                                </div>
                            </div>
                            @endif
                            <div class="shop-item-footer fl-wrap">
                               <div class="col-md-12">
                                   <div class="row" style="direction:rtl">
                                       <div class="col-md-4 mb-3">
                                              <ul class="post-counter float-md-right">
                                                <li><i class="fa fa-eye"></i><span class="mr-2">{{$posts->visits()}}</span></li>
                                                <li><i class="fa fa-shopping-bag"></i><span class="mr-2">256</span></li>
                                              </ul> 
                                       </div>
                                        <div class="col-md-8 mt-2" >
                                           <p class="">18 چرخ هیچ‌گونه منفعت و مسئولیتی در قبال معامله شما ندارد</p>
                                       </div>
                                   </div>
                               </div>
                          </div>
                        </div>
                    </div>
                </div>
                <!--  sidebar  -->
                <div class="col-md-4">
                    <!-- main-sidebar -->
                    <div class="main-sidebar fixed-bar fl-wrap">

                        <div class="main-sidebar-widget fl-wrap">
                            <h3 style="color: #C19D60;">جزییات آگهی</h3>
                            <div class="category-widget">

                                <ul class="cat-item">
                                    @if($posts->is_rent == 0)
                                    <li>
                                        <h5 class="d-inline-block mb-3">محل اگهی</h5 class="d-inline-block mb-3">
                                        <p>{{$posts->State->name}} ، {{$posts->City->name}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">نوع برند</h5 class="d-inline-block mb-3">
                                        <p>{{$posts->cbrand_id ? $posts->Cbrand->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">نوع مدل</h5 class="d-inline-block mb-3">
                                        <p>{{$posts->cmodel_id ? $posts->Cmodel->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">گیربکس </h5 class="d-inline-block mb-3">
                                        <p>{{$posts->gearbox_id ? $posts->Gearbox->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">سلامت بدنه </h5 class="d-inline-block mb-3">
                                        <p>{{$posts->cbody_id ? $posts->Cbody->name : 'موجود نیست' }}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">رنگ</h5 class="d-inline-block mb-3">
                                        <p>{{$posts->color_id ? $posts->Color->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">سال ساخت</h5 class="d-inline-block mb-3">
                                        <p>{{$posts->year_id ? $posts->Year->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">کارکرد</h5 class="d-inline-block mb-3">
                                        <p style="direction:rtl"> {{ number_format($posts->distance) }} &ensp; کیلومتر  </p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">آیدی اینستاگرام</h5 class="d-inline-block mb-3">
                                        
                                            @if(isset($posts->instagram_id))
                                                <p>{{$posts->instagram_id}}</p>
                                            @else
                                                <img src="{{asset('/images/icons/unseen_instagram.png')}}" class="float-left" />
                                            @endif
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">آدرس سایت</h5 class="d-inline-block mb-3">
                                        
                                        @if(isset($posts->website))
                                            <p>{{$posts->website}}</p>
                                        @else
                                            <img src="{{asset('/images/icons/unseen_site.png')}}" class="float-left" />
                                        @endif
                                        
                                    </li>
                                   
                                    
                                    @else
                                    <li>
                                        <h5 class="d-inline-block mb-3">وضعیت راننده</h5 class="d-inline-block mb-3">
                                        <p>
                                        @if($posts->driver_status == '1')
                                            با
                                            راننده
                                            {{$posts->workers ? "همراه با $posts->workers کارگر " : "بدون کارگر"}}
                                        @else
                                        {{$posts->driver_status === '0'? "فرقی نمیکند" : ($posts->driver_status == '2' ? "بدون راننده" : "")}}
                                        @endif
                                        </p>
                                    </li>
                                    @endif
                                    
                                    <li>
                                        <h5 class="d-inline-block mb-3">شماره تماس</h5 class="d-inline-block mb-3">
                                        <p id="contact_phone" >{{substr_replace($posts->phone_number, '****', 4, 4)}}</p>
                                    </li>
                                    
                                    <li id="polic-alert">
                                        <div class="alert alert-info py-3 px-4 " style="direction:rtl;font-size:15px" role="alert">
                                            <span class="font-weight-bold" style="background:transparent !important;">هشدار پلیس</span>
 
                                            لطفا پیش از انجام معامله و هر نوع پرداخت وجه، از صحت خدمات ارائه شده، به صورت حضوری اطمینان حاصل نمایید  .
                                        </div>
                                     </li>
                                </ul>
                                <div class="category-widget">
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#largeModal">گزارش مشکل آگهی</a>
                                    <div class="menu-single_rating d-inline-block my-3 mx-2">
                                
                                        
                                                                   @if(\Illuminate\Support\Facades\Session::get('login'))
                                            <div class="markup" data-id="{{$posts->id}}">
                                                @if($data['mark'] == "")
                                                    <a class="btn success text-center">نشان کردن <i
                                                                class="fa fa-bookmark-o mx-3"></i></a>
                                                @else
                                                    <a class="btn success text-center">حذف نشان<i
                                                                class="fa fa-bookmark mx-3"></i></a>
                                                @endif

                                            </div>
                                        @else

                                            <div class="cookmark" style="cursor: pointer" data-id="{{$posts->id}}">
                                                @if($data['mark'] == "")

                                                    <a class="btn success text-center">نشان کردن <i
                                                                class="fa fa-bookmark-o mx-3"></i></a>
                                                @else

                                                    <a class="btn success text-center">حذف نشان<i
                                                                class="fa fa-bookmark mx-3"></i></a>

                                                @endif

                                            </div>

                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- main-sidebar-widget end-->
                        </div>
                        <!-- main-sidebar end-->
                    </div>
                    <!--  sidebar end-->
                </div>
                <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal"
                            aria-modal="true" style="padding-left: 17px;margin: 70px 0;">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">گزارش مشکل آگهی</h4>
                                        <button type="button" class="close close-switch" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="kt-modal__contents">
                                            <div class="kt-modal__body kt-modal__body--actionable"
                                                style=" text-align: right;direction: rtl;">
                                                <h5 class="post-report-modal__title kt-title kt-title--xs">دقیقاً چه
                                                    مشکلی وجود دارد؟<h5>
                                                <p class="post-report-modal__description kt-body kt-body--sm" style="color: #000;
    font-size: 14px;">نزدیک ترین
                                                    گزینه را انتخاب کنید. ارائه جزییات بیشتر، به ما امکان بررسی
                                                    سریع&zwnj;تر و دقیق&zwnj;تر مشکل را می&zwnj;دهد.</p>
                                            
                                            <p style="display:none" class="alert_show alert alert-primary">alert_show</p>        
                                            
                                                <div>
                                                    <div class="kt-switch" style="display: flex;display: inline-flex;align-items: center;min-height: 2.5rem;">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0">
                                                            <input name="customRadio" class="kt-switch__input digit"
                                                                id="radio-radio-19dk4pa" type="radio" tabindex="-1"
                                                                value="" autocomplete="off">
                                                            <div class="kt-switch__button kt-switch__button--radio"></div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div>
                                                        <label class="kt-switch__label" for="radio-radio-19dk4pa">محتوای
                                                            آگهی</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="kt-switch">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0">
                                                            <input name="customRadio" class="kt-switch__input digit"
                                                                id="radio-radio-17mnonm" type="radio" tabindex="-1"
                                                                value="" autocomplete="off">
                                                            <div class="kt-switch__button kt-switch__button--radio">
                                                            </div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div>
                                                        <label class="kt-switch__label" for="radio-radio-17mnonm">عکس
                                                            آگهی</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="kt-switch">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0"><input name="customRadio" class="kt-switch__input digit"
                                                                id="radio-radio-27b00jh" type="radio" tabindex="-1"
                                                                value="" autocomplete="off">
                                                            <div class="kt-switch__button kt-switch__button--radio">
                                                            </div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div>
                                                        <label class="kt-switch__label"
                                                            for="radio-radio-27b00jh">اطلاعات تماس</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="kt-switch">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0"><input name="customRadio" class="kt-switch__input digit"
                                                                id="radio-radio-241fhl0" type="radio" tabindex="-1"
                                                                value="" autocomplete="off">
                                                            <div class="kt-switch__button kt-switch__button--radio">
                                                            </div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div>
                                                        <label class="kt-switch__label"
                                                            for="radio-radio-241fhl0">قیمت</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="kt-switch">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0"><input name="customRadio" class="kt-switch__input digit"
                                                                id="radio-radio-282n9ol" type="radio" tabindex="-1"
                                                                value="" autocomplete="off">
                                                            <div class="kt-switch__button kt-switch__button--radio">
                                                            </div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div><label class="kt-switch__label"
                                                            for="radio-radio-282n9ol">کلاهبرداری،
                                                            جرم</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="kt-switch">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0"><input name="customRadio" class="kt-switch__input digit"
                                                                id="radio-radio-273obip" type="radio" tabindex="-1"
                                                                value="" autocomplete="off">
                                                            <div class="kt-switch__button kt-switch__button--radio">
                                                            </div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div><label class="kt-switch__label"
                                                            for="radio-radio-273obip">ناموجود بودن مورد آگهی</label>
                                                    </div>
                                                </div>
                                                 <div>
                                                    <div class="kt-switch">
                                                        <div class="kt-switch__cell" role="radio" aria-checked="false"
                                                            tabindex="0"><input  class="kt-switch__input digit"
                                                                id="checkbox-more" type="checkbox" tabindex="-1"
                                                                value="" autocomplete="off" onclick="openInput()">
                                                            <div class="kt-switch__button kt-switch__button--radio">
                                                            </div>
                                                            <div class="kt-switch__rippler">
                                                                <div class="kt-switch__ripple"></div>
                                                            </div>
                                                        </div><label class="kt-switch__label"
                                                            for="checkbox-more">موارد دیگر</label>
                                                           
                                                    </div>
                                                     <textarea id="more-txtarea" rows="4" cols="50" maxlength="100" style="display:none"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default reportbtn-me"
                                            data-dismiss="modal">انصراف</button>
                                        <button type="button" id="report_problem_btn" class="btn reportbtn-me">تایید</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                <div class="fl-wrap limit-box"></div>
                @if(isset($posts->Cmodel->intro))
                    <div class="col-md-12">
                        <div class="container text-warning text-right rtl" style="direction: rtl">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="fanni-title ">مشخصات فنی</h3>
                                    <div class="line-design">
                                        <div class="line-des"></div>
                                        <div class="line-des"></div>
                                        <div class="line-des"></div>
                                        <div class="line-des"></div>

                                    </div>
                                </div>
                                <div class="col-md-12 my-3">
                                    <div class="row">
                                        <div class="col-md-6 col-12 ">
                                            <a href="#" class="text-decoration-none">
                                                <div class="fanni-border-link">
                                                    <div class="brand-icon">
                                                        <img src="/brandIntro/{{$posts->Cbrand->country_img}}"
                                                            class="img-fluid Intro_img" alt="" />
                                                    </div>
                                                    <div class="fanni-link">
                                                        <p class="mr-4">{{$posts->Cbrand->country}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-12 ">
                                            <a href="#" class="text-decoration-none">
                                                <div class="fanni-border-link">
                                                    <div class="brand-icon" style="left: -103px;">
                                                        <img src="/brandIntro/{{$posts->Cbrand->brand_img}}"
                                                            class="img-fluid Intro_img" alt="" />
                                                    </div>
                                                    <div class="fanni-link"> 
                                                    <p>{{$posts->Cbrand->name}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon01.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> نوع موتور : </span>
                                            <span class="txt-fanni2">{{$posts->Cmodel->intro->engine_type}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon02.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> سیستم ترمز : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->brake}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon03.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> حجم موتور : </span>
                                            <span class="txt-fanni2">
                                              {{$posts->Cmodel->intro->engine_volume}} cc
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon04.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> نوع گیربکس : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->gearbox}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon05.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> نوع سوخت : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->fuel_type}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon06.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> قدرت موتور : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->engine_power}} اسب بخار
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon07.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> سیستم تعلیق : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->suspension}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon08.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> تعداد دنده : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->gear_count}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon09.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> تعداد سیلندر : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->cylinder_count}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon10.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> استاندارد آلایندگی : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->pollution}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon11.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> گشتاور : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->torque}} نیوتون متر
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 col-12 text-center line-fanni">
                                    <div class="row">
                                        <div class="img-icon col-md-2 col-4">
                                            <img src="{{ asset('/images/icons/icon12.png') }}" alt="" />
                                        </div>
                                        <div class="inner-fanni col-md-10 col-8 pr-0 text-right">
                                            <span class="txt-fanni1 ml-4"> سیستم سوخت رسانی : </span>
                                            <span class="txt-fanni2">
                                                {{$posts->Cmodel->intro->fuel_system}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <!--post-related-->
                    <div class="post-related fl-wrap">
                        <h6 class="comments-title text-right" style="color: #C19D60;">آگهی های مشابه</h6>
                        <!-- post-related -->
                        <div class=" row" style="direction: rtl">
                            @foreach ($related_posts as $post)

                            <div class="item-related col-md-4">
                                <a href="/advertises/show/{{$post['id']}}/{!! str_replace([' ' , '/'], '_', $post['subject']) !!}"><img src="/post_images/related_images_watermark/{{$post['image_path']}}" alt=""></a>
                                <h3><a href="/advertises/show/{{$post['id']}}/{!! str_replace([' ' , '/'], '_', $post['subject']) !!}">
                                    {{Str::words($post['subject'], $words = 4, $end = '...')}}
                                    
                                    </a></h3>
                                            <span class="post-date post-price" style="direction: rtl">
                                                             @if($post['price'] === null || $post['price'] === "0")
                                                @if($post['trending'] == 1)
                                                 
                                                    مایل به معاوضه
                                             
                                                    
                                                @else
                                                  
                                                    توافقی
                                               
                                                @endif
                                            @else
                                                
                                             
                                                    {{number_format((float)$post['price']) . "تومان"}}    
                                             
                                            @endif
                                            
                                            
                                                </span>
                            </div>

                            {{--<img src="/post_images/related_images_watermark/{{$image->path}}"
                            class="img-rounded" alt=""
                            style="width: 100%">--}}
                            @endforeach

                        </div>
                        <a href="{{$posts->is_rent === '0' ? '/advertises/all' : '/rent/all'}}" class="btn shop-btn float-left">
                                <i class="fa fa-arrow-left align-middle mr-2 ml-0"></i>
                                آگهی های بیشتر
                            </a>
                    </div>
                    <!-- post-related  end-->
                </div>
            </div>
        </div>
    </section>
    <!--  section end  -->
    <div class="brush-dec2 brush-dec_bottom"></div>
</div>
@endsection

@section('scripts')
    <script>
    function openInput() {
  // Get the checkbox
  var checkBox = document.getElementById("checkbox-more");
  // Get the output text
  var text = document.getElementById("more-txtarea");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
}

        $(document).ready(function () {
            
            var phone = "{{$posts->phone_number}}";

            $('#contact_phone').on('click', function () {
                $(this).text(phone);
                
                 $('#polic-alert').stop().slideDown();
           
            });

            $('.markup').on('click', function () {
                // console.log("salam")
                var markup = $(this);
                var post_id = $(this).data('id');
                // console.log(proposal_id)

                var data = {"post_id": post_id, '_token': "{{csrf_token()}}"};
                $.ajax({
                    url: '/posts/ajax/mark',
                    data: data,
                    method: 'post',
                    success: function (x) {
                        // console.log(x);

                        if (x === 'mark') {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">حذف نشان<i class="fa fa-bookmark mx-3"></i></a>`
                            )
                            // console.log(markup)

                        } else if (x === 'unmark') {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">نشان کردن <i class="fa fa-bookmark-o mx-3"></i></a>`
                            )
                        }
                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });
            
            $('#report_problem_btn').on('click', function () {
                
                var problem = $("input[name=customRadio]:radio:checked").closest('.kt-switch').find('.kt-switch__label').text();
                var post_id = "{{$posts->id}}";
                sessionStorage.setItem("report_problem", true);
                if($('#checkbox-more').is(':checked')){
                    
                    problem = $('#more-txtarea').val()
                }
                
                


                var data = {"content": problem, "post_id" : post_id , '_token': "{{csrf_token()}}"};
                $.ajax({
                    url: '/report/problem',
                    data: data,
                    method: 'post',
                    success: function (x) {
                        if(!x.auth){
                            $("#largeModal").modal('hide');
                            $('.show-rb').click();
                            
                        }
                        else{
                            
                                $('.alert_show').text(x.message);
                                $('.alert_show').show();
                                setTimeout(function(){ $('.alert_show').hide(); }, 3000);
                            
                            if(x.success){
                                setTimeout(function(){ $("#largeModal").modal('hide'); }, 2000);
                                
                            }
                            
                            
                            
                        }
                        

                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });
            
            
            $('.cookmark').on('click', function () {
                // console.log("set-cookie")
                var markup = $(this);
                var id = $(this).data('id');
                var base = 1; // page = customer_adv

                var data = {"id": id, "base": base, '_token': "{{csrf_token()}}"};
                $.ajax({
                    url: '/mark/cookie',
                    data: data,
                    method: 'post',
                    success: function (x) {
                        // console.log(x);

                        if (x.mark) {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">حذف نشان<i
                                                            class="fa fa-bookmark mx-3"></i></a>`
                            )
                        } else {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">نشان کردن <i
                                                        class="fa fa-bookmark-o mx-3"></i></a>`
                            )
                        }


                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });
            
            var d = "{{$posts->location}}"
            d = d.split(',')

            if(d[0] != ""){
                
            var map = L.map('maps_show', {
                center: [d[0],d[1]],
                zoom: 15,
                zoomControl: false
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ' 18charkh'
            }).addTo(map);


            var originIcon = L.icon({
                iconUrl: 'https://barokala.com/images/location_charkh.png',
                iconAnchor: [18, 26],
                labelAnchor: [-6, 0],
                popupAnchor: [0, -36],
                iconSize: [35, 35]
            });


            origin = L.marker([{{$posts->location}}], {icon: originIcon}).addTo(map);
                
            }

        });
         //Get the button
        var mybutton = document.getElementById("myBtn");

        var btn = $('#myBtn2');

        $(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

        btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

    </script>


@endsection
