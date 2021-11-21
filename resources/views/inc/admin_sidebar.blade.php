<aside class="sidebar ">
    <div class="scrollbar">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <img class="user__img" src="{{asset('/img/profiles/8.jpg')}}" alt="user info"/>
                <div class="user--present">
                    <div class="user__name">{{auth()->user()->name}}</div>
                    <div class="user__email">{{auth()->user()->email}}</div>
                    <div class="user__email">{{auth()->user()->userpermissions[0]->role}}</div>
                </div>
            </div>

            <div class="dropdown-menu dropdown-menu--invert">
                <a class="dropdown-item" href="index.html">خروج از حساب </a>
            </div>
        </div>

        <ul class="navigation">
            <li class="{{ Request::is('admin/dashboard') ? 'navigation__active' : '' }}"><a href="/admin/dashboard"><i
                        class="zwicon-home"></i> صفحه اصلی </a></li>
            
            <li class="navigation__sub">
                <a href="index.html"><i class="zwicon-edit-square-feather"></i> ثبت آگهی </a>

                <ul>

                    <li class="selected">
                        <a href="/advertises/create"> آگهی های فروش </a>
                    </li>
                    
                    <li class="selected">
                        <a href="/admin/new_post">آگهی های فروش (ادمین)</a>
                    </li>

                    <li>
                        <a href="/rent/create"> آگهی های اجاره </a>
                    </li>
                </ul>
            </li>
            
            <li class="{{ Request::is('admin/payments') ? 'navigation__active' : '' }}"><a href="/admin/payments"><i
                        class="zwicon-coin "></i> تراکنش ها </a></li>
                        
            @if (\Illuminate\Support\Facades\Gate::any(['isAdmin', 'isOwner' , 'isIssuer']))



                <li class="navigation__sub {{ Request::is('admin/adm_manage') || Request::is('admin/rent_ads_manage') ? 'navigation__active navigation__sub--toggled' : '' }}">
                    <a href="index.html"><i class="zwicon-note"></i> مدیریت آگهی ها </a>

                    <ul style="display:{{ Request::is('admin/adm_manage') || Request::is('admin/rent_ads_manage') ? 'block' : 'none' }} ">

                        <li class="selected">
                            <a href="/admin/adm_manage"> آگهی های فروش </a>
                        </li>

                        <li>
                            <a href="/admin/rent_ads_manage"> آگهی های اجاره </a>
                        </li>
                    </ul>
                </li>


            @endif
            @if (\Illuminate\Support\Facades\Gate::any(['isAdmin', 'isOwner']))

                <li class="navigation__sub
{{Request::is('admin/adm_brand') ||
 Request::is('admin/adm_model') ||
  Request::is('admin/adm_cbody') ||
  Request::is('admin/adm_year')|| Request::is('admin/adm_state') || Request::is('admin/adm_city')? 'navigation__active navigation__sub--toggled' : '' }}">
                    <a href="#"><i class="zwicon-notebook"></i> مدیریت مشخصات فنی خودرو </a>

                    <ul
                        style="display:{{Request::is('admin/adm_brand') ||
 Request::is('admin/adm_model') ||
  Request::is('admin/adm_cbody') ||
  Request::is('admin/adm_year')|| Request::is('admin/adm_state') || Request::is('admin/adm_city')? 'block' : 'none' }}">
                        <li class="selected">
                            <a href="/admin/add_carIntro">مشخصات فنی </a>
                        </li>
                        <li>
                            <a href="/admin/adm_brand">برندها </a>
                        </li>
                        <li>
                            <a href="/admin/adm_model">مدل ها </a>
                        </li>
                        <li>
                            <a href="/admin/adm_cbody">وضعیت بدنه </a>
                        </li>
                        <li>
                            <a href="/admin/adm_year">سال تولید </a>
                        </li>
                        <li>
                            <a href="/admin/adm_state">استان ها </a>
                        </li>
                        <li>
                            <a href="/admin/adm_city">شهر ها </a>
                        </li>
                    </ul>
                </li>


                @if (\Illuminate\Support\Facades\Gate::allows('isOwner'))
                    <li class="{{ Request::is('admin/adm_user') ? 'navigation__active navigation__sub--toggled' : '' }}">
                        <a href="/admin/adm_user"><i class="zwicon-users"></i> مدیریت یوزرها </a>
                    </li>

                @endif

                <li class="navigation__sub">
                    <a href="index.html"><i class="zwicon-airplay"></i> مدیریت تبلیغات</a>

                    <ul
                        style="display:{{Request::is('admin/adm_brand') ||
 Request::is('admin/adm_model') ||
  Request::is('admin/adm_cbody') ||
  Request::is('admin/adm_year')|| Request::is('admin/adm_state') || Request::is('admin/adm_city')? 'block' : 'none' }}">
                        <li class="selected">
                            <a href="/admin/advertise/accessory">لوازم یدکی</a>
                        </li>
                        <li>
                            <a href="/admin/advertise/lux">لوازم لوکس</a>
                        </li>
                        <li>
                            <a href="/admin/advertise/insurance">بیمه</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/add_techcheckup') ? 'navigation__active navigation__sub--toggled' : '' }}">
                    <a href="/admin/add_techcheckup"><i class="zwicon-my-location"></i> مراکز معاینه فنی </a>
                </li>
            @endif
            @if (\Illuminate\Support\Facades\Gate::any(['isAdmin', 'isOwner' , 'isEditor']))

                <li class="{{ Request::is('admin/blog/index') ? 'navigation__active navigation__sub--toggled' : '' }}">
                    <a href="/admin/blog/index"><i class="zwicon-script"></i> وبلاگ </a>
                </li>
            @endif
            <li class="navigation__sub">
                <a href="index.html"><i class="zwicon-chat"></i> بررسی پیام های ارسالی </a>
                <ul>
                    <li class="selected">
                        <a href="/admin/adm_received_message"> گفتگو </a>
                    </li>

                    <li>
                        <a href="/admin/adm_offer_message"> پیشنهادات </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
