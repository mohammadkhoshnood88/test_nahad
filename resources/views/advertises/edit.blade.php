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
        <section class="hidden-section">
            <div class="container">
                <!-- CHECKOUT TABLE -->
                <div class="row">
                    <div class="col-md-8" style="direction: rtl">
                        <div class="check-out_wrap fl-wrap">
                            <h4 class="cart-title">مشخصات خودرو</h4>
                            <form class="custom-form" action="/userpanel/post/update" method="POST"
                                  enctype="multipart/form-data">

                                @csrf

                                <fieldset>
                                    <div class="row">
                                        @if($posts->is_rent == 0)
                                        <div class="col-sm-6">
                                            <div class="shop-header_opt">
                                                <select name="type" id="type" data-placeholder="Persons"
                                                        class="chosen-select no-search-select">
                                                <option value="{{$posts->type}}" selected>{{$posts->type_name->name}}</option>
                                                    @foreach($types as $t)
                                                        <option value="{{$t->id}}">{{ $t->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="cbrand_id" id="cbrand_id" data-placeholder="Persons"
                                                            class="chosen-select no-search-select">
                                                        @if(isset($posts->cbrand_id))
                                                            <option value="{{$posts->cbrand->id}}">{{$posts->Cbrand->name}}</option>@endif
                                                        @foreach($cbrands as $cbrand)
                                                            <option value="{{$cbrand->id}}">{{ $cbrand->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="cmodel_id" id="cmodel_id" class="list_dropdown">
                                                       
                                                        @if(isset($posts->cmodel_id))
                                                            <option value="{{$posts->cmodel_id}}">{{$posts->Cmodel->name}}</option>@endif
                                                        @foreach($cmodels as $model)
                                                            <option value="{{$model->id}}">{{ $model->name }}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="year_id" id="year_id" data-placeholder="Persons"
                                                            class="chosen-select no-search-select">

                                                        @if(isset($posts->year_id))
                                                            <option value="{{$posts->year_id}}">{{ $posts->Year->name }}</option>@endif
                                                        @foreach($years as $year)
                                                            <option value="{{$year->id}}">{{ $year->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="gearbox_id" id="gearbox_id" data-placeholder="Persons"
                                                            class="chosen-select no-search-select">

                                                        @foreach($gearboxes as $g)
                                                            <option @if($g->id == $posts->gearbox_id) selected
                                                                    @endif value="{{$g->id}}">{{ $g->name }}</option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="cbody_id" id="cbody_id" data-placeholder="Persons"
                                                            class="chosen-select no-search-select">

                                                        @if(isset($posts->cbody_id))
                                                            <option value="{{$posts->cbody_id}}">{{ $posts->Cbody->name }}</option>@endif
                                                        @foreach($cbodies as $g)
                                                            <option value="{{$g->id}}">{{ $g->name }}</option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="color_id" id="color_id"
                                                            class="chosen-select no-search-select">
                                                        @if(isset($posts->color_id))
                                                            <option value="{{$posts->color_id}}">{{ $posts->Color->name }}</option>@endif
                                                        @foreach($colors as $g)
                                                            <option value="{{$g->id}}">{{ $g->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="number" id="distance" name="distance" placeholder="کارکرد *"
                                                       value="{{$posts->distance}}"/>
                                            </div>
                                            <div class="devided"></div>
                                            <div class="col-12">
                                            <h4 class="cart-title">
                                                مشخصات اینترنتی <small>(توجه: وارد کردن اطلاعات در این قسمت دارای هزینه می باشد)</small>
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="insta" name="instagram_id" class="address" value="{{$posts->get_instagram()}}"
                                                   placeholder="آیدی اینستاگرام" >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="site" name="website" class="address" value="{{$posts->get_website()}}"
                                                   placeholder="آدرس وب سایت" >
                                        </div>
                                            <div class="col-sm-12 mt-5">
                                                <h4 class="cart-title">قیمت و مشخصات فردی</h4>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="price_type" id="price_type" data-placeholder="Persons"
                                                            class="chosen-select no-search-select">
                                                        <option value="agreed">قیمت مد نظر</option>
                                                        <option @if($posts->price == null) selected
                                                                @endif value="agreed">توافقی
                                                        </option>
                                                        <option @if($posts->trending == 1) selected
                                                                @endif value="trending">معاوضه
                                                        </option>
                                                        <option @if($posts->price != null) selected
                                                                @endif value="price">نقدی</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" id="price" name="price"
                                                       placeholder="قیمت پیشنهادی ( به تومان )  *"
                                                       value="{{$posts->price == Null || $posts->price == 0 ? "" : $posts->price}}"
                                                />
                                                <p id="price_convert" style="direction: rtl"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" id="subject" name="subject"
                                                                   placeholder="عنوان آگهی *"
                                                                   value="{{$posts->subject}}"
                                                            />
                                                        </div>
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" id="phone_number" name="phone_number"
                                                                   placeholder="شماره تلفن *"
                                                                   value="{{$posts->phone_number}}"
                                                            />
                                                        </div>
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" id="email" name="email"
                                                                   placeholder="ایمیل ( اختیاری )"
                                                                   value="{{$posts->email}}"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <textarea id="description" name="description" cols="30" rows="10" placeholder="موضوع آگهی *">{{$posts->description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="devided"></div>
                                        @else
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="type" id="type" data-placeholder="Persons"
                                                            class="chosen-select no-search-select">
                                                        <option value="{{$posts->type}}" selected>{{$posts->type_name->name}}</option>
                                                    @foreach($types as $t)
                                                        <option value="{{$t->id}}">{{ $t->name }}</option>
                                                    @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <select name="driver_status" id="driver_status"
                                                            data-placeholder="Persons"
                                                            class="chosen-select no-search-select">
                                                        <option>وضعیت راننده</option>
                                                        <option @if($posts->driver_status == 2) selected
                                                                @endif value="2">فرقی نمی کند
                                                        </option>
                                                        <option @if($posts->driver_status == 1) selected
                                                                @endif value="1">با راننده
                                                        </option>
                                                        <option @if($posts->driver_status == 0) selected
                                                                @endif value="0">بدون راننده</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="shop-header_opt">
                                                    <input type="text" value="{{$posts->workers}}" id="workers"
                                                           name="workers" placeholder="تعداد همکاران "/>
                                                </div>
                                            </div>
                                            <div class="devided"></div>
                                            <div class="col-sm-12">
                                                <h4 class="cart-title">مشخصات فردی</h4>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" id="subject" name="subject"
                                                                   placeholder="عنوان آگهی *"
                                                                   value="{{$posts->subject}}"
                                                            />
                                                        </div>
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" id="phone_number" name="phone_number"
                                                                   placeholder="شماره تلفن *"
                                                                   value="{{$posts->phone_number}}"
                                                            />
                                                        </div>
                                                        <div class="col-sm-12 p-0">
                                                            <input type="text" id="email" name="email"
                                                                   placeholder="ایمیل ( اختیاری )"
                                                                   value="{{$posts->email}}"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <textarea id="description" name="description" cols="30" rows="10" placeholder="موضوع آگهی *">{{$posts->description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="devided"></div>
                                        @endif


                                        <div class="col-sm-12">
                                            <h4 class="cart-title">انتخاب عکس</h4>
                                        </div>
                                        <div class="col-sm-3">
                                            
                                            <div class="Img_profile 
                                            @if(isset($images[0]->path))
                                            @if($images[0]->path != "noimage.jpg")
                                            hasImage
                                            @endif
                                            @endif
                                            " id="profile"
                                                 @if(isset($images[0]->path))
                                                 @if($images[0]->path != "noimage.jpg")
                                                 style="background-image:url('/post_images/related_images_watermark/{{$images[0]->path}}')"
                                                    @endif
                                                    @endif
                                            >
                                                <div class="Img_dashes
                                                {{$images[0]->path != "noimage.jpg" ? "Img-loaded" : ""}}
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
                                            

                                            <input id="img-base64-one" name="img_base64_one" hidden accept="image/*"
                                                   value="{{isset($images[0]->path) ? $images[0]->path : ''}}">

                                        </div>
                                    
                                        <div class="col-sm-3">
                                            <div class="Img_profile 
                                            {{isset($images[1]->path) ? "hasImage" : ""}}
                                            {{$images[0]->path != "noimage.jpg" ? "" : "opacity"}}
                                            " id="profile2"
                                                 @if(isset($images[1]->path))
                                                 style="background-image:url('/post_images/related_images_watermark/{{$images[1]->path}}')"
                                                    @endif
                                            >
                                                <div id="border_img_two" class="Img_dashes
                                                {{isset($images[1]->path) ? "Img-loaded" : ""}}
                                                "></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2" 
                                            {{isset($images[1]->path) ? "" : "disabled"}}
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
                                            

                                            <input id="img-base64-two" name="img_base64_two" accept="image/*" hidden
                                                   value="{{isset($images[1]->path) ? $images[1]->path : ''}}">
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="Img_profile
                                            {{isset($images[2]->path) ? "hasImage" : ""}}
                                            {{isset($images[1]->path) ? "" : "opacity"}}
                                            " id="profile3"
                                                 @if(isset($images[2]->path))
                                                 style="background-image:url('/post_images/related_images_watermark/{{$images[2]->path}}')"
                                                    @endif
                                            >
                                                <div id="border_img_three" class="Img_dashes
                                                {{isset($images[2]->path) ? "Img-loaded" : ""}}
                                                "></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2"
                                            {{isset($images[1]->path) ? "" : "disabled"}}
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
                                            

                                            <input id="img-base64-three" name="img_base64_three" accept="image/*" hidden
                                                   value="{{isset($images[2]->path) ? $images[2]->path : ''}}">
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="Img_profile
                                            {{isset($images[3]->path) ? "hasImage" : ""}}
                                            {{isset($images[2]->path) ? "" : "opacity"}}
                                            " id="profile4"
                                                 @if(isset($images[3]->path))
                                                 style="background-image:url('/post_images/related_images_watermark/{{$images[3]->path}}')"
                                                    @endif
                                            >
                                                <div id="border_img_four" class="Img_dashes
                                                {{isset($images[3]->path) ? "Img-loaded" : ""}}
                                                "></div>
                                                <label>کلیک کنید</label>
                                            </div>
                                            
                                            <input type="file" class="Img_mediaFile input-file2"
                                            {{isset($images[3]->path) ? "" : "disabled"}}
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
                                            

                                            <input id="img-base64-four" name="img_base64_four" accept="image/*" hidden
                                                   value="{{isset($images[3]->path) ? $images[3]->path : ''}}">

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
                                                <option value="{{$posts->state->id}}" selected>{{$posts->State->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}">{{ $state->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="city_id" id="city_id" class="chosen-select no-search-select">
                                                
                                                <option value="{{$posts->city->id}}" selected>{{$posts->City->name}}</option>
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
                                    <input name="location" id="location" value="{{$posts->location}}" hidden>
                                    <input name="id" value="{{$posts->id}}" hidden/>

                                    <button type="submit" id="btnSave" class="btn color-bg" style="direction: ltr">
                                        ویرایش
                                        آگهی<i class="fl fa-long-arrow-left"></i></button>
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

        var d = "{{$posts->location}}"
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