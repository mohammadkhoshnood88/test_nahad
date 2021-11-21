@extends('layout.Main')

@section('content')
<div class="content">

    <!--  section  -->
    <section class="hidden-section">
        <div class="container pt-5">
            <div class="row" style="direction: ltr">
                <div class="col-md-8">
                    <div class="fl-wrap post-container">
                        <!-- post -->
                        <div class="post fl-wrap fw-post">
                            <div class="shop-header-title fl-wrap">
                                <h2 style="color: #C19D60;">
                                    {{$request['subject']}}
                                </h2>
                                <div class="shop-header-title_opt">
                                    <ul>
                                        <li><span class="menu-single-preice">

                                                        <strong>تبلیغاتی</strong>
                                                      
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

                                                @if(empty($request['images'][0]))
                                                
                                                <div class="swiper-slide hov_zoom">
                                                    <img class="posts_img" src="/post_images/related_images_watermark/noimage.jpg" alt="{{$request['subject']}}">
                                                    <a href="/post_images/related_images_watermark/noimage.jpg" class="box-media-zoom popup-image">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </div>
                                                
                                                @endif
                                                
                                                @foreach ($request['images'] as $image)
                                                @if(isset($image))

                                                <div class="swiper-slide hov_zoom">
                                                    <img class="posts_img" src="/post_images/related_images_watermark/{{$image}}" alt="{{$request['subject']}}">
                                                    <a href="/post_images/related_images_watermark/{{$image}}" class="box-media-zoom popup-image">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </div>
                                                @endif
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
                                    <span> نام فروشگاه : </span>
                                    <ul>
                                        <li><a style="color: #F2BD2B !important">
                                                {{$request['owner_name']}}
                                            </a></li>
                                    </ul>
                                     <p class="mt-5" style="white-space: pre-line;">
                                                  {{$request['description']}}
                                    </p>
                                </div>
                               
                            </div>
                             <div class="shop-item-footer  fl-wrap">
                                <div class="row justify-content-end" style="direction:rtl">
                                     <div class="col-6 col-md-3 text-center d-none d-md-block"  >
                                        <a href="/userpanel/accessory/{{$request['id']}}/upgrade" class="btn diamond w-100 my-0">
                                       
                                            <i class="fa fa-diamond float-none mr-0 ml-2"></i>
                                           ارتقا</a>
                                    </div>
                                    <div class="col-6 col-md-3 text-center d-none d-md-block"  >
                                        <a 
                                        href="/userpanel/lateral"
                                        class="btn btn_success w-100 text-center my-0" id="myclick">
                                                <i class="fa fa-check float-none mr-0 ml-2"></i>
                                                 تایید
                                         </a>
                                         
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

                                    <li>
                                        <h5 class="d-inline-block mb-3">محل اگهی</h5 class="d-inline-block mb-3">
                                        <p>{{city_name_old($request['city_id'])}} ، {{state_name($request['state_id'])}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">نام مالک</h5 class="d-inline-block mb-3">
                                        <p>{{$request['owner_name']}}</p>
                                    </li>
                                    <li>
                                        <h5 class="d-inline-block mb-3">شماره تماس مالک </h5 class="d-inline-block mb-3">
                                        <p>{{$request['phone_number']}}</p>
                                    </li>

                                    @if (isset($request['instagram_id']))
                                    <li>
                                        <h5 class="d-inline-block mb-3">آیدی اینستاگرام</h5 class="d-inline-block mb-3">
                                        <p>{{$request['instagram_id']}}</p>
                                    </li>
                                    @endif
                                    @if(isset($request['website']))
                                   <li>
                                        <h5 class="d-inline-block mb-3">آدرس سایت</h5 class="d-inline-block mb-3">
                                        <p>{{$request['website']}}</p>
                                    </li>
                                    @endif
                                    
                                    <li>
                                        <h5 class="d-block mb-2">آدرس</h5>
                                        <p class="mb-3">{{$request['address']}}</p>
                                    </li>
                                    
                                </ul>
                                <div class="category-widget">
                           
                                    <div class="shop-item-footer  fl-wrap">
                                        <div class="row justify-content-end" style="direction:rtl">
                                            <div class="col-6 text-center mb-2">
                                                <a class="btn btn_danger text-white w-100 text-center my-0 destroy_post" id="myclick" data-id="{{$request['id']}}">
                                                        <i class="fa fa-times float-none mr-0 ml-2"></i>
                                                         حذف
                                                 </a>
                                            </div>
                                            <div class="col-6 text-center mb-2">
                                                <a href="/userpanel/accessory/{{$request['id']}}/edit" class="btn btn_edit text-white w-100 my-0">
                                                    <i class="fa fa-edit float-none mr-0 ml-2"></i>
                                                   ویرایش</a>
                                            </div>
                                            <div class="col-6 col-md-3 text-center d-md-none mb-2">
                                                <a href="#" class="btn diamond w-100 my-0">
                                               
                                                    <i class="fa fa-diamond float-none mr-0 ml-2"></i>
                                                   ارتقا</a>
                                            </div>
                                            <div class="col-6 col-md-3 text-center d-md-none mb-2">
                                                <a href="/userpanel/lateral" class="btn btn_success w-100 text-center my-0" id="myclick">
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
                    url: '/userpanel/accessory/destroy',
                    data: {"id": id, '_token': "{{csrf_token()}}"},
                    method: 'post',
                    success: function (x) {
                        console.log(x);
                        if (x.success) {

                            alert("آگهی حذف شد");
                            window.location.replace("/userpanel/lateral");
                            return;

                        }
                    },

                });
        });

    });

</script>

@endsection