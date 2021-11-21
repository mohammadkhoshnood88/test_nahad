@extends('layouts.admin')

@section('content')
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewbox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
            </svg>
        </div>
    </div>

    <section class="content">
        <header class="content__title">

            <h1 style="text-align: right">داشبورد  <small>به بخش مدیریت کل سایت خوش آمدید</small></h1>
        </header>

        <div class="row quick-stats">

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$deactives}} </h2>
                        <small>آگهی های غیرمجاز</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">5,6,3,9,7,5,4,6,5,6,4 </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$pendings}} </h2>
                        <small>آگهی های تحت بررسی</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">9,4,6,5,6,4,5,7,9,3,6 </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$actives}} </h2>
                        <small>آگهی های منتشر شده</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">4,7,6,2,5,3,8,6,6,4,8 </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$posts}}</h2>
                        <small>تعداد کل آگهی ها</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">6,4,8,6,5,6,7,8,3,5,9 </div>
                </div>
            </div>
            
<!--            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$lux}} </h2>
                        <small>تبلیغات لوکس فروشی تحت بررسی</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">5,6,3,9,7,5,4,6,5,6,4 </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$accessory}} </h2>
                        <small>تبلیغات لوازم یدکی تحت بررسی</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">9,4,6,5,6,4,5,7,9,3,6 </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2 class="text-center">{{$insurance}} </h2>
                        <small>تبلیغات بیمه تحت بررسی</small>
                    </div>

                    <div class="quick-stats__chart peity-bar">4,7,6,2,5,3,8,6,6,4,8 </div>
                </div>
            </div>-->

        </div>

    </section>
@endsection
