@extends('layout.Main')

@section('style')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin="" />

<style>
    .leaflet-popup-content-wrapper {
        background: linear-gradient(60deg, yellowgreen, greenyellow);
    }

    .leaflet-popup-content-wrapper .leaflet-popup-content {}

    .leaflet-popup-tip-container {
        dots-separator fl-wrap
    }

    #contact_phone {
        cursor: pointer;
    }

    #contact_phone:hover {
        cursor: pointer;
        color: #C19D60;
    }
</style>

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>


@endsection

@section('content')
<div class="content">
    <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
    <a id="myBtn2"></a>
    <section class="hidden-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="fl-wrap post-container">
                        <!-- post -->
                        <div class="post fl-wrap fw-post">
                            <div class="shop-header-title fl-wrap">
                                <h2 style="color: #C19D60;">{{$insurance->subject}}</h2>
                                <div class="shop-header-title_opt w-100">
                                    <span class="menu-single-preice">نوع آگهی :
                                        <strong class="animate__animated animate__flash animate__slow animate__infinite">
                                            تبلیغاتی
                                        </strong>
                                    </span>
                                    <span style="color: #fff; font-size: 15px; float: left;">
                                        تاریخ انتشار:
                                    
                                        {{\Morilog\Jalali\Jalalian::forge($insurance->created_at)->format('Y/m/d')}}

                                    </span>
                                </div>
                            </div>
                            <div class="blog-media fl-wrap">
                                <div class="single-slider-wrap">
                                    <div class="single-slider fl-wrap">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper lightgallery">

                                                @foreach ($insurance->images as $image)

                                                <div class="swiper-slide">
                                                    <img class="posts_img"
                                                        src="/post_images/related_images_watermark/{{$image->path}}"
                                                alt="{{$insurance->subject}}">
                                                <a href="/post_images/related_images_watermark/{{$image->path}}"
                                                    class="box-media-zoom popup-image">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>

                                            @endforeach

                                        </div>
                                        <div class="ss-slider-pagination"></div>
                                        <div class="ss-slider-cont ss-slider-cont-prev"><i class="fa fa-caret-left"></i>
                                        </div>
                                        <div class="ss-slider-cont ss-slider-cont-next"><i
                                                class="fa fa-caret-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="blog-text fl-wrap">
                            <div class="pr-tags fl-wrap">
                                <span> نام فروشگاه : </span>
                                <p class="fori-me">
                                    {{$insurance->name}}
                                </p>
                            </div>
                            <p style="white-space: pre-line;">
                                {{$insurance->description}}
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="bold-separator bold-separator_dark"><span></span></div>
                        <div class="clearfix"></div>
                        @if($insurance->location != null)
                        <div class="col-sm-12 mb-5">
                            <div class="map" id="maps_show">
                                مپ
                            </div>
                        </div>
                        @endif
                        <div class="shop-item-footer fl-wrap">
                            <div class="col-md-12">
                                <div class="row" style="direction:rtl">
                                    <div class="col-md-4 mb-3">
                                        <ul class="post-counter float-md-right">
                                            <li><i class="fa fa-eye"></i><span class="mr-2">{{count($insurance->visits)}}</span>
                                            </li>
                                            <li><i class="fa fa-shopping-bag"></i><span class="mr-2">256</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-8 mt-2">
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
                                <li>
                                    <h5 class="d-inline-block mb-3">محل اگهی</h5>
                                    <p>
                                        {{$insurance->state->name}} , {{$insurance->city->name}}
                                        </p>
                                </li>
                                <li>
                                    <h5 class="d-inline-block mb-3">نام مالک</h5>
                                    <p>{{$insurance->owner_name}}</p>
                                </li>
                                <li>
                                    <h5 class="d-inline-block mb-3">آیدی اینستاگرام</h5>
                                    @if(isset($insurance->instagram_id))
                                        <p>{{$insurance->instagram_id}}</p>
                                    @else
                                        <img src="{{asset('/images/icons/unseen_instagram.png')}}" class="float-left" />
                                    @endif
                                </li>
                                <li>
                                    <h5 class="d-inline-block mb-3">آدرس سایت</h5>
                                    
                                    @if(isset($insurance->website))
                                        <p>{{$insurance->website}}</p>
                                    @else
                                        <img src="{{asset('/images/icons/unseen_site.png')}}" class="float-left" />
                                    @endif
                                    
                                </li>
                                <li>
                                    <h5 class="d-block mb-2">آدرس</h5>
                                    <p class="mb-3">{{$insurance->address}}</p>
                                </li>
                                <li>
                                    <h5 class="d-inline-block mb-3">شماره تماس</h5>

                                    @if(count($insurance->tels) > 0)
                                        <p id="contact_phone">{{substr_replace($insurance->phone_number, '****', 4, 4)}}</p>
                                    @else
                                        <img src="{{asset('/images/icons/unseen_phone.png')}}" class="float-left" />
                                    @endif
                                </li>

                                <li id="polic-alert">
                                    <div class="alert alert-info py-3 px-4 " style="direction:rtl;font-size:15px"
                                        role="alert">
                                        <span class="font-weight-bold" style="background:transparent !important;">هشدار
                                            پلیس</span>

                                        لطفا پیش از انجام معامله و هر نوع پرداخت وجه، از صحت خدمات ارائه شده، به
                                        صورت حضوری اطمینان حاصل نمایید .
                                    </div>
                                </li>
                            </ul>
                            <div class="category-widget">
                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#largeModal">گزارش
                                    مشکل آگهی</a>
                               <div class="menu-single_rating d-inline-block my-3 mx-2">

                                    <div class="markup" data-id="{{$insurance->id}}">
                                @if(empty($mark))
                                    <a class = "btn success text-center">نشان کردن <i class="fa fa-bookmark-o mx-3"></i></a>
                                @else
                                    <a class = "btn success text-center">حذف نشان<i class="fa fa-bookmark mx-3"></i></a>
                                @endif

                                    </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-modal="true"
    style="margin: 85px 0;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">گزارش مشکل آگهی</h4>
                <button type="button" class="close close-switch" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="kt-modal__contents">
                    <div class="kt-modal__body kt-modal__body--actionable" style=" text-align: right;direction: rtl;">
                        <h5 class="post-report-modal__title kt-title kt-title--xs">دقیقاً چه
                            مشکلی وجود دارد؟<h5>
                                <p class="post-report-modal__description kt-body kt-body--sm" style="color: #000; font-size: 14px;">نزدیک ترین
                                    گزینه را انتخاب کنید.</p>

                                <p style="display:none" class="alert_show alert alert-primary">
                                    alert_show</p>
                                <div>
                                    <div class="kt-switch"
                                        style="display: flex;display: inline-flex;align-items: center;min-height: 2.5rem;">
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input name="customRadio" class="kt-switch__input digit"
                                                id="radio-radio-19dk4pa" type="radio" tabindex="-1" value=""
                                                autocomplete="off">
                                            <div class="kt-switch__button kt-switch__button--radio">
                                            </div>
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
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input name="customRadio" class="kt-switch__input digit"
                                                id="radio-radio-17mnonm" type="radio" tabindex="-1" value=""
                                                autocomplete="off">
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
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input name="customRadio" class="kt-switch__input digit"
                                                id="radio-radio-27b00jh" type="radio" tabindex="-1" value=""
                                                autocomplete="off">
                                            <div class="kt-switch__button kt-switch__button--radio">
                                            </div>
                                            <div class="kt-switch__rippler">
                                                <div class="kt-switch__ripple"></div>
                                            </div>
                                        </div>
                                        <label class="kt-switch__label" for="radio-radio-27b00jh">اطلاعات
                                            تماس</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="kt-switch">
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input name="customRadio" class="kt-switch__input digit"
                                                id="radio-radio-241fhl0" type="radio" tabindex="-1" value=""
                                                autocomplete="off">
                                            <div class="kt-switch__button kt-switch__button--radio">
                                            </div>
                                            <div class="kt-switch__rippler">
                                                <div class="kt-switch__ripple"></div>
                                            </div>
                                        </div>
                                        <label class="kt-switch__label" for="radio-radio-241fhl0">قیمت</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="kt-switch">
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input name="customRadio" class="kt-switch__input digit"
                                                id="radio-radio-282n9ol" type="radio" tabindex="-1" value=""
                                                autocomplete="off">
                                            <div class="kt-switch__button kt-switch__button--radio">
                                            </div>
                                            <div class="kt-switch__rippler">
                                                <div class="kt-switch__ripple"></div>
                                            </div>
                                        </div><label class="kt-switch__label" for="radio-radio-282n9ol">کلاهبرداری،
                                            جرم</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="kt-switch">
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input name="customRadio" class="kt-switch__input digit"
                                                id="radio-radio-273obip" type="radio" tabindex="-1" value=""
                                                autocomplete="off">
                                            <div class="kt-switch__button kt-switch__button--radio">
                                            </div>
                                            <div class="kt-switch__rippler">
                                                <div class="kt-switch__ripple"></div>
                                            </div>
                                        </div><label class="kt-switch__label" for="radio-radio-273obip">ناموجود بودن
                                            مورد آگهی</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="kt-switch">
                                        <div class="kt-switch__cell" role="radio" aria-checked="false" tabindex="0">
                                            <input class="kt-switch__input digit" id="checkbox-more" type="checkbox"
                                                tabindex="-1" value="" autocomplete="off" onclick="openInput()">
                                            <div class="kt-switch__button kt-switch__button--radio">
                                            </div>
                                            <div class="kt-switch__rippler">
                                                <div class="kt-switch__ripple"></div>
                                            </div>
                                        </div><label class="kt-switch__label" for="checkbox-more">موارد
                                            دیگر</label>

                                    </div>
                                    <textarea id="more-txtarea" rows="4" cols="50" maxlength="100"
                                        style="display:none"></textarea>
                                </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mx-auto">
                <button type="button" class="btn btn-default reportbtn-me" data-dismiss="modal">انصراف</button>
                <button type="button" id="report_problem_btn" class="btn reportbtn-me">تایید</button>
            </div>
        </div>
    </div>

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
            
            var phone = "{{$insurance->phone_number}}";

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
                    url: '/insurance/ajax/mark',
                    data: data,
                    method: 'post',
                    success: function (x) {
                        console.log(x);
                        
                        if(!x.auth){
                            $('.show-rb').click();
                        }
                        else
                        {
                            
                        if (x.mark) {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">حذف نشان<i class="fa fa-bookmark mx-3"></i></a>`
                            )

                        } else {
                            markup.children().remove();
                            markup.append(
                                `<a class="btn success text-center">نشان کردن <i class="fa fa-bookmark-o mx-3"></i></a>`
                            )
                        }
                            
                        }
                    
                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });
            
            $('#report_problem_btn').on('click', function () {
                
                var problem = $("input[name=customRadio]:radio:checked").closest('.kt-switch').find('.kt-switch__label').text();
                var post_id = "{{$insurance->id}}";
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
            
            var d = "{{$insurance->location}}"
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


            origin = L.marker([{{$insurance->location}}], {icon: originIcon}).addTo(map);
                
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