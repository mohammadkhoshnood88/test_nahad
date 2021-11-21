@extends('layout.Main')

@section('style')


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>

<style>
    .leaflet-popup-content-wrapper {
        background: linear-gradient(60deg, yellowgreen, greenyellow);
    }

    .leaflet-popup-content-wrapper .leaflet-popup-content {}

    .leaflet-popup-tip-container {}
</style>


<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>

@endsection


@section('content')
    @if($posts->is_rent == 0)
<div class="content">
    <!--  section  -->
    <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true">
        <div class="bg par-elem" data-bg=""
            data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title">
                <h4>فرم ویرایش آگهی</h4>
                <h2>ویرایش آگهی</h2>
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
            <!-- CHECKOUT TABLE -->
            <div class="row">
                <div class="col-md-10 offset-md-1" style="direction: rtl">
                    <div class="check-out_wrap fl-wrap">
                        <h4 class="cart-title">مشخصات خودرو</h4>
                        <form class="custom-form" action="/userpanel/post/update" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="type" id="type" data-placeholder="Persons"
                                                class="chosen-select no-search-select">
                                                <!--<option value="{{$posts->type}}">{{$posts->type_name()}}</option>-->
                                                @foreach($types as $t)
                                                    <option @if($t->id == $posts->type) selected @endif value="{{$t->id}}">{{ $t->name }}</option>
                                                @endforeach
                                               
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="cbrand_id" id="cbrand_id" data-placeholder="Persons"
                                                class="chosen-select no-search-select">
                                                @if(isset($posts->cbrand_id))<option value="{{$posts->cbrand->id}}">{{$posts->Cbrand->name}}</option>@endif
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
                                                    <option class="list_dropdown_option" value="{{$posts->cmodel->id}}">{{$posts->Cmodel->name}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="year_id" id="year_id" data-placeholder="Persons"
                                                class="chosen-select no-search-select">
                                                
                                                @foreach($years as $year)
                                                    <option @if($year->id == $posts->year_id) selected @endif value="{{$year->id}}">{{ $year->name }}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="gearbox_id" id="gearbox_id" data-placeholder="Persons"
                                                class="chosen-select no-search-select">
                                                
                                                @foreach($gearboxes as $g)
                                                    <option @if($g->id == $posts->gearbox_id) selected @endif value="{{$g->id}}">{{ $g->name }}</option>
                                                @endforeach
                                                
                                     
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="cbody_id" id="cbody_id" data-placeholder="Persons"
                                                class="chosen-select no-search-select">
                                   
                                                 
                                                @foreach($cbodies as $g)
                                                    <option @if($g->id == $posts->cbody_id) selected @endif value="{{$g->id}}">{{ $g->name }}</option>
                                                @endforeach
                                                
                                              
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="color_id" id="color_id"
                                                class="chosen-select no-search-select">
                                       
                                    
                                                @foreach($colors as $g)
                                                    <option @if($g->id == $posts->color_id) selected @endif value="{{$g->id}}">{{ $g->name }}</option>
                                                @endforeach
                                                
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="distance" name="distance" placeholder="کارکرد *"
                                            value="{{$posts->distance}}"
                                             />
                                    </div>
                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <h4 class="cart-title">قیمت و مشخصات فردی</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="price_type" id="price_type" data-placeholder="Persons"
                                                class="chosen-select no-search-select">
                                                <option>قیمت مد نظر</option>
                                                <option @if($posts->price == null) selected @endif value="agreed">توافقی</option>
                                                <option @if($posts->trending == 1) selected @endif value="trending">معاوضه</option>
                                                <option value="price">نقدی</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="price" name="price"
                                            placeholder="قیمت پیشنهادی ( به تومان )  *"
                                             value="{{$posts->price}}"
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
                                                <textarea name="comments" id="description" name="description" cols="30"
                                                    rows="10" placeholder="موضوع آگهی *">
                                                   {{$posts->description}}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <h4 class="cart-title">انتخاب عکس</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="Img_profile" id="profile0" data-id="0"

                                             {{-- style="background-image:url('/post_images/related_images_watermark/{{$posts->image_path}}')" --}}
                                             >
                                            <div class="Img_dashes"></div>
                                            <label>کلیک کنید</label>
                                        </div>
                                        <input type="file" class="Img_mediaFile" name="img-upload-one"
                                               id="img-upload-one" />
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="Img_profile" id="profile1"
                                             @if(isset($images[1]->path))
                                             style="background-image:url('/post_images/related_images_watermark/{{$images[1]->path}}')"
                                                @endif
                                                >
                                            <div class="Img_dashes"></div>
                                            <label>کلیک کنید</label>
                                        </div>
                                        <input type="file" class="Img_mediaFile" name="img-upload-two"
                                               id="img-upload-two" />
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="Img_profile" id="profile2"
                                             @if(isset($images[2]->path))
                                             style="background-image:url('/post_images/related_images_watermark/{{$images[2]->path}}')"
                                                @endif
                                                >
                                            <div class="Img_dashes"></div>
                                            <label>کلیک کنید</label>
                                        </div>
                                        <input type="file" class="Img_mediaFile" name="img-upload-three"
                                               id="img-upload-three" />
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="Img_profile" id="profile3"
                                             @if(isset($images[3]->path))
                                             style="background-image:url('/post_images/related_images_watermark/{{$images[3]->path}}')"
                                                @endif
                                                >
                                            <div class="Img_dashes"></div>
                                            <label>کلیک کنید</label>
                                        </div>
                                        <input type="file" class="Img_mediaFile" name="img-upload-four"
                                               id="img-upload-four" />
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                    <div class="devided"></div>
                                    <div class="col-sm-12">
                                        <h4 class="cart-title">موقعیت مکانی</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="state_id" id="state_id" data-placeholder=""
                                                class="chosen-select no-search-select">
                                                <option value="{{$posts->state->id}}">{{$posts->State->name}}</option>
                                                @foreach($states as $state)
                                                    <option @if($state->id == $posts->state->id) selected @endif value="{{$state->id}}">{{ $state->name }}</option>
                                                @endforeach
                                             
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="shop-header_opt">
                                            <select name="city_id" id="city_id" class="list_dropdown">

                                                <option class="list_dropdown_option" value="{{$posts->city->id}}">{{$posts->City->name}} </option>

                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="map" id="maps">

                                        </div>
                                    </div>
                                    
                                <button type="submit" id="btnSave" class="btn color-bg" style="direction: ltr">ویرایش
                                    آگهی<i class="fa fa-long-arrow-left"></i></button>
                            </fieldset>
                        </form>
                    </div>
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
@else

    @endif
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/gh/mahmoud-eskandari/NumToPersian/dist/num2persian-min.js"></script>

{{-- <script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {


            // $('#type').on('change', function () {
            //     let val = $(this).val();
            //
            //     if (val === '1') {
            //         $('#meta_box').removeAttr("disabled");
            //     } else if (val != '1') {
            //         $('#meta_box').attr("disabled", "disabled");
            //         $('#meta_box').val("");
            //     }
            //
            //
            // })


            $('#state_id').on('change', function () {

                var stateId = $(this).val();
                alert(stateId);
                $("#city_id").html('<option value="" class="list_dropdown_option">شهر مورد نظر را وارد نمایید</option>');
                if (stateId == "")
                    return;

                var pdata = {"stateId": stateId};
                $.ajax({
                    url: '/posts/getCity',
                    data: pdata,
                    method: 'post',
                    success: function (x) {
                        $("#city_id").css("display" , "block");
                        console.log(x)
                        $("#city_id").html(x);
                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });

            $('#cbrand_id').on('change', function () {
                var cbrandId = $(this).val();
                alert(cbrandId)
                // return;
                $("#cmodel_id").html('<option value="">مدل مورد نظر را وارد نمایید</option>');
                if (cbrandId == "")
                    return;

                var pdata = {"brands": cbrandId};
                $.ajax({
                    url: '/posts/ajax/models',
                    data: pdata,
                    method: 'post',
                    success: function (x) {
                        console.log(x)
                        $("#cmodel_id").html(x);
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
                        console.log(x.val);
                    },
                    error: function (exception) {
                        console.log(exception);
                    }

                });
            });




            $('#price').on('keyup', function () {

                var price = $(this).val();
                console.log(price);

                if (price.toString().length > 3) {
                    $('#price_convert').text(Num2persian(price) + " تومان");
                } else {
                    $('#price_convert').text("");
                }
            })


        });

        document.getElementById('agreed').onchange = function () {
            document.getElementById('price').disabled = this.checked;
        };
</script>
<script>
    var d = "{{$posts->location}}"
    d = d.split(',');

    // alert(locs)
    var map = L.map('maps', {
            center: [d[0], d[1]],
            zoom: 13
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; 18charkh'
        }).addTo(map);

        var travel = new Array(2);
        var i = 0;
        let loc;
        //
        //
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
            iconUrl: 'https://barokala.com/images/location_blue.png',
            iconAnchor: [18, 26],
            labelAnchor: [-6, 0],
            popupAnchor: [0, -36],
            iconSize: [35, 35]
        });

    loc = L.marker([d[0] , d[1]], {icon: originIcon}).addTo(map);

</script> --}}

@endsection