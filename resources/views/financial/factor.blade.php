@extends('layout.Main')

@section('content')
    <div class="content">
        <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
        <section class="small-top-padding">
            <div class="brush-dec2 brush-dec_bottom"></div>
            <div class="container">
                <!--  hero-menu_header  end-->
                <div class="hero-menu single-menu  tabs-act fl-wrap">

                    <div class="row justify-content-center" style="direction:rtl">
                        <div class="col-md-5">
                            <div class="cart-totals dark-bg fl-wrap">
                                <h3 class="text-center">مجموع هزینه ارسال آگهی</h3>
                                <table class="total-table">
                                    <tbody>
                                    <tr>
                                        <th>عنوان آگهی</th>
                                        <td>{{$post[0]->subject}}</td>
                                    </tr>
                                    <tr>
                                        <th>شماره تماس آگهی دهنده</th>
                                        <td>{{$post[0]->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <th>شماره تراکنش</th>
                                        <td>{{isset($transaction) ? $transaction : "-"}}</td>
                                    </tr>
                                    <tr>
                                        <th>تاریخ پرداخت</th>
                                        <td>{{\Morilog\Jalali\Jalalian::now()->format('%A, %d %B %y')}}</td>
                                    </tr>
                                    @if(isset($transaction))
                                        <tr>
                                            <th>وضعیت تراکنش</th>
                                            <td class="text-success">
                                                <i class="fa fa-check align-middle mr-1"></i>
                                                موفق
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>وضعیت تراکنش</th>
                                            <td class="text-danger">
                                                <i class="fa fa-times align-middle mr-1"></i>
                                                ناموفق
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <button type="submit" class="cart-totals_btn color-bg mb-3"
                                        onclick="printDiv('.hero-menu')">
                                    <i class="fa fa-print ml-1"></i>
                                    چاپ فاکتور
                                </button>
                                <a class="text-white" href="/userpanel/myadvertises"> بازگشت به حساب کاربری </a>
                            </div>
                        </div>

                    </div>

                    <!--  hero-menu  end-->
                    <div class="clearfix"></div>
                    <div class="bold-separator bold-separator_dark"><span></span></div>
                    <div class="clearfix"></div>
                </div>
        </section>
    </div>

    <script src="{{asset('/js/jquery.min.js')}}"></script>

    <script>
        $(window).load(function () {
            Swal.fire({
                icon: 'success',
                title: 'پرداخت با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 2000
            })
        });

        function printDiv(divName) {
            var printContents = document.querySelector(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection

