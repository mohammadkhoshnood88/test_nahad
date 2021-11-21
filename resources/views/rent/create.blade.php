@extends('layout.Main')

@section('header')
    ﺛﺒﺖ آﮔﻬﯽ اﺟﺎره |
@endsection

@section('ownpage_meta')
    <meta name="description" content="18 ﭼﺮخ ﺛﺒﺖ آﮔﻬﯽ اﺟﺎره اﻧﻮاع"ﻣﺎﺷﯿﻦ ﺳﻨﮕﯿﻦ" ﮐﺸﻨﺪه/ﮐﺎﻣﯿﻮﻧﺖ/ﺗﺮﯾﻠﺮ/ﮐﺎﻣﯿﻮن 911 ﺑﺎ راﻧﻨﺪه وﺑﺪون در ﺳﺮاﺳﺮ اﯾﺮان.">
    
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

        .leaflet-popup-tip-container {
        }
        .opacity {
            opacity: 0.4;
        }

    </style>


    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>

@endsection

@section('content')
<div class="content">
    <!--  section  -->
    <section class="parallax-section hero-section hidden-section" style="overflow: hidden;" data-scrollax-parent="true"></section>
    <!--  section  end-->
    <!--  section  -->
    <section class="hidden-section" style="overflow: unset;">
        <div class="container">
            <!-- CHECKOUT TABLE -->
            <div class="row">
                <div class="col-md-8">
                    <div class="check-out_wrap fl-wrap">
                        <h4 class="cart-title">مشخصات خودرو</h4>
                        <form class="custom-form" action="{{url('/rent/store')}}" method="POST" style="direction: rtl">
                            <fieldset>
                                <div class="row">
                                    @csrf

                                    
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="type" id="type" data-placeholder="Persons"
                                                    class="chosen-select no-search-select" required>
                                                <option>نوع ماشین</option>
                                                @foreach($types as $type)
                                                    <option @if(old('type') == $type->id) selected @endif  value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation ml-2"></i>
                                                    نوع خودرو خود را انتخاب نمایید
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="number" value="{{old('workers')}}" id="workers" name="workers"  placeholder="تعداد همکاران " />
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="driver_status" id="driver_status" data-placeholder="Persons"
                                                    class="chosen-select no-search-select">
                                                <option>وضعیت راننده </option>
                                                <option @if(old('driver_status') == '2') selected @endif value="2">فرقی نمی کند</option>
                                                <option @if(old('driver_status') == '1') selected @endif value="1">با راننده</option>
                                                <option @if(old('driver_status') == '0') selected @endif value="0">بدون راننده</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <h4 class="cart-title">مشخصات فردی</h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                     <div class="col-sm-12">
                                                        <input type="text" id="subject" name="subject" placeholder="عنوان آگهی *" value="{{old('subject')}}" />
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" id="phone_number" name="phone_number" placeholder="شماره تلفن *" value="{{old('phone_number')}}" />
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" id="email" name="email" placeholder="ایمیل (اختیاری)" value="{{old('email')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <textarea id="description" name="description" cols="30" rows="8" placeholder="موضوع آگهی ">{{old('description')}}</textarea>
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
                                        <div class="Img_dashes" id="border_img_one"></div>
                                        <label>کلیک کنید</label>
                                    </div>
                                    
                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                           id="img-upload-one"/>
                                    
                                    <div class="spinnerStyle" id="spin_img_one" style="display:none">
                                        <div class="divSpiner">
                                            <div class="divSpiner">
                                                <div class="divSpiner">
                                                    <div class="divSpiner">
                                                        <div class="divSpiner">
                                                            <div class="divSpiner">
                                                                <div class="divSpiner">
                                                                    <div class="divSpiner"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input id="img-base64-one" name="img_base64_one" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-3">
                                    <div class="Img_profile opacity" id="profile2">
                                        <div class="Img_dashes" id="border_img_two"></div>
                                        <label>کلیک کنید</label>
                                    </div>
                                    
                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                           id="img-upload-two" disabled/>
                                    
                                    <div class="spinnerStyle" id="spin_img_two" style="display:none">
                                        <div class="divSpiner">
                                            <div class="divSpiner">
                                                <div class="divSpiner">
                                                    <div class="divSpiner">
                                                        <div class="divSpiner">
                                                            <div class="divSpiner">
                                                                <div class="divSpiner">
                                                                    <div class="divSpiner"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input id="img-base64-two" name="img_base64_two" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-3">
                                    <div class="Img_profile opacity" id="profile3">
                                        <div class="Img_dashes" id="border_img_three"></div>
                                        <label>کلیک کنید</label>
                                    </div>
                                    
                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                           id="img-upload-three" disabled/>
                                           
                                    <div class="spinnerStyle" id="spin_img_three" style="display:none">
                                        <div class="divSpiner">
                                            <div class="divSpiner">
                                                <div class="divSpiner">
                                                    <div class="divSpiner">
                                                        <div class="divSpiner">
                                                            <div class="divSpiner">
                                                                <div class="divSpiner">
                                                                    <div class="divSpiner"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input id="img-base64-three" name="img_base64_three" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-3">
                                    <div class="Img_profile opacity" id="profile4">
                                        <div class="Img_dashes" id="border_img_four"></div>
                                        <label>کلیک کنید</label>
                                    </div>
                                    
                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                           id="img-upload-four" disabled/>
                                    
                                    <div class="spinnerStyle" id="spin_img_four" style="display:none">
                                        <div class="divSpiner">
                                            <div class="divSpiner">
                                                <div class="divSpiner">
                                                    <div class="divSpiner">
                                                        <div class="divSpiner">
                                                            <div class="divSpiner">
                                                                <div class="divSpiner">
                                                                    <div class="divSpiner"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input id="img-base64-four" name="img_base64_four" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-6">
                                    <div class="image_text_alert text-center text-success mx-auto my-3" style="font-size: 16px"></div>     
                                    
                                    <div class="progress" id="progress-display" style="display: none">
                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                        </div>
                                </div>
                                <p class="text-warning" id="size"></p> 

                                <div class="devided"></div>
                                       
                                <div class="clearfix"></div>
                                     <div class="col-sm-12">
                                        <h4 class="cart-title">موقعیت مکانی</h4>
                                    </div>
                                      <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="state_id" id="state_id" data-placeholder=""
                                                        class="chosen-select no-search-select">
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
                                                    class="chosen-select no-search-select" required>
                                                    <option>شهر</option>                                            
                                                </select>
                                                <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                                    <i class="fa fa-exclamation mx-2"></i>
                                                    شهر را انتخاب نمایید
                                                </div>
                                            </div>
                                        </div>
                                    <div class="devided"></div>
                                     <div class="col-sm-12 map" id="maps" style="border-radius: 20px"></div>
                                <input name="location" id="location" hidden>
                                    
                                <button id="btnSave" class="btn color-bg btn_submit">
                                    <i class="fas fa-arrow-left mr-3 ml-0"></i>
                                    ثبت آگهی
                                </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                    <div class="col-md-4">
                    <!-- CART TOTALS  -->
                    <div class="cart-totals dark-bg fl-wrap" style="position: sticky; top: 90px;">
                        <h3>مجموع هزینه ارسال آگهی</h3>
                        <table class="total-table">
                            <tbody>
                                <tr>
                                    <th>هزینه ثبت آگهی:</th>
                                    <td>رایگان</td>
                                </tr>
                                <tr>
                                    <th>هزینه ثبت آدرس اینترنتی:</th>
                                    <td>غیر فعال</td>
                                </tr>
                                <tr>
                                    <th>مجموع:</th>
                                    <td>0 تومان</td>
                                </tr>
                            </tbody>
                        </table>
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

    <script>
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
                    // console.log(x.data[0])

                    var options = ""
                    var cities_item = ""
                    x.data.forEach(op => {
                        options += `<option class="list_dropdown_option" value='${op.id}'>${op.name}</option>`
                        cities_item += `<li class="option" data-value='${op.id}'>${op.name}</li>`
                        lats[op.id] = op.latlng;
                    });

                    $('#city_id').append(options);
                    $('#city_id').closest('.shop-header_opt').find('.list').empty();
                    $('#city_id').closest('.shop-header_opt').find('.list').append(`<li class="option selected">شهر</li>`);
                    $('#city_id').closest('.shop-header_opt').find('.list').append(cities_item);

                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });

        $('#cbrand_id').on('change', function () {
            var cbrandId = $(this).val();
            $("#cmodel_id").html('<option value="">مدل مورد نظر را وارد نمایید</option>');
            if (cbrandId == "")
                return;

            var pdata = {"cbrandId": cbrandId};
            $.ajax({
                url: '/posts/ajax/models',
                data: pdata,
                method: 'post',
                success: function (x) {
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
            
            if (type == "")
                return;
            var pdata = {"type": type};
            $.ajax({
                url: '/posts/get/meta',
                data: pdata,
                method: 'post',
                success: function (x) {
                    
                    $("#meta_box").css("visibility", "visible");
                    $("#meta_box").css("display", "block");
                    $("#meta_box").append('<option value="" class="list_dropdown_option">' + x.val + ' مورد نظر را وارد نمایید</option>');
                    
                    $.each(x.meta, function (key, value) {
                        $("#meta_box").append('<option class="list_dropdown_option" value=' + key + 1 + '>' + value.value + '</option>');
                    });
                    
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });


        $('#city_id').on('change', function () {

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

        $('#driver_status').on('change', function () {
            if($('#driver_status').val() == 1){
                $('#workers').removeAttr('disabled');
            }
            else{
                $('#workers').attr('disabled' , 'disabled');
                $('#workers').val("")

            }
        });
        
        $(document).ready(function() {
        
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

