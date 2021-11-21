@extends('layout.Main')

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
                <div class="row" style="direction: rtl;">
                    <!--  sidebar  -->
                    <div class="col-md-3">
                        <!-- main-sidebar -->
                        <div class="main-sidebar fixed-bar fl-wrap">
                            <!-- main-sidebar-widget-->
                            <div class="main-sidebar-widget fl-wrap">
                                <div class="search-widget fl-wrap">
                                    <form method="get">
                                        <button class="search-submit color-bg" id="submit_btn"><i
                                                    class="fa fa-search"></i>
                                        </button>
                                        <input name="term" id="term" type="text" class="search-inpt-item"
                                               placeholder="جستجو.."
                                              style="text-align: right"/>

                                    </form>
                                </div>
                            </div>

                            <div class="main-sidebar-widget fl-wrap">
                                <h3>فیلترها </h3>
                                <form method="get">
                            <div class="recent-post-widget">
                                <div class="shop-header_opt">
                                    <select id="state_id" data-placeholder="Persons" name="state"
                                        class="list_dropdown">
                                        <option class="list_dropdown_option">انتخاب استان</option>

                                        @foreach ($states as $s)
                                            <option class="list_dropdown_option" value="{{ $s->id }}">{{ $s->name}}</option>
                                        @endforeach
                                       
                                    </select>
                                </div>
                                <div class="shop-header_opt">
                                    <select id="city_id" name="city"
                                        class="list_dropdown">
                                        <option class="list_dropdown_option">انتخاب شهر</option>
                                    </select>
                                </div>
                           
                            <div class="form-group">
                                
                                <button type="submit" id="btn-filter" class="btn btn-success btn-block">اعمال
                                    فیلتر
                                </button>
                                
                            </div>

                        </div>
                        </form>
                            </div>


                        </div>
                        <!-- main-sidebar end-->
                    </div>
                    <!--  sidebar end-->
                    <div class="col-md-9" style="text-align: -webkit-center;place-content: center;">
                    <div class="fl-wrap post-container">
                        <div class="shop-header fl-wrap">
                            <h4 style="float:right"><span></span>تعداد لوکس فروشی ها :{{$count}}</h4>
                        </div>

                        @if($count == 0)
                            <h4 style="text-align: center;color: white; margin:20px;">فروشگاه لوازم یدکی موجود نیست</h4>
                            <h6 style="text-align: center;color: yellowgreen;margin-top:15px;">با 18 چرخ تماس بگیرید و فروشگاه خود را اینجا معرفی کنید</h6>
                        @endif

                        <!-- gallery start -->                        
                    </div>
                    <div class="row">
                        @foreach($data as $lux)
                            <div class="col-md-4 p-2 my-2" >
                                <div class="card card-me" >
                                    <div class="card-img">
                                        <div class="grid-item-holder" style="height: 100%">
                                            <a href=""alt=""></a> <img class="img-sellCard-me" src="/post_images/related_images_watermark/{{$lux->main_img}}">
                                        </div>
                                    </div>
                                    <div class="card-body text-right pt-2 p-0">
                                        <div class="title title-me p-2 m-2">
                                            <h5 class="">{{$lux->name}}</h5>
                                        </div>
                                        <div class="sub-title">
                                            <p class="mt-3 p-0"> <span style="color:#f2bd2b;padding:2px 0" class="mx-1 px-2"><i class="fa fa-phone fa-rotate-270 ml-2"></i> شماره تماس : </span>{{$lux->phone_number ? $lux->phone_number: "موجود نیست"}}</p>
                                            <p>
                                                <span style="color:#f2bd2b;" class="mx-1 px-2"><i class="fa fa-map-marker ml-2"></i> آدرس: </span>
                                                <span>{{$lux->address ? $lux->address : "موجود نیست"}}</span>
                                            </p>
                                        </div>
                                    </div>                                          
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {


            $('#state_id').on('change', function () {
                var stateId = $(this).val();
                $('.state_id').val(stateId);
                $("#city_id").html('<option value="">شهر مورد نظر را وارد نمایید</option>');
                if (stateId == "")
                    return;

                var pdata = {"stateId": stateId};
                $.ajax({
                    url: '/posts/getCity',
                    data: pdata,
                    method: 'post',
                    success: function (x) {
                        console.log(x);
                        var options = "";
                        var cities_item = "";
                        x.data.forEach(op => {
                            options += `<option class="list_dropdown_option" value='${op.id}'>${op.name}</option>`
                            cities_item += `<li class="option" data-value='${op.id}'>${op.name}</li>`
                        });

                        // console.log(li)

                        $('#city_id').append(`<option class="list_dropdown_option" >شهر را انتخاب کنید</option>`);
                        $('#city_id').append(options);
                        $('#city_id').closest('.shop-header_opt').find('.list').empty();
                        $('#city_id').closest('.shop-header_opt').find('.list').append(`<li class="option">شهر را انتخاب کنید</li>`);
                        $('#city_id').closest('.shop-header_opt').find('.list').append(cities_item);
                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });

            $('#city_id').on('change', function () {
                var city = $(this).val();
                $('.city_id').val(city);
            })

        });

        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                $('.navTrigger').addClass('affix_trigger');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
                $('.navTrigger').removeClass('affix_trigger');
            }
        });
        $('.navTrigger').click(function () {
            $(this).toggleClass('active');
            console.log("Clicked menu");
            $("#mainListDiv").toggleClass("show_list");
            $("#mainListDiv").fadeIn();

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
