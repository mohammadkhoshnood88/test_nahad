@extends('layout.Main')

@section('header')
    پنل ادمین| ثبت آگهی فروش
@endsection

@section('ownpage_meta')
    <meta name="description" content="18 ﭼﺮخ ﺛﺒﺖ آﮔﻬﯽ ﻓﺮوش اﻧﻮاع"ﻣﺎﺷﯿﻦ ﺳﻨﮕﯿﻦ" ﮐﺸﻨﺪه/ﮐﺎﻣﯿﻮﻧﺖ/ﺗﺮﯾﻠﺮ/ﮐﺎﻣﯿﻮن 911 ﺻﻔﺮ و ﮐﺎرﮐﺮده ﻧﻘﺪ و اﻗﺴﺎﻃﯽ ﻣﯽ ﺑﺎﺷﺪ.">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H8RBEDDD1D"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-H8RBEDDD1D');
    </script>

@endsection

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
        
        .opacity {
            opacity: 0.4;
        }
    </style>


    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

@endsection


@section('content')
    <div class="content">

        <!--  section  -->
        <section class="hidden-section pt-5" style="overflow: unset">
            <div class="container pt-5">
                <!-- CHECKOUT TABLE -->
                <div class="row pt-5">
                    <div class="col-md-8 pt-5" style="direction: rtl">
                        <div class="check-out_wrap fl-wrap">
                            <h4 class="cart-title">مشخصات خودرو</h4>
                            <form class="needs-validation custom-form" novalidate action="{{url('/admin/store/new_post')}}" method="POST">

                                @csrf

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="type" id="type" data-placeholder="Persons"
                                                        class="chosen-select no-search-select" required>
                                                    <option value="">نوع خودرو</option>
                                                    @foreach($types as $type)
                                                        <option {{old('type') == $type->id ? 'selected' : ''}}
                                                                value="{{$type->id}}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    نوع خودرو را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="cbrand_id" id="cbrand_id" data-placeholder="Persons"
                                                        class="chosen-select no-search-select" required>
                                                    <option value="">برند</option>
                                                    @foreach($cbrands as $cbrand)
                                                        <option {{old('cbrand_id') == $cbrand->id ? 'selected' : ''}}
                                                                value="{{$cbrand->id}}">{{ $cbrand->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    برند خودرو خود را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="cmodel_id" id="cmodel_id"
                                                        class="list_dropdown" required>
                                                    <option value="">مدل</option>
                                                    @if(old('cmodel_id'))
                                                        <option class="list_dropdown_option"
                                                                value="{{old('cmodel_id')}}" selected>
                                                            {{model_name_old(old('cmodel_id'))}}</option>
                                                    @else
                                                        <option class="list_dropdown_option" value="">مدل</option>
                                                    @endif
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    مدل خودرو خود را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="year_id" id="year_id" data-placeholder="Persons"
                                                        class="chosen-select no-search-select" required>
                                                    <option value="">سال ساخت</option>
                                                    @foreach($years as $year)
                                                        <option {{old('year_id') == $year->id ? 'selected' : ''}}
                                                                value="{{$year->id}}">{{ $year->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    سال ساخت خودرو خود را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="gearbox_id" id="gearbox_id" data-placeholder="Persons"
                                                        class="chosen-select no-search-select" required>
                                                    <option value="">نوع گیربکس</option>
                                                    @foreach($gearboxes as $gearbox)
                                                        <option {{old('gearbox_id') == $gearbox->id ? 'selected' : ''}}
                                                                value="{{$gearbox->id}}">{{ $gearbox->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    نوع گیربکس خودرو خود را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="cbody_id" id="cbody_id" data-placeholder="Persons"
                                                        class="chosen-select no-search-select" required>
                                                    <option value="">وضعیت بدنه</option>
                                                    @foreach($cbodies as $cbody)
                                                        <option {{old('cbody_id') == $cbody->id ? 'selected' : ''}}
                                                                value="{{$cbody->id}}">{{ $cbody->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    وضعیت بدنه خودرو خود را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="color_id" id="color_id"
                                                        class="chosen-select no-search-select" required>
                                                    <option value="">رنگ خودرو</option>
                                                    @foreach($colors as $color)
                                                        <option {{old('color_id') == $color->id ? 'selected' : ''}}
                                                                value="{{$color->id}}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    رنگ خودرو خود را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="distance" name="distance" placeholder="کارکرد (کیلومتر) *"
                                                   value="{{old('distance')}}" required>
                                                    <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation mx-2"></i>
                                                    میزان کارکرد خودرو خود را وارد نمایید
                                                </div>
                                            <p id="distance_convert" style="direction: rtl"></p>
                                        </div>
                                        <div class="devided"></div>
                                        
                                        <div class="col-12">
                                            <h4 class="cart-title">
                                                مشخصات اینترنتی <small>(توجه: وارد کردن اطلاعات در این قسمت دارای هزینه می باشد)</small>
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="insta" name="instagram_id" class="address"
                                                   placeholder="آیدی اینستاگرام" >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="site" name="website" class="address"
                                                   placeholder="آدرس وب سایت" >
                                        </div>
                                        <div class="devided"></div>
                                        <div class="col-sm-12">
                                            <h4 class="cart-title">قیمت و مشخصات فردی</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="price_type" id="price_type" data-placeholder="Persons"
                                                        class="chosen-select no-search-select" required>
                                                    <option>نحوه معامله</option>
                                                    <option value="agreed">توافقی</option>
                                                    <option value="trending">معاوضه</option>
                                                    <option value="price">نقدی</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="price" name="price" name="onlynumbers"
                                                   placeholder="قیمت پیشنهادی ( به تومان )"
                                                   value="{{old('price')}}">
                                            <p id="price_convert" style="direction: rtl"></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="col-sm-12 p-0">
                                                        <input type="text" id="subject" name="subject" maxlength="190"
                                                               placeholder="عنوان آگهی *" value="{{old('subject')}}" required>
                                                            <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                                <i class="fa fa-exclamation ml-2"></i>
                                                                عنوان آگهی اجباری می باشد
                                                            </div>
                                                    </div>
                                                    <div class="col-sm-12 p-0">
                                                        <input type="text" id="phone_number" name="phone_number"
                                                               placeholder="شماره تلفن *"
                                                               value="{{old('phone_number')}}" required> 
                                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                                    <i class="fa fa-exclamation ml-2"></i>
                                                                    وارد کردن شماره تماس اجباری است
                                                                </div>
                                                                <div class="text-danger check-phone d-none text-right pr-2" style="font-size: 15px">
                                                                    <i class="fa fa-exclamation ml-2"></i>
                                                                    شماره تماس وارد شده درست نمی باشد
                                                                </div>
                                                    </div>
                                                    <div class="col-sm-12 p-0">
                                                        <input type="email" id="email" name="email"
                                                               placeholder="ایمیل ( اختیاری )" value="">
                                                               <div class="text-danger check-email d-none text-right pr-2" style="font-size: 15px">
                                                                    <i class="fa fa-exclamation ml-2"></i>
                                                                    ایمیل وارد شده معتبر نمی باشد
                                                                </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                <textarea id="description" name="description" cols="30"rows="10" placeholder="موضوع آگهی *" required>{{old('description')}}</textarea>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    اطلاعات خودرو را وارد نمایید
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="devided"></div>
                                        <div class="col-sm-12">
                                            <h4 class="cart-title">انتخاب عکس</h4>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="Img_profile" id="profile">
                                                <div class="Img_dashes"></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            <input type="file" class="Img_mediaFile input-file"
                                                   id="img-upload-one" accept="image/*" onchange="Filevalidation()">
                                            <input id="img-base64-one" name="img_base64_one" accept="image/*" hidden>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="Img_profile opacity" id="profile2">
                                                <div class="Img_dashes"></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                                   id="img-upload-two" onchange="Filevalidation()" disabled>
                                            <input id="img-base64-two" name="img_base64_two" accept="image/*" hidden>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="Img_profile opacity" id="profile3">
                                                <div class="Img_dashes"></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                                   id="img-upload-three" onchange="Filevalidation()" disabled>
                                            <input id="img-base64-three" name="img_base64_three" accept="image/*" hidden>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="Img_profile opacity" id="profile4">
                                                <div class="Img_dashes"></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                                   id="img-upload-four" onchange="Filevalidation()" disabled>
                                            <input id="img-base64-four" name="img_base64_four" accept="image/*" hidden>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="image_text_alert text-center text-success mx-auto my-3" style="font-size: 16px"></div>     
                                        
                                        <div class="progress" id="progress-display" style="display: none">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                            </div>
                                    </div>
                                    <p class="text-warning" id="size"></p> 

                                    <div class="devided"></div>

                                    <div class="col-sm-12">
                                        <h4 class="cart-title">موقعیت مکانی</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="state_id" id="state_id" data-placeholder=""
                                                    class="chosen-select no-search-select" required>
                                                <option>استان</option>
                                                @foreach($states as $state)
                                                    <option {{old('state_id') == $state->id ? 'selected' : ''}}
                                                            value="{{$state->id}}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                <i class="fa fa-exclamation mx-2"></i>
                                                انتخاب استان اجباری است
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="city_id" id="city_id"
                                                    class="list_dropdown" required>
                                                <option class="list_dropdown_option">شهر</option>
                                                
                                                    <option class="list_dropdown_option" value="">انتخاب نمایید
                                                    </option>
                                            
                                            </select>
                                            <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                <i class="fa fa-exclamation mx-2"></i>
                                                شهر را انتخاب نمایید
                                            </div>
                                        </div>
                                    </div>
                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <div class="map" id="maps">

                                        </div>
                                    </div>
                                    <input name="location" id="location" hidden>
                                        
                                    <div class="clearfix"></div>
                                    <button id="btnSave" class="btn color-bg btn_submit">
                                        <i class="fas fa-arrow-left mr-3 ml-0"></i>
                                        ثبت آگهی
                                    </button>
                                    
                                    <div class="alert alert-err d-none alert-warning text-center" style="font-size: 16px;">
                                         لطفا خطا های موجود را برطرف نمایید
                                         <!--<a class="btn-link go-error" href="#"> برو به اولین خطا </a>-->
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 pt-5">
                        <!-- CART TOTALS  -->
                        <div class="cart-totals dark-bg fl-wrap"
                        style="position: sticky; top: 100px;">
                            <h3 class="text-center">مجموع هزینه ارسال آگهی</h3>
                            <table class="total-table">
                                <tbody>
                                <tr>
                                    <th>هزینه ثبت آگهی:</th>
                                    <td>رایگان</td>
                                </tr>
                                <tr class="internet-address">
                                    <th>هزینه ثبت آدرس اینترنتی:</th>
                                    <td>غیر فعال</td>
                                </tr>
                                <tr class="payment-adv">
                                    <th>هزینه ثبت آدرس سایت:</th>
                                    <td>
                                        <span class="pay-web"> 0 </span>
                                        <span> تومان </span>
                                    </td>
                                </tr>

                                <tr class="payment-adv">
                                    <th>هزینه ثبت آدرس اینستاگرام:</th>
                                    <td>
                                        <span class="pay-insta"> 0 </span>
                                        <span> تومان </span>
                                    </td>
                                </tr>

                                <tr class="total-factor">
                                    <th class="font-weight-bolder">مجموع</th>
                                    <td class="font-weight-bolder">
                                        <span class="total-pay">0</span>
                                        <span>تومان</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            {{-- <button type="submit" class="cart-totals_btn color-bg">Proceed to Checkout</button> --}}
                        </div>
                        <!-- /CART TOTALS  -->
                    </div>
                </div>
                <!-- /CHECKOUT TABLE -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>


    <script>
    
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          document.querySelector('.alert-err').classList.remove('d-none');
        }
        form.classList.add('was-validated');
        if ($('.invalid-feedback').length) {
            let feeds = document.querySelector('.invalid-feedback');
                setTimeout(function(){
                    $('html, body').animate({
                         scrollTop: ($(feeds).offset().top - 70)
                    }, 500);
                }, 1000);
        }
      }, false);
    });
  }, false);
})();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var lats = [];

        $('#state_id').on('change', function () {

            var stateId = $(this).val();
            // alert(stateId);
            $("#city_id").html('<option value="">شهر مورد نظر را وارد نمایید</option>');
            if (stateId == "")
                return;

            var pdata = {"stateId": stateId};
            $.ajax({
                url: '/posts/getCity',
                data: pdata,
                method: 'post',
                success: function (x) {
                    $("#city_id").css("display", "block");
                    console.log(x.data[0])

                    var options = ""
                    x.data.forEach(op => {
                        options += `<option class="list_dropdown_option" value='${op.id}'>${op.name}</option>`
                        lats[op.id] = op.latlng;
                    });

                    $('#city_id').html(options);
                    console.log(lats)

                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });

        $('#cbrand_id').on('change', function () {
            var cbrandId = $(this).val();
            // alert(cbrandId)
            // return;
            $("#cmodel_id").html('<option value="">مدل مورد نظر را وارد نمایید</option>');
            if (cbrandId == "")
                return;

            var pdata = {"cbrandId": cbrandId};
            $.ajax({
                url: '/posts/ajax/models',
                data: pdata,
                method: 'post',
                success: function (x) {
                    console.log(x)
                    var opt = ""
                    x.data.forEach(op => {
                        opt += `<option class="list_dropdown_option" value='${op.id}'>${op.name}</option>`
                    });
                    $("#cmodel_id").html(opt);
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });

        $('#type').on('change', function () {
            $("#meta_box option").remove();

            var type = $(this).val();
            console.log(type)
            // $("#meta_box").html('<option value="">تناژ مورد نظر را وارد نمایید</option>');
            if (type == "")
                return;

            var pdata = {"type": type};
            console.log(pdata);
            $.ajax({
                url: '/posts/get/meta',
                data: pdata,
                method: 'post',
                success: function (x) {
                    console.log(x.val);
                    $("#meta_box").css("visibility", "visible");
                    $("#meta_box").css("display", "block");
                    $("#meta_box").append('<option value="" class="list_dropdown_option">' + x.val + ' مورد نظر را وارد نمایید</option>');
                    console.log($("#meta_box"));
                    $.each(x.meta, function (key, value) {
                        $("#meta_box").append('<option class="list_dropdown_option" value=' + key + 1 + '>' + value.value + '</option>');
                    });
                    // console.log(x.val);
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });

        $('#city_id').on('change', function () {

            // console.log(lats[$(this).val()])
            var a = lats[$(this).val()]
            var latlng = a.split(",")

            map.panTo(new L.LatLng(latlng[0] , latlng[1]));
        });

        var map = L.map('maps', {
            center: [35.68, 51.38],
            zoom: 12
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; 18charkh'
        }).addTo(map);

        var travel = new Array(2);
        var i = 0;
        let loc;

        function onMapClick(e) {
            if (i === 0) {

                loc = L.marker(e.latlng, {icon: originIcon}).addTo(map);
                $("#location").val(e.latlng.lat + "," + e.latlng.lng);
                travel[i] = e.latlng;
                i = 1;

            } else if (i === 1) {
                map.removeLayer(loc);

                loc = L.marker(e.latlng, {icon: originIcon}).addTo(map);
                $("#location").val(e.latlng.lat + "," + e.latlng.lng);

            }
        }

        map.on('click', onMapClick);

        var originIcon = L.icon({
            iconUrl: 'https://barokala.com/images/location_charkh.png',
            iconAnchor: [18, 26],
            labelAnchor: [-6, 0],
            popupAnchor: [0, -36],
            iconSize: [35, 35]
        });

        $('#price').on('keyup', function () {

            var price = $(this).val();
            // console.log(price);

            if (price.toString().length > 3) {
                $('#price_convert').text(Num2persian(price) + " تومان");
            } else {
                $('#price_convert').text("");
            }
        })

        $('#distance').on('keyup', function () {

            var price = $(this).val();

            if (price.toString().length > 0) {
                $('#distance_convert').text(Num2persian(price) + " کیلومتر");
            } else {
                $('#distance_convert').text("");
            }

        })
        
        
        function Filevalidation(e) { 
        let fi = document.querySelectorAll('input[type="file"]'); 
        // Check if any file is selected. 
        fi.forEach(element => {
            if (element.files.length > 0) { 
            for (let i = 0; i <= element.files.length - 1; i++) { 
  
                let fsize = element.files.item(i).size; 
                let file = Math.round((fsize / 1024)); 
                // The size of the file. 
                if (file > 3040) { 
                    document.getElementById('size').innerHTML = "توجه: حجم فایل انتخابی بیش از 3 مگابایت می باشد."
                    e.preventDefault()
                
                } else {
                    document.getElementById('size').innerHTML = " "
                } 
            } 
        } 
        })
    } 
    
        $(document).ready(function() {
        let price = document.querySelectorAll(".list");
        price.forEach(element => {
            let li_option = Array.from(element.children);
            li_option.forEach(element => {
                let li_data = $(element).attr('data-value');
                
                element.addEventListener('click', (e) => {
                    if (li_data === "agreed") {
                        $('#price').attr('disabled',true);
                        $('#price').css('opacity','0.4');
                    } else if (li_data === "trending") {
                        $('#price').attr('disabled',true);
                        $('#price').css('opacity','0.4');
                    }else {
                        $('#price').attr('disabled',false);
                        $('#price').css('opacity','1');
                    }
                })
            })
        })
        
        
        let input = document.querySelectorAll(".input-file");
        
        input[0].addEventListener('change', () => {
            if (input[0].files.length === 1) {
                input[1].removeAttribute('disabled');
                input[1].previousElementSibling.classList.remove('opacity')
            }
        });
        
        input[1].addEventListener('change', () => {
            if (input[1].files.length === 1) {
                input[2].removeAttribute('disabled');
                input[2].previousElementSibling.classList.remove('opacity')
            }
        });

        input[2].addEventListener('change', () => {
            if (input[2].files.length === 1) {
                input[3].removeAttribute('disabled');
                input[3].previousElementSibling.classList.remove('opacity')
            }
        });
    })

    </script>
    
    

@endsection
