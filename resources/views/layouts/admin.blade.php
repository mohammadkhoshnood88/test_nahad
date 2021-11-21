<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{asset('/vendors/zwicon/zwicon.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/animate.css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/overlay-scrollbars/OverlayScrollbars.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/fullcalendar/core/main.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/fullcalendar/daygrid/main.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/select2/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/dropzone/dropzone.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/flatpickr/flatpickr.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/nouislider/nouislider.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/trumbowyg/ui/trumbowyg.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/vendors/rateyo/jquery.rateyo.min.css')}}" />

    <!-- App styles -->
    <link rel="stylesheet" href="{{asset('/css/app.min.css')}}" />

    <!-- Admin Style -->
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}" />

    <!-- Demo only -->
    <link rel="stylesheet" href="{{asset('/css/demo.css')}}" />
    
    <!-- customize -->
    <link rel="stylesheet" href="{{asset('/css/custom.css')}}" />

    @yield('header-scripts')



    <title>پنل ادمین 18 چرخ</title>
</head>
<body data-sa-theme="1">
    
    <div  id="notification" class="notif" style="display:none">
        <div class="container">
            <div class="row">
                <div class="notif-body">
                    <div class=" alert-box">
                    <img src="{{asset('/images/icons/notificationIcon.png')}}" class="img-fluid img-alert" alt="">
                   </div>
                    <p id="notif_text">یک آگهی جدید ثبت شد </p>
                    <span class="notifCloseIcon" onclick="closeNotif()">×</span>
                </div>
            </div>
        </div>
    </div>
    
	@include('inc.admin_header')
	@include('inc.admin_sidebar')
	@include('inc.admin_themes')

	<main class="main">
        @include('inc.massages')
		@yield('content')
	</main>

	@include('inc.admin_footer')


	<!-- Javascript -->
	<!-- Vendors -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


	<script src="sweetalert2.all.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	{{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

	<script src="{{asset('/vendors/jquery/jquery.min.js')}}"></script>

	<script src="{{asset('/vendors/popper.js/popper.min.js')}}"></script>
	<script src="{{asset('/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/vendors/overlay-scrollbars/jquery.overlayScrollbars.min.js')}}"></script>

	<script src="{{asset('/vendors/flot/jquery.flot.js')}}"></script>
	<script src="{{asset('/vendors/flot/jquery.flot.resize.js')}}"></script>
	<script src="{{asset('/vendors/flot/flot.curvedlines/curvedLines.js')}}"></script>
	<script src="{{asset('/vendors/peity/jquery.peity.min.js')}}"></script>
	<script src="{{asset('/vendors/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{asset('/vendors/jqvmap/maps/jquery.vmap.world.js')}}"></script>
	<script src="{{asset('/vendors/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
	<script src="{{asset('/vendors/fullcalendar/core/main.min.js')}}"></script>
	<script src="{{asset('/vendors/fullcalendar/daygrid/main.min.js')}}"></script>

	<script src="{{asset('/vendors/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
	<script src="{{asset('/vendors/select2/js/select2.full.min.js')}}"></script>
	<script src="{{asset('/vendors/dropzone/dropzone.min.js')}}"></script>
	<script src="{{asset('/vendors/flatpickr/flatpickr.min.js')}}"></script>
	<script src="{{asset('/vendors/nouislider/nouislider.min.js')}}"></script>
	<script src="{{asset('/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
	<script src="{{asset('/vendors/trumbowyg/trumbowyg.min.js')}}"></script>
	<script src="{{asset('/vendors/rateyo/jquery.rateyo.min.js')}}"></script>
	<script src="{{asset('/vendors/jquery-text-counter/textcounter.min.js')}}"></script>
	<script src="{{asset('/vendors/autosize/autosize.min.js')}}"></script>

	<!-- Vendors: Data tables -->
	<script src="{{asset('/vendors/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/vendors/datatables/datatables-buttons/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('/vendors/datatables/datatables-buttons/buttons.print.min.js')}}"></script>
	<script src="{{asset('/vendors/jszip/jszip.min.js')}}"></script>
	<script src="{{asset('/vendors/datatables/datatables-buttons/buttons.html5.min.js')}}"></script>


	<!-- App functions and actions -->
	<script src="{{asset('/js/app.min.js')}}"></script>
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
	
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    	<script>
    	
    	


      	function closeNotif() {
            $("#notification").removeClass("notif");
            $("#notification").addClass("notifup");
        }

    
        $(function () {
            var url = window.location.pathname
            // alert(url)

            Pusher.logToConsole = true;

            var pusher = new Pusher('64822af523b84ea0b333', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('new_post_channel');
                        channel.bind('new_post_event', function (data) {
                
                if(data.is_rent == "0"){
                    
                    $('#table-post tr:first').after(`
                
                    <tr class="post_box">
                                    <td scope="row">1</td>
                                    <td style="width: 150px"><img class="img-rounded"
                                                                  src="/post_images/related_images_watermark/${data.image}"
                                                                  alt="" style="width: 100%"></td>
                                    <td>${data.subject}</td>
                                    <td>${data.mobile}</td>
                                    <td class="post_status">
                                <p style='color:#00bcd4'>تایید شد</p> / <p style='color:red'>منتشر نشد</p>
                    </td>
                    <td>
                        <button type="submit" data-id="${data.id}" class="btn btn-outline-danger btnSwall remove_btn">حذف</button>
                                    </td>
                                    <td>
                                        <a href="/admin/${data.id}/edit" class="btn btn-outline-info btnSwall"
                                           onclick="btnSwall();" style="font-family: 'YJ' ; padding: 6px!important;">ویرایش</a>
                                    </td>
                                </tr>
                
                `)    
                
                }else if(data.is_rent == 1){
                    
                    $('#table-rent tr:first').after(`
                
                    <tr class="post_box">
                                    <td scope="row">1</td>
                                    <td style="width: 150px"><img class="img-rounded"
                                                                  src="/post_images/related_images_watermark/${data.image}"
                                                                  alt="" style="width: 100%"></td>
                                    <td>${data.subject}</td>
                                    <td>${data.mobile}</td>
                                    <td class="post_status">
                                <p style='color:#00bcd4'>تایید شد</p> / <p style='color:red'>منتشر نشد</p>
                    </td>
                    <td>
                        <button type="submit" data-id="${data.id}" class="btn btn-outline-danger btnSwall remove_btn">حذف</button>
                                    </td>
                                    <td>
                                        <a href="/admin/${data.id}/edit" class="btn btn-outline-info btnSwall"
                                           onclick="btnSwall();" style="font-family: 'YJ' ; padding: 6px!important;">ویرایش</a>
                                    </td>
                                </tr>
                
                `)
                
                }
                
                
                if(data.is_rent == 0 &&  url != "/admin/adm_manage"){
                    
                    $("#notif_text").text("آگهی فروش جدید ثبت شد")                          
                    $("#notification").show();

                    
                }
                
                if(data.is_rent == 1 &&  url != "/admin/rent_ads_manage"){
                    
                    $("#notif_text").text("آگهی اجاره جدید ثبت شد")                          
                    $("#notification").show();
  
                    
                }
                
        var id = window.setTimeout(function() {
         closeNotif()
         }, 4000);    	
    	


                
            });


        })
        
        $(".clear_payment").on('click' , function(){
            
            
            $.ajax({
                url: '/admin/clear/payment',
                data: {},
                method: 'post',
                success: function (x) {
                    console.log(x)

                },
                error: function (exception) {
                    console.log(exception);
                }

            });            
            
        })

    </script>

	
	@yield('scripts')


</body>
</html>
