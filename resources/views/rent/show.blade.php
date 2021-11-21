@extends('layout.Main')

@section('content')
<div class="content">
    <!--  section  -->
    <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true">
        <div class="bg par-elem " data-bg="{{asset('/images/bg/18.jpg')}}"
            data-scrollax="properties: { translateY: '30%' }">
        </div>
        <div class="overlay"></div>
        <div class="container">
<div class="section-title">
                <h2>مشخصات آگهی مورد نظر</h2>
                <div class="dots-separator fl-wrap"><span></span></div>
            </div>
        </div>
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
            <div class="row">
                <div class="col-md-8">
                    <div class="fl-wrap post-container">
                        <!-- post -->
                        <div class="post fl-wrap fw-post">
                            <div class="shop-header-title fl-wrap">
                                <h2>{{$posts->subject}}</h2>
                                <div class="shop-header-title_opt">
                                    <ul>
                                        <li><span class="menu-single-preice">قیمت:
                                                <strong>140000</strong></span></li>
                                        <li>
                                            <div class="menu-single_rating">
                                                <span>نشان کردن </span>
                                                <div class="star-rating" data-starrating="5"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- blog media -->
                            <div class="blog-media fl-wrap">
                                <div class="single-slider-wrap">
                                    <div class="product-slider fl-wrap">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper lightgallery">

                                                @foreach ($images as $image)

                                                <div class="swiper-slide hov_zoom"><img
                                                        src="/post_images/related_images_watermark/{{$image->path}}"
                                                        alt="related_images_watermark"><a class="box-media-zoom   popup-image"><i
                                                            class="fa fa-search"></i></a></div>

                                                @endforeach


                                            </div>
                                            <div class="ss-slider-pagination"></div>
                                            <div class="ss-slider-cont ss-slider-cont-prev"><i
                                                    class="fa fa-caret-left"></i></div>
                                            <div class="ss-slider-cont ss-slider-cont-next"><i
                                                    class="fa fa-caret-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- blog media end -->
                            <div class="blog-text fl-wrap">
                                <div class="pr-tags fl-wrap">
                                    <span> نوع خودرو : </span>
                                    <ul>
                                        <li><a href="#">{{$posts->type_name()}}</a></li>
                                    </ul>
                                </div>
                                <p style="white-space: pre-line;">
                                    {{$posts->description}}
                                </p>
                            </div>
                            <div class="shop-item-footer fl-wrap">
                                <ul class="post-counter">
                                    <li><i class="far fa-eye"></i><span>567</span></li>
                                    <li><i class="fal fa-shopping-bag"></i><span>256</span></li>
                                </ul>
                            </div>
                        </div>
                        <!--post-related-->
                        <div class="post-related fl-wrap">
                            <h6 class="comments-title">آگهی های مشابه</h6>
                            <!-- post-related -->
                            <div class=" row">
                                @foreach ($related_posts as $post)

                                <div class="item-related col-md-4">
                                    <a href="#"><img src="/post_images/related_images_watermark/{{$post['image_path']}}"
                                            alt="related_images_watermark"></a>
                                    <h3><a href="#">{{$post['subject']}}</a></h3>
                                    <span class="post-date post-price">436668788</span>
                                </div>

                                {{--<img src="/post_images/related_images_watermark/{{$image->path}}"
                                class="img-rounded" alt="related_images_watermark"
                                style="width: 100%">--}}
                                @endforeach


                            </div>
                        </div>
                        <!-- post-related  end-->
                    </div>
                    <div class="clearfix"></div>
                    <div class="bold-separator bold-separator_dark"><span></span></div>
                    <div class="clearfix"></div>
                    <a href="/rent/all" class="btn  shop-btn">آگهی های بیشتر<i class="fal fa-long-arrow-right"></i></a>
                </div>
                <!--  sidebar  -->
                <div class="col-md-4">
                    <!-- main-sidebar -->
                    <div class="main-sidebar fixed-bar fl-wrap">

                        <div class="main-sidebar-widget fl-wrap">
                            <h3>جزییات آگهی</h3>
                            <div class="category-widget">
                                <ul class="cat-item">
                                    <li>
                                        <h4>محل اگهی</h4>
                                        <p>{{$posts->State->name}} ، {{$posts->City->name}}</p>
                                    </li>
                                    <li>
                                        <h4>نوع برند</h4>
                                        <p>{{$posts->cbrand_id ? $posts->Cbrand->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h4>نوع مدل</h4>
                                        <p>{{$posts->cmodel_id ? $posts->Cmodel->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h4>گیربکس </h4>
                                        <p>{{$posts->gearbox_id ? $posts->Gearbox->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h4>سلامت بدنه </h4>
                                        <p>{{$posts->cbody_id ? $posts->Cbody->name : 'موجود نیست' }}</p>
                                    </li>
                                    <li>
                                        <h4>رنگ</h4>
                                        <p>{{$posts->color_id ? $posts->Color->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h4>سال ساخت</h4>
                                        <p>{{$posts->year_id ? $posts->Year->name : 'موجود نیست'}}</p>
                                    </li>
                                    <li>
                                        <h4>کارکرد</h4>
                                        <p>{{ number_format($posts->distance) }} &ensp; کیلومتر</p>
                                    </li>
                                    <li>
                                        <h4>شماره تماس</h4>
                                        <p>6622114455</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="category-widget">
                                <div class="menu-single_rating my-3">


                                    <div class="markup" data-id="{{$posts->id}}">
                                        @if(\Illuminate\Support\Facades\Session::get('login') && session()->get('driver'))
                                            @if(empty($mark))
                                                <a class="btn success text-center">نشان کردن <i
                                                        class="fa fa-bookmark-o mx-3"></i></a>
                                            @else
                                                <a class="btn success text-center">حذف نشان<i
                                                        class="fa fa-bookmark mx-3"></i></a>
                                            @endif
                                        @else
                                            <a class="btn success text-center">نشان کردن <i
                                                    class="fa fa-bookmark-o mx-3"></i></a>
                                        @endif

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

            $('.markup').on('click', function () {
                
                var markup = $(this);
                var post_id = $(this).data('id');
                

                var data = {"post_id": post_id, '_token': "{{csrf_token()}}"};
                $.ajax({
                    url: '/posts/ajax/mark',
                    data: data,
                    method: 'post',
                    success: function (x) {
                       

                        if (x === 'mark') {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">حذف نشان<i class="fa fa-bookmark mx-3"></i></a>`
                            )
                            

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

        });

    </script>
@endsection
