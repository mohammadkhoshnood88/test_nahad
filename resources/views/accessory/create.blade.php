@extends('layout.Main')

@section('header')
ﺛﺒﺖ آﮔﻬﯽ فروشگاه لوازم یدکی |
@endsection

@section('ownpage_meta')

@endsection

@section('style')


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin="" />

<style>
    .leaflet-popup-content-wrapper {
        background: linear-gradient(60deg, yellowgreen, greenyellow);
    }

    .leaflet-popup-content-wrapper .leaflet-popup-content {}

    .leaflet-popup-tip-container {}

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
    <section class="parallax-section hero-section hidden-section" style="overflow: hidden;" data-scrollax-parent="true">
    </section>
    <!--  section  end-->
    <!--  section  -->
    <section class="hidden-section" style="overflow: unset;">
        <div class="container">
            <!-- CHECKOUT TABLE -->
            <div class="row">
                <div class="col-md-8">
                    <div class="check-out_wrap fl-wrap">
                        <h4 class="cart-title">مشخصات مالک</h4>
                        <form class="custom-form" action="{{url('/accessory/store')}}" method="POST" style="direction: rtl">
                            <fieldset>
                                <div class="row">
                                    @csrf
                                    <div class="col-sm-6">
                                        <input type="text" id="owner_name" name="owner_name"
                                            placeholder="نام مالک فروشگاه *" value="" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="owner_phone_number" name="phone_number"
                                            placeholder="شماره همراه مالک *" value="" />
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
                                            value="" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="store_name" name="name" placeholder="نام فروشگاه"
                                            value="" />
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea id="description" name="description" cols="30" rows="8"
                                            placeholder="متن آگهی "></textarea>
                                    </div>
                                </div>
                                <div class="devided"></div>

                                <div class="col-12">
                                    <h4 class="cart-title">
                                        مشخصات اینترنتی <small>(توجه: وارد کردن اطلاعات در این قسمت دارای هزینه می
                                            باشد)</small>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="insta" name="instagram_id" class="address"
                                        placeholder="آیدی اینستاگرام">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="site" name="website" class="address"
                                        placeholder="آدرس وب سایت">
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
                                        id="img-upload-one" />

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

                                    <input id="img-base64-one" name="images[]" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-3">
                                    <div class="Img_profile opacity" id="profile2">
                                        <div class="Img_dashes" id="border_img_two"></div>
                                        <label>کلیک کنید</label>
                                    </div>

                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                        id="img-upload-two" disabled />

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

                                    <input id="img-base64-two" name="images[]" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-3">
                                    <div class="Img_profile opacity" id="profile3">
                                        <div class="Img_dashes" id="border_img_three"></div>
                                        <label>کلیک کنید</label>
                                    </div>

                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                        id="img-upload-three" disabled />

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

                                    <input id="img-base64-three" name="images[]" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-3">
                                    <div class="Img_profile opacity" id="profile4">
                                        <div class="Img_dashes" id="border_img_four"></div>
                                        <label>کلیک کنید</label>
                                    </div>

                                    <input type="file" class="Img_mediaFile input-file" accept="image/*"
                                        id="img-upload-four" disabled />

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

                                    <input id="img-base64-four" name="images[]" accept="image/*" hidden>
                                </div>
                                <div class="col-sm-6">
                                    <div class="image_text_alert text-center text-success mx-auto my-3"
                                        style="font-size: 16px"></div>

                                    <div class="progress" id="progress-display" style="display: none">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated">
                                        </div>
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
                                        <select name="city_id" id="city_id" class="chosen-select no-search-select"
                                            required>
                                            <option>شهر</option>
                                        </select>
                                        <div class="invalid-feedback text-right pr-2" style="font-size: 15px">
                                            <i class="fa fa-exclamation mx-2"></i>
                                            شهر را انتخاب نمایید
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <textarea id="description" name="address" cols="30" rows="2"
                                        placeholder="آدرس دقیق فروشگاه "></textarea>
                                </div>
                                <div class="devided"></div>
                                <div class="col-sm-12 map" id="maps" style="border-radius: 20px"></div>
                                <input name="location" id="location" hidden>

                                <div class="clearfix"></div>
                                <button id="btnSave" class="btn color-bg btn_submit">
                                    <i class="fas fa-arrow-left mr-3 ml-0"></i>
                                    ثبت آگهی
                                </button>

                                <div class="alert alert-err d-none alert-warning text-center" style="font-size: 16px;">
                                    لطفا خطاهای موجود را برطرف نمایید
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- CART TOTALS  -->
                    <div class="cart-totals dark-bg fl-wrap" style="position: sticky; top: 100px;">
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
                     scrollTop: ($(feeds).first().offset().top)
                        },500);  
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