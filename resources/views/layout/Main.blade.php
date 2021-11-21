<!DOCTYPE html>
<html lang="en">

<head>
<!--=============== basic  ===============-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="" />
    <meta http-equiv="Content-Language" content="fa">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="og:title" property="og:title" content="18 چرخ تخصصی ترین مرجع ثبت آگهی ماشین سنگین و نیمه سنگین">
    @yield('ownpage_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('header')18چرخ</title>
    <!--=============== css  ===============-->    
    <link type="text/css" rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}" media="all">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/reset.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/plugins.css')}}" media="all">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/dark-style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/color.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/PopUp_style.css')}}">
    <!--=============== favicons ===============-->
    <link rel="shortcut icon" href="{{asset('/images/logo3.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="{{asset('/css/message.min.css')}}" />
    @yield('style')
    
</head>

<style>
    body {
        font-family: 'num' !important;
    }
    
</style>
<style>
    .swal-footer{
        text-align:center;
    }
      .loading_18charkh {
        color: #f3cd7b;
        letter-spacing: 1rem;
        font-size:40px !important;        
        text-transform: uppercase;
        vertical-align: middle;
        font-family: 'num' !important;
      }
      .loading_18charkh span {
        animation: blur 1.5s alternate infinite;
        font-size:40px !important;
        font-family: 'num' !important;
      }

      @keyframes blur {
        to {
          filter: blur(5px);
        }
      }
    </style>

<body>

    <div class="loader-wrap">
             <div class="loader-item">
                 <img id="loader-icon" src="{{ asset('/images/loaderIMG.png') }}" alt="">
                 <div class="loading_18charkh mt-5">18CHARKH</div>
             </div>
        </div>    
    
      <div id="main">
    
        @include('inc.header')
        <div id="wrapper">
            @yield('content')
            <div class="height-emulator fl-wrap"></div>

            @include('inc.footer')
        </div>
        
       @include('inc.user_login')
        <div class="element">
            <div class="element-item"></div>
        </div>
    </div>
    
      <script src="{{asset('/js/lazysizes.min.js')}}" async></script>
    <script>
    let loading = document.querySelector(".loading_18charkh");
    let letters = loading.textContent.split("");
    loading.textContent = "";
    letters.forEach((letter, i) => {
      let span = document.createElement("span");
      span.textContent = letter;
      span.style.animationDelay = `${i / 5}s`;
      loading.append(span);
    });
  </script>
    <!-- Popper JS -->
    <script src="{{asset('/js/popper.min.js')}}"></script>

    <!-- Latest compiled JavaScript -->
    <script defer src="{{asset('/js/bootstrap.min.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCe2q1gFSd75jKUnTDPq0nZWaMlEu6vL30"></script>
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script defer src="{{asset('/js/plugins.js')}}"></script>
    <script defer src="{{asset('/js/scripts.js')}}"></script>
    <script defer src="{{asset('/js/map.js')}}"></script>
    <script src="{{asset('/js/images.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    
    <script>
          sessionStorage.removeItem('report_problem');
        $(".div_logout").on('click' , function(){
            window.location.href = '/userpanel/logout';
        })
    </script>


    @yield('scripts')
</body>
</html>
