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

        <form id="login_form" action="{{ url('admin') }}" method="post">
            @csrf
            <div class="login">

                <!-- Login -->
                <div class="login__block active" id="l-login">
                    <div class="login__block__header">
                        <i class="zwicon-user-circle"></i>
                        برای ورود به بخش مدیریت لاگین کنید

                        <!--<div class="actions actions--inverse login__block__actions">-->
                        <!--    <div class="dropdown">-->
                        <!--        <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>-->

                        <!--        <div class="dropdown-menu dropdown-menu-right">-->
                        <!--            <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-register" href="login.html">Create an account </a>-->
                        <!--            <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-forget-password" href="login.html">Forgot password? </a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
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

                <!-- Register -->
               <!--<div class="login__block" id="l-register">-->
               <!--     <div class="login__block__header">-->
               <!--         <i class="zwicon-user-circle"></i>-->
               <!--     Create an account-->

               <!--         <div class="actions actions--inverse login__block__actions">-->
               <!--             <div class="dropdown">-->
               <!--                 <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>-->

               <!--                 <div class="dropdown-menu dropdown-menu-right">-->
               <!--                     <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-login" href="login.html">Already have an account? </a>-->
               <!--                     <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-forget-password" href="login.html">Forgot password? </a>-->
               <!--                 </div>-->
               <!--             </div>-->
               <!--         </div>-->
               <!--     </div>-->

               <!--     <div class="login__block__body">-->
               <!--         <div class="form-group">-->
               <!--             <input type="text" name="subject" class="form-control text-center" placeholder="نام کاربری" />-->
               <!--         </div>-->

               <!--         <div class="form-group form-group--centered">-->
               <!--             <input type="email" name="email" class="form-control text-center" placeholder="آدرس ایمیل" />-->
               <!--         </div>-->

               <!--         <div class="form-group form-group--centered">-->
               <!--             <input type="password" name="password" class="form-control text-center" placeholder="پسورد" />-->
               <!--         </div>-->

               <!--         <div class="form-group">-->
               <!--             <div class="custom-control custom-checkbox">-->
               <!--                 <input type="checkbox" name="radioDisabled" id="login-check" class="custom-control-input" />-->
               <!--                 <label class="custom-control-label" for="login-check">Accept the license agreement </label>-->
               <!--             </div>-->
               <!--         </div>-->

               <!--         <a href="index.html" class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></a>-->
               <!--     </div>-->
               <!-- </div>-->

                <!-- Forgot Password -->
               <!-- <div class="login__block" id="l-forget-password">-->
               <!--     <div class="login__block__header">-->
               <!--         <i class="zwicon-user-circle"></i>-->
               <!--     Forgot Password?-->

               <!--         <div class="actions actions--inverse login__block__actions">-->
               <!--             <div class="dropdown">-->
               <!--                 <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>-->

               <!--                 <div class="dropdown-menu dropdown-menu-right">-->
               <!--                     <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-login" href="login.html">Already have an account? </a>-->
               <!--                     <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-register" href="login.html">Create an account </a>-->
               <!--                 </div>-->
               <!--             </div>-->
               <!--         </div>-->
               <!--     </div>-->

               <!--     <div class="login__block__body">-->
               <!--         <p class="mb-5">Lorem ipsum dolor fringilla ____ feugiat commodo sed ac _____. </p>-->

               <!--         <div class="form-group">-->
               <!--             <input type="text" class="form-control text-center" placeholder="آدرس ایمیل" />-->
               <!--         </div>-->

               <!--         <a href="index.html" class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></a>-->
               <!--     </div>-->
               <!-- </div>-->
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