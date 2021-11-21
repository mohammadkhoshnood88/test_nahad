<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="{{asset('/css/reset.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('/css/plugins.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('/css/style.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('/css/dark-style.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('/css/color.css')}}">

<div class="check_code">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-lg-8" style="padding: 22px 20px;color:white;background:rgb(26, 26, 26);width: 756px;">
                <div class="form3"
                    style="background:#292929;margin:20px;border:.2px solid rgb(68, 67, 67)">
                    <div class="title" style="margin:60px 0px;font-size:30px">
                        <h2 class="mx-auto">
                            کد چهار رقمی پیامک شده به {{session()->get('phone')}} را وارد
                            کنید
                        </h2>
                    </div>
                    <fieldset class="w-100">
                        <div class="row">
                            <div class="col-sm-12 ">
                         
                                <input type="number" class="checkcode" id="checkcode" placeholder="تاییدیه کد *" value="" />
                            </div>

                            <div class="clearfix"></div>
                              <!--<a class="btn color-bg mx-auto my-3" id="btncheckcode">ارسال<i-->
                              <!--   class="fa fa-arrow-left"></i></a>-->
                              <input type="submit" class="btncheckcode btn color-bg mx-auto my-4 px-5" id="btncheckcode" value="ارسال">
                    </fieldset>

                </div>

            </div>
            <!--  sidebar end-->
        </div>
        <div class="fl-wrap limit-box"></div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {

        if ($('#alert-message').length) {
            setTimeout(function () {
                $('#alert-message').hide('slow');
            }, 4000);
        }

        $('#Confirmphone').click(function () {
            $("#cover_container").css("display", "block");
            $("#input_phone").css("display", "block");
        });

        $('#edit_phone').click(function () {
            $("#cover_container").css("display", "block");
            $("#input_phone").removeClass("hidden");
            $("#confirm_phone").addClass("hidden");
        });



        $('#phone_number').on('keydown', function () {
            $('#info-message').removeClass('text-danger');
            $('#info-message').text('');
        })



        $("#btncheckcode").on('click', function () {
            $("#btncheckcode").prop("disabled", true );
            // console.log("btn click")
            var code = $("#checkcode").val();
            var phone_number = "{{session()->get('phone')}}";
            var is_rent = document.referrer;

            if (code == "" || code.length < 4){
                $("#btncheckcode").prop("disabled", false );
                return;
            }
                
                
            $.ajax({
                url: '/userpanel/checkcode',
                data: {"code": code, "phone_number": phone_number , "_token" : "{{csrf_token()}}"},
                method: 'post',
                success: function (data) {
                    
                
                    if (data.success) {
                
                
                        if (is_rent.includes('rent'))
                        {
                            window.location.href = '/rent/verify';
                        }
                        else if (is_rent.includes('accessory'))
                        {
                            window.location.href = '/accessory/verify';
                        }
                        else if (is_rent.includes('lux'))
                        {
                            window.location.href = '/lux/verify';
                        }
                        else if (is_rent.includes('insurance'))
                        {
                            window.location.href = '/insurance/verify';
                        }
                        else
                        {
                            window.location.href = '/advertises/verify';
                        }                        

                        $("#profile").removeClass("hidden");
                    } else {
                        $("#btncheckcode").prop("disabled", false );
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا',
                            text: 'کد وارد شده اشتباه است',
                        });
                        
                    }
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        });

        $(".re_send").on('click', function () {

            var phone_number = "{{session()->get('phone')}}";

            $.ajax({
                url: '/userpanel/sendcode',
                data: {"phone_number": phone_number},
                method: 'post',
                success: function (data) {

                    $('#info-message').text('کد جدید برای شماره '+ phone_number +' ارسال شد');
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        });

});

$('#checkcode').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('#btncheckcode').click();
    return false;  
  }
}); 
</script>



