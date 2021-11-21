<!-- header  -->
<div class="dark-bg1"></div>
<header class="main-header paddingTop">
    <!-- header-top  -->
    <div class="header-top p-2">
        <div class="container ">
            <div class="lang-wrap">
                {{-- <a href="#" class="act-lang">En</a><span>/</span><a href="#">FA</a>--}}
                <a class="show-share-btn htact signTop" href="/userpanel/markadvertises" style="width: 107px;">نشان شده <i class="fa fa-bookmark merk-fa mx-2"></i></a>
            </div> 
            <div class="header-top_contacts"><a href="#" ><span>شماره
                        تماس:</span>02166037554</a>
                <a href="#"  style="font-family: tahoma !important"><span >
                        آدرس ایمیل :</span>info@18charkh.com</a></div>
        </div>
    </div>
    <!--header-top end -->
    <!-- header-inner -->
    <div class="header-inner  fl-wrap">
        <div class="container px-0">
            <div class="header-container px-3 px-lg-0 border-0 fl-wrap">
              
                <div class="nav-button-wrap">
                    <div class="nav-button show-darkBg" style="margin: -8px -35px;">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <!-- nav-button-wrap end-->
                <!--  navigation -->
                <div class="nav-holder main-menu">
                    
                    <nav>
                        <ul>
                              <li>
                            <a href="/" class="logo-holder border-0"><img src="{{asset("images/logo3.png")}}" alt="logo"></a>
                            </li>
                            <li>
                                <a href="/" class="act-link">خانه </a>
                            </li>
                            <li>
                                <a href="#">ثبت رایگان آگهی
                                    <i class="fa fa-chevron-down d-none d-xl-inline"></i>
                                    <i class="fa fa-chevron-left d-xl-none"></i>
                                </a>
                                <!--second level -->
                                <ul>
                                    <li><a href="/advertises/create">فروش خودرو</a></li>
                                    <li><a href="/rent/create">اجاره خودرو</a></li>
                                    <li><a href="/insurance/create">مراکز بیمه</a></li>
                                    <li><a href="/accessory/create">فروشگاه های لوازم یدکی</a></li>
                                    <li><a href="/lux/create">فروشگاه های لوکس فروشی</a></li>
                                </ul>
                                <!--second level end-->
                            </li>
                            <li>
                                <a href="#">لیست آگهی ها
                                    <i class="fa fa-chevron-down d-none d-xl-inline"></i>
                                    <i class="fa fa-chevron-left d-xl-none"></i>
                                </a>
                                <!--second level -->
                                <ul>
                                    <li><a href="/advertises/all">لیست آگهی فروش</a></li>
                                    <li><a href="/rent/all">لیست آگهی اجاره</a></li>
                                </ul>
                                <!--second level end-->
                            </li>
                             <li>
                                <a href="#">خدمات جانبی
                                    <i class="fa fa-chevron-down d-none d-xl-inline"></i>
                                    <i class="fa fa-chevron-left d-xl-none"></i>
                                </a>
                                <!--second level -->
                                <ul>
                                    <li><a href="/insurance">لیست مراکز بیمه</a></li>
                                    <li><a href="/accessory">لیست فروشگاه های لوازم یدکی</a></li>
                                    <li><a href="/lux">لیست فروشگاه های لوکس فروشی</a></li>                                    
                                </ul>
                                <!--second level end-->
                            </li>
                            <li><a href="/blog">وبلاگ </a></li>
                            <li><a href="/rules">پشتیبانی و قوانین </a></li>
                            <li><a href="/contact">تماس با ما</a></li>
                            <li><a href="/about"> درباره ما</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- navigation  end -->
                <!-- header-cart_wrap  -->
                 
                @if(\Illuminate\Support\Facades\Request::is('userpanel/*') && session()->get('login'))


                
                
                <div class="logOut_me show-reserv_button text-center div_logout" style="float: left;" data-login="{{session()->get('login')}}">
                    <span>خروج از حساب</span
                </div>
                
                @else
                 <div class="show-reserv_button show-rb text-center userIcon"  style="float: left; border:none !important" data-login="{{session()->get('login')}}"><span>
                    <img src="{{asset("images/user2.png")}}" alt="user"> </span> 
                </div>
                 <div class="show-share-btn showshare htact shaire"  style="float: left;border:none !important"><i  class="fa fa-share-alt share-icon mt-3 fa-lg "></i></div>
            
                 <div class="share-wrapper isShare">
                    <div class="share-container fl-wrap"></div>
                </div>
                
                @endif
                
                <!-- share-wrapper-end -->
            </div>
            <div class="progress-container">
                  <div class="progress-bar" id="myBar"></div>
                </div> 
        </div>
    </div>
    <!-- header-inner end  -->
</header>
<script>
// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

function myFunction() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
}
</script>

<!--header end -->
  