@extends('layout.Main')

@section('content')
    <div class="content" style="direction: rtl">
        <!--  section  -->
        <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
        <!--  section  end-->
        <!--  section  -->
        <section class="hidden-section">
            <div class="container">
                <!-- CHECKOUT TABLE -->
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="cart-title">کارت شما
                            @if(count($cart) > 0)
                                <span id="count-cart">دارای {{count($cart)}} سفارش است</span>
                            @else
                                <span>سفارش فعال ندارد</span>
                            @endif

                        </h4>
                        <table class="table table-border checkout-table">
                            <tbody class="checkout-body">
                            <tr>
                                <th>آیتم</th>
                                <th>نام سفارش</th>
                                <th>مدت زمان اجرایی</th>
                                <th>قیمت</th>
                                <th></th>
                            </tr>
                            @foreach($cart as $c)
                                <tr class="cart-box">
                                    <td>
                                        <h6 class="cart_counter">{{$loop->index + 1}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="product-name">{{option_name($c->option_name)}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="order-money">{{$c->option_name === "special" ? "48 ساعت" : "-"}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="order-money">{{option_price($c->option_name , $c->option_id)}} هزار تومان</h6>
                                    </td>
                                    <td class="pr-remove">
                                        <a title="Remove" data-id="{{$c->id}}"
                                           data-type="{{$c->option_name}}"
                                           data-price="{{option_price($c->option_name , $c->option_id)}}"
                                           class="remove_option"><i
                                                    class="fal fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <a href="/userpanel/post/{{$id}}/upgrade" class="footer-widget-content-link mb-3"><i class="fal fa-long-arrow-right ml-2"></i> بازگشت به صفحه ارتقاء</a>
                    </div>
                    <div class="col-md-4">
                        <!-- CART TOTALS  -->
                        <div class="cart-totals dark-bg fl-wrap">
                            <h3>مجموع هزینه ها</h3>
                            <table class="total-table">
                                <tbody>
                                    <tr>
                                        <th>هزینه ثبت آدرس های اینترنتی</th>
                                        <td class="inside">
                                            <?php
    
                                            $total = 0;
                                            foreach ($inside as $opt) {
                                                $total = $total + option_price($opt->option_name , $opt->option_id);
                                            }
                                                echo $total * 1000 . " تومان";
;
    
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>هزینه خدمات ویژه انتخابی</th>
                                        <td class="outside">
                                            <?php
    
                                            $total = 0;
                                            foreach ($outside as $opt) {
                                                $total = $total + option_price($opt->option_name , $opt->option_id);
                                            }
                                                echo $total * 1000 . " تومان";
    
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>مجموع :</th>
                                        <td class="total">
                                            <?php
    
                                            $total = 0;
                                            foreach ($outside as $opt) {
                                                $total = $total + option_price($opt->option_name , $opt->option_id);
                                            }
                                            foreach ($inside as $opt) {
                                                $total = $total + option_price($opt->option_name , $opt->option_id);
                                            }
                                                echo $total * 1000 . " تومان";
    
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            @if(count($cart) == 1 && $cart[0]->option_name == 're_active')

                            <form action="{{route('request_pay' , ['id' => $id])}}" method="POST" id="cart_form">
                                @csrf
                                <button type="submit" id="btn_cart" class="cart-totals_btn color-bg click_btn_zarin">
                                            اعمال درخواست تمدید مجدد
                                </button>
                            </form>                                            
                                            
                            @else

                            <form action="{{route('request_pay' , ['id' => $id])}}" method="POST" id="cart_form">
                                @csrf
                                <button type="submit" id="btn_cart" class="cart-totals_btn color-bg click_btn_zarin">
                                            پرداخت از طریق کارت‌های شتاب
                                </button>
                            </form>
                                            
                                            
                            @endif
                            
                            
                        </div>
                        <!-- /CART TOTALS  -->
                    </div>
                </div>
                <!-- /CHECKOUT TABLE -->
            </div>
        </section>
        <!--  section end  -->
        <div class="brush-dec2 brush-dec_bottom"></div>
    </div>


@endsection

@section('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
    
        $("#cart_form").submit(function (e) {
                    $("#btn_cart").attr("disabled", true);
                        return true;
                });
    

        $('.remove_option').on('click', function () {
            var id = $(this).data('id');
            var type = $(this).data('type');
            var price = $(this).data('price');

            var total = parseInt($(".total").text());

            var option = $(this).closest('.cart-box');
            
            var count_cart = "{{count($cart)}}";

            var pt = "";
            if (type === "instagram" || type === "website")
                pt = ".inside";
            else
                pt = ".outside";

            var side = parseInt($(pt).text());

                swal({
                  title: 'آگهی پاک شود؟',
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                  buttons: ["انصراف", "بله پاک شود"],
                })
                .then((willDelete) => {
                  if (willDelete) {
                      
                      
                    $.ajax({
                        url: '/userpanel/financial/option/remove',
                        data: {'id': id, "_token": "{{csrf_token()}}"},
                        method: 'post',
                        success: function (x) {
                            if (x.success) {

                                   
                    swal("با موفقیت حذف شد !", {
                      icon: "success",
                      buttons: {
                        cancel: "بستن"
                       },
                    });
                                option.remove();

                                var a = side - (price*1000);
                                $(pt).text(a + "تومان");
                                var b = total - (price*1000);
                                $(".total").text(b + "تومان")
                                var text = " دارای" + " " + (count_cart-1) + " سفارش است"
                                $("#count-cart").text(text)
                                count_cart = count_cart - 1

                            }

                        },
                        error: function (exception) {
                            console.log(exception);
                            swal("حذف صورت نگرفت !", {
                      icon: "info",
                      buttons: {
                        cancel: "بستن"
                       },
                    });
                        }

                    });
                      
                   
                  } else {
                    swal("حذف صورت نگرفت !", {
                      icon: "info",
                      buttons: {
                        cancel: "بستن"
                       },
                    });
                  }
            });


            // swal({
            //     customClass: 'dirAlert',
            //     title: 'آگهی پاک شود؟',
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'بله، پاک شود',
            //     cancelButtonText: 'خیر'
            
            // }).then((result) => {
            //     if (result.isConfirmed) {

            //         

            //     }
            // })

        });
    
    
        // let table = Array.from(document.querySelector('.checkout-body').children);
        // table.forEach(element => {
            // let tr = element.classList.contains('cart-box'); // true
            // console.log(tr)
            // if (tr !== true) {
            //   setTimeout(function() {
            //     location.replace("https://18charkh.com/userpanel/myadvertises")
            //     },3000)
            // console.log(tr)
            // }
        // })
        // if (table.length = 1) {
        //     setTimeout(function() {
        //         location.replace("https://18charkh.com/userpanel/myadvertises")
        //     },3000)
        // }
        

    </script>
    <!--<script>-->
        
    <!--    $('.click_btn_zarin').on('click', function () {-->
          
                // alert($(this).data('id'))
                // return;
    <!--            data = array()-->
    <!--            data['id'] = $(this).data('id')-->
                    
                
                
    <!--            alert(data)-->
    <!--            return;-->
                
    <!--            window.post = function('userpanel/financial/pay', data) {-->
    <!--                return fetch(url, {method: "POST", body: JSON.stringify(data)});-->
    <!--            }-->
          
                // swal({
                //   title: "در حال انتقال به درگاه پرداخت"
                //   icon: "info",
                //   buttons: false,
                //   dangerMode: false,
                // })
            
    <!--    })-->
        
        
    <!--</script>-->


@endsection