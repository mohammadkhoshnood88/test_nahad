@extends('layout.Main')

@section('header')
     ﺗﻤﺎس ﺑﺎ ﻣﺎ |
@endsection

@section('ownpage_meta')
    <meta name="description" content="18 ﭼﺮخ ﺗﻤﺎس ﺑﺎ ﻣﺎ ﺑﺮاي ﺛﺒﺖ آﮔﻬﯽ و ﺧﺮﯾﺪ و ﻓﺮوش اﻧﻮاع"ﻣﺎﺷﯿﻦ ﺳﻨﮕﯿﻦ" ﮐﺸﻨﺪه/ﮐﺎﻣﯿﻮﻧﺖ/ﺗﺮﯾﻠﺮ/ﮐﺎﻣﯿﻮن 911 دروب ﺳﺎﯾﺖ">
@endsection

@section('content')
<div class="content">
    <section class=" no-padding dark-bg hidden-section">
        <div class="map-container">
            <div id="singleMap">
                <iframe class="iframe_map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.1024662015825!2d51.34801087767837!3d35.699096020315025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e011c65c9af37%3A0x65a4aa90628c7597!2z2K7bjNin2KjYp9mGINii2LLYp9iv24w!5e0!3m2!1sen!2s!4v1617777151119!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="scrollContorl"></div>
        </div>
        <!-- map-view-wrap -->
        <div class="map-view-wrap">
            <div class="container details">
                <div class="map-view-wrap_item">
                    <div class="contact-details details-responsive">
                        <h4 style="text-align:center;color:#F2BD2Bک">جزییات تماس </h4>
                        <div>
                            <p><span style="margin: 0px 5px;color: #F2BD2B;"><i class="fa fa-map ml-1"></i>آدرس:</span>
                                تهران خیابان آزادی خیابان دکتر هوشیار پلاک 81 طبقه چهارم واحد 23
                            </p>
                        </div>
                        <div>

                            <p> <span style="margin: 0px 5px;color: #F2BD2B;"><i class="fa fa-phone ml-1"></i>
                                    تماس :</span>02166037554</p>
                            <div>

                                <p style="font-size:14px"><span style="margin: 0px 5px;color: #F2BD2B;float:right;"><i class="fa fa-link ml-1"></i>
                                        ایمیل :</span>info@18charkh.com</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--map-view-wrap end -->
            <div class="brush-dec"></div>
    </section>
    <!--  section  -->
    <section class="hidden-section big-padding con-sec" data-scrollax-parent="true" id="sec3">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="column-text_inside fl-wrap dark-bg">
                        <div class="column-text">
                            <div class="section-title">
                                <h4>برای رزرو تماس بگیرید </h4>
                                <h2>ساعت کاری </h2>
                                <div class="dots-separator fl-wrap"><span></span></div>
                            </div>
                            <div class="work-time fl-wrap">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>شنبه تا چهارشنبه </h3>
                                        <div class="hours">
                                            09:30<br>
                                            18:30
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3> پنج شنبه </h3>
                                        <div class="hours">
                                            09:30<br>
                                            14:30
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="bold-separator"><span></span></div>
                            <div class="big-number"><a href="tel:+982166037554">02166037554</a></div>
                        </div>
                        <div class="illustration_bg">
                            <div class="bg" data-bg="images/bg/dec/6.png"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mt-4 mt-md-0">
                    <div class="section-title " style="text-align: center">
                        <h1 class="text-align_right text-white">تماس با ما</h1>
                        <div class="dots-separator fl-wrap"><span></span></div>
                    </div>
                    <div class="text-block ">
                        <p style="text-align: center">کاربر گرامی، برای پیگیری آگهی خود، موارد محتوایی و یا ارسال
                            پیشنهادات و انتقادات می توانید از فرم زیر نیز استفاده نمایید.
                        </p>
                    </div>

                    @if(session('message'))
                    <p class="alert alert-success">{{session('message')}}</p>
                    @endif

                    <div class="contactform-wrap">
                        <div id="message"></div>
                        <form class="custom-form" action="{{route('contact_us')}}" method="post">

                            @csrf

                            <fieldset>
                                <div id="message2"></div>
                                <div class="row" style="direction:rtl">

                                    <div class="col-sm-6">

                                        <input type="text" name="name" id="name2" placeholder="نام و نام خانوادگی  *" value="" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="text-left" name="email" id="email2" placeholder=" ایمیل *" value="" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="text-left" name='onlynumbers' id="phone2" placeholder="شماره تماس *" value="" />
                                    </div>
                                    <div class="col-sm-6">
                                        <div class=" fl-wrap">
                                            {{-- <select name="title" id="subject2"--}}
                                            {{-- class="chosen-select no-search-select">--}}
                                            {{-- <option data-display="fgfgfg">لالا</option>--}}
                                            {{-- <option value="Upcoming Events">لال اال </option>--}}
                                            {{-- <option value="Book table">اااللالok ل</option>--}}
                                            {{-- <option value="Banquet">یبی</option>--}}
                                            {{-- <option value="Banquet">یبیب</option>--}}
                                            {{-- </select>--}}
                                            <input type="text" name="title" id="phone2" placeholder="عنوان *" value="" />
                                        </div>
                                    </div>
                                </div>
                                <textarea name="content" id="comments2" cols="40" rows="3" placeholder="پیغام" style="text-align: right;"></textarea>
                                <div class="clearfix"></div>
                                <button class="btn float-btn flat-btn color-bg" type="submit">
                                    <i class="fa fa-arrow-left ml-0 mr-2 align-middle"></i>
                                    ارسال پیشنهاد
                                </button>
                            </fieldset>
                        </form>
                    </div>
                    <div class="section-dec sec-dec_top"></div>
                </div>

            </div>
        </div>
        <div class="section-bg">
            <div class="bg" data-bg="images/bg/dec/section-bg.png"></div>
        </div>
    </section>
    <!--  section end  -->
    <div class="brush-dec2 brush-dec_bottom"></div>
</div>
@endsection