<!DOCTYPE html>
 <html lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Vendor styles -->
        <link rel="stylesheet" href="{{asset('/vendors/zwicon/zwicon.min.css')}}" />
        <link rel="stylesheet" href="{{asset('/vendors/animate.css/animate.min.css')}}" />

        <!-- App styles -->
        <link rel="stylesheet" href="{{asset('/css/app.min.css')}}" />

        <title>{{config('app.name', '18Charkh')}}</title>
    </head>

    <body data-sa-theme="1">

        <form id="login_form" method="POST" action="{{ url('admin') }}">{{ csrf_field() }}
            <div class="login">

                <!-- Login -->
                <div class="login__block active" id="l-login">
                    <div class="login__block__header">
                        <i class="zwicon-user-circle"></i>
                        برای ورود به بخش مدیریت لاگین کنید
                    </div>

                    <div class="login__block__body">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control text-center" placeholder="آدرس ایمیل" />
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control text-center" placeholder="رمز عبور" />
                        </div>

                        <button type="submit" class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Javascript -->
        <!-- Vendors -->
        <script src="{{asset('/vendors/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('/vendors/popper.js/popper.min.js')}}"></script>
        <script src="{{asset('/vendors/bootstrap/js/bootstrap.min.js')}}"></script>

        <!-- App functions and actions -->
        <script src="{{asset('/js/app.min.js')}}"></script>
    </body>
 </html>