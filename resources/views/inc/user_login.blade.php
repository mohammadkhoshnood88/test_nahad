
<div class="reservation-modal-wrap">
    <div class="reserv-overlay crm">
        <div class="cd-reserv-overlay-layer" data-frame="25">
            <div class="reserv-overlay-layer"></div>
        </div>
    </div>
    <div class="reservation-modal-container bot-element">
        <div class="reservation-modal-item fl-wrap">
            <div class="close-reservation-modal crm"><i class="fa fa-times"></i></div>
            <div class="reservation-bg"></div>
            <div class="alert alert-success" id="alert_error" style="display: none">asdfasdfasd</div>
            <div id="form1" class="form1">
            <div class="section-title">
                <h4>فرم ورود</h4>
                <h2>جهت ورود شماره تماس خود را وارد کنید</h2>
                <div class="dots-separator fl-wrap"><span></span></div>
            </div>
            <div class="reservation-wrap">
                <div id="reserv-message"></div>
                <div class="custom-form">
                    <fieldset class="w-100">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="phone_number_reservation" placeholder="شماره تماس  *" />
                            </div>

                        <div class="clearfix"></div>
                        <button class="btn color-bg mx-auto send-code" id="reservation-submit">ارسال<i
                                class="fa fa-arrow-left"></i></button>
                    </fieldset>
                </div>

            </div>
            </div>
         <div class="form2 hide-item" id="form2">
            <div class="section-title">
                <h4>فرم ثبت نام</h4>
                <h2>  کد تاییدیه  را وارد کنید</h2>
                <div class="dots-separator fl-wrap"><span></span></div>
            </div>
            <div class="reservation-wrap">
                <div id="reserv-message"></div>
                <div class="custom-form">
                    <fieldset class="w-100">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="#" id="edit_number" class="text-left" style="float: right;color:#C19D60">اصلاح شماره تماس</a>
                                  
                                <input type="number" id="code_reservation" placeholder=" کد تاییدیه  *" />
                            </div>

                        <div class="clearfix"></div>
                        <button class="btn color-bg mx-auto" id="btncheckcode">ارسال<i
                                 class="fa fa-arrow-left"></i></button>
                        </div>
                    </fieldset>


            </div>
            </div>
            <!-- reservation-wrap end-->
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $("#edit_number").on('click', function () {
        $("#form2").hide();
        $("#form1").show(1000);
    });
    $("#phone_number_reservation").keypress(function(event){
         if(event.keyCode === 13){
             $("#reservation-submit").click();
         }
    });
    $("#code_reservation").keypress(function(event){
         if(event.keyCode === 13){
             $("#btncheckcode").click();
         }
    });
    $("#reservation-submit").on('click', function () {
        // alert('sdfasdfas')
        // return;
        var phone_number = $("#phone_number_reservation").val();
        if (phone_number == "" || phone_number.length < 11 || phone_number.indexOf('09') !== 0) {
            $('#alert_error').addClass('alert-danger');
            $('#alert_error').removeClass('alert-success');
            $('#alert_error').text('شماره موبایل معتبر نمی باشد');
            $('#alert_error').show().delay(2500).fadeOut(800);
            return;
        }

        $("#form1").hide();
        $("#form2").show(1000);
        $.ajax({
            url: '/user/send/mobile',
            data: {"phone_number": phone_number , "_token" : "{{csrf_token()}}"},
            method: 'post',
            success: function (data) {
                
            },
            error: function (exception) {
                console.log(exception);
            }
        });
    });

    $("#btncheckcode").on('click', function () {
        var code = $("#code_reservation").val();
        var phone_number = $("#phone_number_reservation").val();

        if (code == "" || code.length < 4){
            $('#alert_error').addClass('alert-danger');
            $('#alert_error').removeClass('alert-success');
            $('#alert_error').text('کد را به درستی وارد کنید');
            $('#alert_error').show().delay(2500).fadeOut(800);
        }
        $("#btncheckcode").attr("disabled", true);

            let pathname = window.location.pathname;
            
            var is_problem = sessionStorage.getItem("report_problem");
            // if(is_problem){
            //     console.log('true')
            // }
            // if(is_problem == 'true'){
            //     console.log('true srint')
            // }
            


        $.ajax({
            url: '/user/send/code',
            data: {"code": code, "phone_number": phone_number  , "_token" : "{{csrf_token()}}"},
            method: 'post',
            success: function (x) {
                // console.log("data");
                // console.log(x);
                // return;
                if (x.success) {
                    
                    
                    console.log(pathname)
                    if(is_problem === 'true'){
                        console.log("dfasdfasdfas");
                        window.location.replace(pathname);
                        return;
                    }

                    switch (pathname) {
                        case "/userpanel/myadvertises":
                            window.location.replace("/userpanel/myadvertises");
                            break;
                        case "/userpanel/markadvertises":
                            window.location.replace("/userpanel/markadvertises");
                            break;
                        case "/userpanel/offer":
                            window.location.replace("/userpanel/offer");
                            break;
                        case "/userpanel/message":
                            window.location.replace("/userpanel/message");
                            break;
                        default:
                            window.location.replace("/userpanel/myadvertises");

                    }


                } else {
                    $('#alert_error').addClass('alert-danger');
                    $('#alert_error').removeClass('alert-success');
                    $('#alert_error').text('کد را به درستی وارد کنید');
                    $("#btncheckcode").attr("disabled", false);
                    $('#alert_error').show().delay(2500).fadeOut(800);
                }
            },
            error: function (exception) {
                console.log(exception);
            }
        });
    });

</script>



