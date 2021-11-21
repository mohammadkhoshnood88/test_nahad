@extends('layout.Main')

@section('content')
<div class="content">
    <!--  section  -->
    <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true">
        <div class="bg par-elem " data-bg="" data-scrollax="properties: { translateY: '30%' }">
        </div>
        <div class="overlay"></div>
        <div class="container"></div>
        <div class="hero-section-scroll">
            <div class="mousey">
                <div class="scroller"></div>
            </div>
        </div>
        <div class="brush-dec"></div>
    </section>
    <!--  section  end-->
    <!--  section  -->
    <section class="hidden-section">
        <div class="container">
            <div class="row" style="direction: ltr">
                <div class="col-md-8">
                    <div class="fl-wrap post-container">
                        <!-- post -->
                        <div class="post fl-wrap fw-post">
                            <div class="shop-header-title fl-wrap">
                                <h2 style="color: #C19D60;">
                                    {{$posts_ad->subject}}
                                </h2>
                                <div class="shop-header-title_opt">
                                    <ul>
                                        <li><span class="menu-single-preice">
                                                @if($posts_ad->is_rent == 0)
                                                    @if($posts_ad->trending == 1)
                                                        <strong>معاوضه</strong>
                                                        @else
                                                        <strong>{{$posts_ad->price === null || $posts_ad->price === "0" || $posts_ad->price === 0 ? "توافقی" : number_format((float)$posts_ad->price) . " تومان "}}
                                                </strong>
                                                @endif
                                                @endif
                                            </span>
                                        </li>

                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <!-- blog media -->
                            <div class="blog-media fl-wrap">
                                <div class="single-slider-wrap">
                                    <div class="single-slider fl-wrap">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper lightgallery">
                                                <!--<div class="swiper-slide hov_zoom">-->
                                                <!--    <img class="posts_img" src="/post_images/related_images_watermark/{{$posts_ad->image_path}}" alt="{{$posts_ad->subject}}">-->
                                                <!--    <a class="box-media-zoom popup-image">-->
                                                <!--        <i class="fal fa-search"></i>-->
                                                <!--    </a>-->
                                                <!--</div>-->
                                                @foreach ($images as $image)

                                                <div class="swiper-slide hov_zoom">
                                                    <img class="posts_img" src="/post_images/related_images_watermark/{{$image}}" alt="{{$posts_ad->subject}}">
                                                    <a href="/post_images/related_images_watermark/{{$image}}" class="box-media-zoom popup-image">
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
                            <!-- blog media end -->
                            <div class="blog-text fl-wrap">
                                <div class="pr-tags fl-wrap">
                                    <span> نوع خودرو : </span>
                                    <ul>
                                        <li><a>
                                                {{$posts_ad->type_name->name}}
                                            </a></li>
                                    </ul>
                                     <p class="mt-5" style="white-space: pre-line;">
                                                  {{$posts_ad->description}}
                                    </p>
                                </div>
                               
                            </div>
                             <div class="shop-item-footer  fl-wrap">
                                <div class="row justify-content-end" style="direction:rtl">
                                     <div class="col-6 col-md-3 text-center d-none d-md-block"  >
                                        <a href="/userpanel/post/{{$posts_ad->id}}/upgrade" class="btn diamond w-100 my-0">
                                       
                                            <i class="fa fa-diamond float-none mr-0 ml-2"></i>
                                           ارتقا</a>
                                    </div>
                                    <div class="col-6 col-md-3 text-center d-none d-md-block"  >
                                        <a 
                                        href="{{session()->get('cart') == null ? '/userpanel/myadvertises' : '/userpanel/financial/post/' . $posts_ad->id . '/cart' }}"
                                        class="btn btn_success w-100 text-center my-0" id="myclick">
                                                <i class="fa fa-check float-none mr-0 ml-2"></i>
                                                 تایید
                                         </a>
                                         
                                        <!-- <a href="/userpanel/myadvertises"-->
                                        <!--class="btn btn_success w-100 text-center my-0" id="myclick">-->
                                        <!--        <i class="fa fa-check float-none mr-0 ml-2"></i>-->
                                        <!--         تایید-->
                                        <!-- </a>-->
                                    </div>
                                    
                                </div>

                            </div>
                          
                           
                        </div>
                        <!--post-related-->

                        <!-- post-related  end-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--  sidebar  -->
                <div class="col-md-4">
                    <!-- main-sidebar -->
                    <div class="main-sidebar fixed-bar fl-wrap">

                        <div class="main-sidebar-widget fl-wrap">
                            <h3 style="color: #C19D60;">جزییات آگهی</h3>
                            <div class="category-widget">

                                <ul class="cat-item">
                                    @if($posts_ad->is_rent == 0)
                                    <li>
                                        <h5 class="d-inline-block mb-3">محل اگهی</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->State->name}} ، {{$posts_ad->City->name}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">نوع برند</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->cbrand_id ? $posts_ad->Cbrand->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">نوع مدل</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->cmodel_id ? $posts_ad->Cmodel->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">گیربکس </h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->gearbox_id ? $posts_ad->Gearbox->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">سلامت بدنه </h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->cbody_id ? $posts_ad->Cbody->name : 'موجود نیست' }}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">رنگ</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->color_id ? $posts_ad->Color->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">سال ساخت</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->year_id ? $posts_ad->Year->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">کارکرد</h5 class="d-inline-block mb-3">
                                        <p>{{ number_format($posts_ad->distance) }} &ensp; کیلومتر</p>
                                    </li>
                                    @if (isset($posts_ad->instagram_id))
                                    <li>
                                        <h5 class="d-inline-block mb-3">آیدی اینستاگرام</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->instagram_id}}</p>
                                    </li>
                                    @endif
                                    @if(isset($posts_ad->website))
                                   <li>
                                        <h5 class="d-inline-block mb-3">آدرس سایت</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->website}}</p>
                                    </li>
                                    @endif
                                    
                                    @else
                                    <li>
                                        <h5 class="d-inline-block mb-3">وضعیت راننده</h5 class="d-inline-block mb-3">
                                        <p>
                                        @if($posts_ad->driver_status == '1')
                                        
                                        
                                            با
                                            راننده
                                            {{$posts_ad->workers ? "همراه با $posts_ad->workers کارگر " : "بدون کارگر"}}
                                        
                                        @else
            
                                        {{$posts_ad->driver_status === '0'? "فرقی نمیکند" : ($posts_ad->driver_status == '2' ? "بدون راننده" : "")}}
                                        @endif
                                        </p>
                                    </li>
                                    @endif
                                    
                                    <li>
                                        <h5 class="d-inline-block mb-3">شماره تماس</h5 class="d-inline-block mb-3">
                                        <p>{{$posts_ad->phone_number}}</p>
                                    </li>
                                </ul>
                                <div class="category-widget">
                           
                                    <div class="shop-item-footer  fl-wrap">
                                        <div class="row justify-content-end" style="direction:rtl">
                                            <div class="col-6 text-center mb-2">
                                                <a class="btn btn_danger w-100 text-center my-0 destroy_post" id="myclick" data-id="{{$posts_ad->id}}">
                                                        <i class="fa fa-times float-none mr-0 ml-2"></i>
                                                         حذف
                                                 </a>
                                            </div>
                                            <div class="col-6 text-center mb-2">
                                                <a href="/userpanel/post/{{$posts_ad->id}}/edit" class="btn btn_edit w-100 my-0">
                                                    <i class="fa fa-edit float-none mr-0 ml-2"></i>
                                                   ویرایش</a>
                                            </div>
                                            <div class="col-6 col-md-3 text-center d-md-none mb-2">
                                                <a href="#" class="btn diamond w-100 my-0">
                                               
                                                    <i class="fa fa-diamond float-none mr-0 ml-2"></i>
                                                   ارتقا</a>
                                            </div>
                                            <div class="col-6 col-md-3 text-center d-md-none mb-2">
                                                <a href="{{session()->get('cart') == null ? '/userpanel/myadvertises' : '/userpanel/financial/post/' . $posts_ad->id . '/cart' }}" class="btn btn_success w-100 text-center my-0" id="myclick">
                                                        <i class="fa fa-check float-none mr-0 ml-2"></i>
                                                         تایید
                                                 </a>
                                                 
                                                
                                                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- main-sidebar-widget end-->
                        </div>
                        <!-- main-sidebar end-->
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

<script>
    $(document).ready(function () {
        $('.destroy_post').on('click', function () {
            var id = $(this).data("id");
                $.ajax({
                    url: '/userpanel/post/destroy',
                    data: {"id": id, '_token': "{{csrf_token()}}"},
                    method: 'post',
                    success: function (x) {
                        console.log(x);
                        if (x.success) {

                            alert("آگهی حذف شد");
                            window.location.replace("/userpanel/myadvertises");
                            return;

                        }
                    },

                });
        });

    });

</script>

@endsection