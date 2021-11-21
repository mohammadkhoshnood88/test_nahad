@extends('layout.Main')

@section('content')
    <div class="content">
        <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
        <section class="small-top-padding overflow-unset">
            <div class="brush-dec2 brush-dec_bottom"></div>
            <div class="container">
                <!--  hero-menu_header  end-->
                <div class="hero-menu single-menu  tabs-act fl-wrap">

                    <div class="row justify-content-center" style="direction:rtl">
                        <div class="col-lg-10 mt-5">
                            <form action="/userpanel/post/upgrade" method="post">
                                <div class="row flex-row-reverse">

                                    <div class="col-lg-4 mb-3rem">
                                        <div class="cart-totals dark-bg fl-wrap" style="position: sticky; top: 90px;">
                                            <h3 class="text-center">مجموع هزینه ارسال آگهی</h3>
                                            <table class="total-table">
                                                <tbody>
                                                <tr>
                                                    <th>مبلغ پرداخت :</th>
                                                    <td class="total_price">
                                                    
                                                        <?php
                                                            $total = 0;
                                                        foreach($extras as $k => $ex){
                                                            if ($k == 'urgent' && $ex == 0)
                                                                $total = $total + 25000;
                                                            if ($k == 'ladder' && $ex == 0)
                                                                $total = $total + 15000;
                                                            if ($k == 'special' && $ex == 0)
                                                                $total = $total + 46000;
                                                        }
                                                        echo $total . " تومان";

                                                        ?>

                                                    
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            @csrf
                                            <input name="post_id" value="{{$post_id}}" hidden>
                                            <button type="submit" class="cart-totals_btn color-bg">تکمیل فرایند پرداخت
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="checkboox1 custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input check_box"
                                                   data-name="special" data-price="46000"
                                                    @if(array_key_exists('special' , $extras) && $extras['special'] == 0)
                                                        checked
                                                    @endif
                                                   id="customCheck1" name="special" >
                                            <label class="checkboox custom-control-label" for="customCheck1">
                                                <div class="title">
                                                    <span class="sub-title">ویژه </span>
                                                    <span class="sub-title2">46000 تومان </span>
                                                </div>
                                                <p class="px-2"> آگهی شما تا زمان دریافت آگهی شما تا زمان دریافت تازه تر
                                                    در همان دسته بندی و شهر به عنوان دومین آگهی نمایش داده می شود</p>
                                                <div class="text-left">
                                                    <a href="#" title="#" class="navi_btn btn mr-auto">
                                                        ثبت کد هدیه
                                                        <i class="fa fa-gift text-right px-1"
                                                           style="float:right !important;margin-top: 3px;margin-right:0px;">
                                                        </i>
                                                    </a>
                                                </div>

                                            </label>
                                        </div>
                                        <div class="checkboox1 custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input check_box"
                                                   data-name="ladder" data-price="15000"
                                                    @if(array_key_exists('ladder' , $extras) && $extras['ladder'] == 0)
                                                        checked
                                                    @endif
                                                   id="customCheck2" name="ladder">
                                            <label class="checkboox custom-control-label" for="customCheck2">
                                                <div class="title">
                                                    <span class="sub-title">نردبان </span>
                                                    <span class="sub-title2">15000 تومان </span>
                                                </div>
                                                <p class="px-2"> آگهی شما تا زمان دریافت آگهی شما تا زمان دریافت تازه تر
                                                    در همان دسته بندی و شهر به عنوان دومین آگهی نمایش داده می شود</p>
                                                <div class="text-left">
                                                    <a href="#" title="#" class="navi_btn btn mr-auto">
                                                        ثبت کد هدیه
                                                        <i class="fa fa-gift text-right px-1"
                                                           style="float:right !important;margin-top: 3px;margin-right:0px;">
                                                        </i>
                                                    </a>
                                                </div>

                                            </label>
                                        </div>
                                        <div class="checkboox1 custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input check_box"
                                                   data-name="urgent" data-price="25000"
                                                    @if(array_key_exists('urgent' , $extras) && $extras['urgent'] == 0)
                                                        checked
                                                    @endif
                                                   id="customCheck3" name="urgent">
                                            <label class="checkboox custom-control-label" for="customCheck3">
                                                <div class="title">
                                                    <span class="sub-title">فوری</span>
                                                    <span class="sub-title2">25000 تومان </span>
                                                </div>
                                                <p class="px-2"> آگهی شما تا زمان دریافت آگهی شما تا زمان دریافت تازه تر
                                                    در همان دسته بندی و شهر به عنوان دومین آگهی نمایش داده می شود</p>
                                                <div class="text-left">
                                                    <a href="#" title="#" class="navi_btn btn mr-auto">
                                                        ثبت کد هدیه
                                                        <i class="fa fa-gift text-right px-1"
                                                           style="float:right !important;margin-top: 3px;margin-right:0px;">
                                                        </i>
                                                    </a>
                                                </div>

                                            </label>
                                        </div>
                                        <div class="checkboox1 custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input check_box" @if($is_active == 1 || $own_delete == 1) disabled @endif
                                                   data-name="re_active" data-price="0" id="customCheck4" name="re_active">
                                            <label class="checkboox custom-control-label" for="customCheck4">
                                                <div class="title">
                                                    <span class="sub-title">تمدید</span>
                                                    <span class="sub-title2">رایگان </span>
                                                </div>
                                                <p class="px-2"> آگهی شما تا زمان دریافت آگهی شما تا زمان دریافت تازه تر
                                                    در همان دسته بندی و شهر به عنوان دومین آگهی نمایش داده می شود</p>
                                                <div class="text-left">
                                                    <a href="#" title="#" class="navi_btn btn mr-auto">
                                                        ثبت کد هدیه
                                                        <i class="fa fa-gift text-right px-1"
                                                           style="float:right !important;margin-top: 3px;margin-right:0px;">
                                                        </i>
                                                    </a>
                                                </div>
                                            </label>
                                        </div>
                                        <a href="/userpanel/myadvertises" class="footer-widget-content-link"><i class="fal fa-long-arrow-right ml-2"></i> بازگشت به حساب کاربری</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!--  hero-menu  end-->
                    <div class="clearfix"></div>
                    <div class="bold-separator bold-separator_dark"><span></span></div>
                    <div class="clearfix"></div>
                </div>
        </section>
    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $("#checkbox1").click(function () {

                $("#div1").addClass("shadow");

            });
            $("#checkbox2").click(function () {

                $("#div2").addClass("shadow");

            });
            $("#checkbox3").click(function () {

                $("#div3").addClass("shadow");

            });
            
            
            $(".check_box").on('click', function () {
                var checked = $(this).is(":checked");

                var opt = parseInt($(this).data('price'));
                var total = parseInt($(".total_price").text());

                var a = 0;
                if (checked)
                    a = total + opt;
                else
                    a = total - opt;

                $(".total_price").text(a + " تومان")

            });
            
        });
    </script>
        
@endsection
