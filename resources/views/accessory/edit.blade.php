@extends('layout.Main')

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
        <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
        <!--  section  end-->
        <!--  section  -->
        <section class="hidden-section" style="overflow: unset;">
            <div class="container">
                <!-- CHECKOUT TABLE -->
                <div class="row">
                    <div class="col-md-8" style="direction: rtl">
                        <div class="check-out_wrap fl-wrap">
                            <h4 class="cart-title">مشخصات خودرو</h4>
                            <form class="custom-form" action="{{ route('accessory_update', [$accessory->id]) }}" method="POST"
                                  enctype="multipart/form-data">

                                @csrf

                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" id="owner_name" name="owner_name"
                                                placeholder="نام مالک فروشگاه *"
                                                value="{{$accessory->owner_name}}" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="owner_phone_number" name="phone_number"
                                                placeholder="شماره همراه مالک *"
                                                value="{{$accessory->phone_number}}" />
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-check mr-sm-2 text-right mt-3">
                                                <input type="checkbox" name="hide_phone_number" class="form-check-input" id="hide_phone_number">
                                                <label class="form-check-label hide_phone_number mr-4"
                                                    for="hide_phone_number">
                                                    شماره همراه در آگهی نمایش داده نشود
                                                </label>
                                            </div>
                                        </div>
                                        <div class="devided"></div>
                                        <div class="col-sm-12">
                                            <h4 class="cart-title">مشخصات آگهی لوازم یدکی</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="subject" name="subject" placeholder="عنوان آگهی *"
                                                value="{{$accessory->subject}}" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="store_name" name="name" placeholder="نام فروشگاه"
                                                value="{{$accessory->name}}" />
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea id="description" name="description" cols="30" rows="8"
                                                placeholder="متن آگهی ">
                                                {{$accessory->description}}
                                            </textarea>
                                        </div>
                                        <div class="devided"></div>
                                        <div class="col-12">
                                            <h4 class="cart-title">
                                                مشخصات اینترنتی <small>(توجه: وارد کردن اطلاعات در این قسمت دارای هزینه می
                                                    باشد)</small>
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="insta" name="instagram_id" class="address" value="{{$accessory->instagram_id}}"
                                                placeholder="آیدی اینستاگرام">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="site" name="website" class="address" value="{{$accessory->website}}"
                                                placeholder="آدرس وب سایت">
                                        </div>
                                        <div class="devided"></div>
                                        <div class="col-sm-12">
                                            <h4 class="cart-title">انتخاب عکس</h4>
                                        </div>
                                        <div class="col-sm-3">
                                            
                                            <div class="Img_profile 
                                            @if(isset($accessory->images[0]->path))
                                            @if($accessory->images[0]->path != "noimage.jpg")
                                            hasImage
                                            @endif
                                            @endif
                                            " id="profile"
                                                 @if(isset($accessory->images[0]->path))
                                                 @if($accessory->images[0]->path != "noimage.jpg")
                                                 style="background-image:url('/post_images/related_images_watermark/{{$accessory->images[0]->path}}')"
                                                    @endif
                                                    @endif
                                            >
                                                <div class="Img_dashes
                                                {{$accessory->images[0]->path != "noimage.jpg" ? "Img-loaded" : ""}}
                                                " id="border_img_one"></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2"
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
                                            

                                            <input id="img-base64-one" name="images[]" hidden accept="image/*"
                                                   value="{{isset($accessory->images[0]->path) ? $accessory->images[0]->path : ''}}">

                                        </div>
                                    
                                        <div class="col-sm-3">
                                            <div class="Img_profile 
                                            {{isset($accessory->images[1]->path) ? "hasImage" : ""}}
                                            {{$accessory->images[0]->path != "noimage.jpg" ? "" : "opacity"}}
                                            " id="profile2"
                                                 @if(isset($accessory->images[1]->path))
                                                 style="background-image:url('/post_images/related_images_watermark/{{$accessory->images[1]->path}}')"
                                                    @endif
                                            >
                                                <div id="border_img_two" class="Img_dashes
                                                {{isset($accessory->images[1]->path) ? "Img-loaded" : ""}}
                                                "></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2" 
                                            {{isset($accessory->images[0]->path) ? "" : "disabled"}}
                                                   id="img-upload-two"/>
                                            
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
                                            

                                            <input id="img-base64-two" name="images[]" accept="image/*" hidden
                                                   value="{{isset($accessory->images[1]->path) ? $accessory->images[1]->path : ''}}">
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="Img_profile
                                            {{isset($accessory->images[2]->path) ? "hasImage" : ""}}
                                            {{isset($accessory->images[1]->path) ? "" : "opacity"}}
                                            " id="profile3"
                                                 @if(isset($accessory->images[2]->path))
                                                 style="background-image:url('/post_images/related_images_watermark/{{$accessory->images[2]->path}}')"
                                                    @endif
                                            >
                                                <div id="border_img_three" class="Img_dashes
                                                {{isset($accessory->images[2]->path) ? "Img-loaded" : ""}}
                                                "></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2"
                                            {{isset($accessory->images[1]->path) ? "" : "disabled"}}
                                                   id="img-upload-three"/>
                                            
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
                                            

                                            <input id="img-base64-three" name="images[]" accept="image/*" hidden
                                                   value="{{isset($accessory->images[2]->path) ? $accessory->images[2]->path : ''}}">
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="Img_profile
                                            {{isset($accessory->images[3]->path) ? "hasImage" : ""}}
                                            {{isset($accessory->images[2]->path) ? "" : "opacity"}}
                                            " id="profile4"
                                                 @if(isset($images[3]->path))
                                                 style="background-image:url('/post_images/related_images_watermark/{{$accessory->images[3]->path}}')"
                                                    @endif
                                            >
                                                <div id="border_img_four" class="Img_dashes
                                                {{isset($accessory->images[3]->path) ? "Img-loaded" : ""}}
                                                "></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2"
                                            {{isset($accessory->images[2]->path) ? "" : "disabled"}}
                                                   id="img-upload-four"/>
                                            
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
                                            

                                            <input id="img-base64-four" name="images[]" accept="image/*" hidden
                                                   value="{{isset($accessory->images[3]->path) ? $accessory->images[3]->path : ''}}">

                                        </div>
                                        <div class="image_text_alert text-center text-success mx-auto" style="font-size: 16px"></div>
                                    </div>
                                    <p class="text-warning" id="size"></p> 
                                    <div class="clearfix"></div>
                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <h4 class="cart-title">موقعیت مکانی</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="state_id" id="state_id" data-placeholder=""
                                                    class="chosen-select no-search-select">
                                                <option value="{{$accessory->state->id}}" selected>{{$accessory->State->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}">{{ $state->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="city_id" id="city_id" class="chosen-select no-search-select">
                                                
                                                <option value="{{$accessory->city->id}}" selected>{{$accessory->City->name}}</option>
                                                @foreach($cities as $c)
                                                    <option value="{{$c->id}}">{{ $c->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <div class="map" id="maps" style="border-radius: 0px 100px">

                                        </div>

                                    </div>
                                    <input name="location" id="location" value="{{$accessory->location}}" hidden>

                                    <button type="submit" id="btnSave" class="btn color-bg" style="direction: ltr">
                                        ویرایش
                                        آگهی<i class="fa fa-long-arrow-left"></i></button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
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

    <script src="https://cdn.jsdelivr.net/gh/mahmoud-eskandari/NumToPersian/dist/num2persian-min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        var lats = [];


        $('#state_id').on('change', function () {

            var stateId = $(this).val();
            // alert(stateId);
            $("#city_id").html('<option value="">شهر مورد نظر را وارد نمایید</option>');
            $('#city_id').closest('.shop-header_opt').find('.list').empty();
            
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
                    // console.log(x)
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
            // console.log(type)
            // $("#meta_box").html('<option value="">تناژ مورد نظر را وارد نمایید</option>');
            if (type == "")
                return;

            var pdata = {"type": type};
            // console.log(pdata);
            $.ajax({
                url: '/posts/get/meta',
                data: pdata,
                method: 'post',
                success: function (x) {
                    // console.log(x.val);
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

        var d = "{{$accessory->location}}"
        d = d.split(',');
        var icon = 0;
        var i = 1;
        
            if(d.length === 1){
                d = [35.68, 51.38]
                i = 0;
            }
                

        var map = L.map('maps', {
            center: [d[0],d[1]],
            zoom: 12
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; 18charkh'
        }).addTo(map);

        var travel = new Array(2);
        // var i = 1;
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
            // className: 'destination-icon',
            iconUrl: 'https://barokala.com/images/location_charkh.png',
            iconAnchor: [18, 26],
            labelAnchor: [-6, 0],
            popupAnchor: [0, -36],
            iconSize: [35, 35]
        });
        
        if(i === 1)
            loc = L.marker([d[0] , d[1]], {icon: originIcon}).addTo(map);

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
        
        
    //     function Filevalidation(e) { 
    //     const fi = document.querySelectorAll('input[type="file"]'); 
    //     // Check if any file is selected. 
    //     fi.forEach(element => {
    //         if (element.files.length > 0) { 
    //         for (const i = 0; i <= element.files.length - 1; i++) { 
  
    //             const fsize = element.files.item(i).size; 
    //             const file = Math.round((fsize / 1024)); 
    //             // The size of the file. 
    //             if (file > 3040) { 
    //                 document.getElementById('size').innerHTML = "توجه: حجم فایل انتخابی بیش از 3 مگابایت می باشد."
    //                 e.preventDefault()
                
    //             } else {
    //                 document.getElementById('size').innerHTML = " "
    //             } 
    //         } 
    //     } 
    //     })
    // } 
    
    $(document).ready(function() {
        $('#price').attr('disabled', true);
            $('#price').css('opacity', '0.4');
            let price = document.querySelectorAll(".shop-header_opt");
            price.forEach(element => {
                let li_option = Array.from(element.children);
                li_option.forEach(element => {
                    let li_data = $(element).text();
                    console.error("id test  " + li_data);
                    $(element).on('change', function() {
                        var elemm = $(this).val();
                        console.log(elemm);

                        if (elemm == "price") {
                            console.error("hiiii " + li_data);
                            $('#price').attr('disabled', false);
                            $('#price').css('opacity', '1');

                            console.error("id test agreed");
                        } else {
                            $('#price').attr('disabled', true);
                            $('#price').css('opacity', '0.4');

                        }

                    });
                })
            })
        
        let input2 = document.querySelectorAll(".input-file2");
        
        input2[0].addEventListener('change', () => {
            if (input2[0].files.length === 1) {
                input2[1].removeAttribute('disabled');
                input2[1].previousElementSibling.classList.remove('opacity')
            }
        });
        
        input2[1].addEventListener('change', () => {
            if (input2[1].files.length === 1) {
                input2[2].removeAttribute('disabled');
                input2[2].previousElementSibling.classList.remove('opacity')
            }
        });

        input2[2].addEventListener('change', () => {
            if (input2[2].files.length === 1) {
                input2[3].removeAttribute('disabled');
                input2[3].previousElementSibling.classList.remove('opacity')
            }
        });
        
        // console.log(input2[1].value)
    })

    </script>
    
    

@endsection