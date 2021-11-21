@extends('layout.Main')

@section('style')
    <style>
        .closee {
            cursor: pointer;
        }
        
        .swal-footer {
            text-align:center;
        }
        .swal-button--confirm{
            background : #28A745;
        }
        .swal-button--cancel{
            background : #DC3545;
            color : white;
        }
        
    </style>
    
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

@endsection

@section('content')
    <div class="content">
        <!--  section  -->
        <section class="parallax-section hero-section hidden-section" data-scrollax-parent="true"></section>
        <!--  section  end-->
        <!--  section  -->
        <section class="small-top-padding">
            <div class="brush-dec2 brush-dec_bottom"></div>
            <div class="container">
                <!--  hero-menu_header  end-->
                <div class="hero-menu single-menu  tabs-act fl-wrap">
                    <div class="gallery_filter-button btn">نمایش فیلترها <i class="fal fa-long-arrow-down"></i>
                    </div>
                    <!--  hero-menu_header-->
                    <div class="hero-menu_header fl-wrap gth" style="direction: rtl">
                        <ul class="no-list-style" id="myTab" role="tablist">
                            <li class="tab_parent">
                                <a class="nav-link mr-0 navi_tab" id="btn_myads" data-toggle="tab"
                                   href="{{url('userpanel/myadvertises')}}" role="tab" aria-controls="home"
                                >آگهی های من</a>
                            </li>
                            <li class="tab_parent">
                                <a class="nav-link mr-0 navi_tab" id="btn_markads" data-toggle="tab"
                                   href="{{url('userpanel/markadvertises')}}" role="tab" aria-controls="home1"
                                >نشان شده</a>
                            </li>
                            {{--<li class="tab_parent">--}}
                            {{--<a class="nav-link navi_tab" id="btn_markads"--}}
                            {{--href="{{url('userpanel/markadvertises')}}">نشان شده</a>--}}
                            {{--</li>--}}
                            <li class="tab_parent">
                                <a class="nav-link navi_tab" id="btn_offer" data-toggle="tab"
                                   href="{{url('userpanel/offer')}}">خبر از تو</a>
                            </li>
                            <li class="tab_parent">
                                <a class="nav-link navi_tab" id="btn_lateral" data-toggle="tab"
                                    href="{{url('userpanel/lateral')}}" role="tab">
                                    آگهی جانبی
                                </a>
                            </li>
                            <li class="tab_parent">
                                <a class="nav-link navi_tab" id="btn_message" data-toggle="tab"
                                   href="{{url('userpanel/message')}}" role="tab">گفتگو با ادمین</a>
                            </li>
                        </ul>
                    </div>
                    <!--  hero-menu_header  end-->
                    <!--  hero-menu_content   -->
                    <div class="hero-menu_content fl-wrap">
                        <div class="tabs-container">
                            <div class="tab">
                                <!--tab -->

                                <div class="tab-content first-tab">
                                    @yield('inner_tab')
                                </div>

                            </div>
                            <!--tabs end -->
                        </div>
                    </div>
                    <!--  hero-menu_content end  -->
                </div>
                <!--  hero-menu  end-->
                <div class="clearfix"></div>
                <div class="bold-separator bold-separator_dark"><span></span></div>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
@endsection


@section('scripts')

    <script>
        $(".btn-message").attr('disabled' , true);
        $(".btn-message").css("opacity" , "0.5");
        $("textarea").on('keyup',function() {
            var messageBox = $("textarea").val();
               if( messageBox != '')
           {
            $(".btn-message").attr('disabled' , false);
            $(".btn-message").css("opacity" , "1");
           }
           else
           {
            $(".btn-message").attr('disabled' , true);
            $(".btn-message").css("opacity" , "0.5");
           }
        });
        $(document).ready(function () {
            
            
            Pusher.logToConsole = true;

            var pusher = new Pusher('64822af523b84ea0b333', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('message_channel');
            channel.bind('message_event', function(data) {
                var user_id = "{{session()->get('user_send_message_id')}}";
                if(user_id === data.userId){
                    $('.message_body_a').append(
                        `<div class='messages__item'>
                             <img src="https://18charkh.com/images/avatar/admin.png" class='avatars-img' />

                             <div class='messages__details'>
                                 <p class='text-justify'>${data.content}</p>
                                 <small><i class='zwicon-clock'></i></small>
                             </div>
                         </div>`
                    )
                }

            });
            
            
            $('.send_ajax_btn').on('click', function () {
                
                
                var a = $('.content_ajax_message').val();
                if(a === ""){
                    return;
                }
                $('.content_ajax_message').val("")
                $.ajax({
                url: '/userpanel/message',
                data: {"message" : a},
                method: 'post',
                success: function (x) {

                    if(x.success){

                        var options = `<div class="messages__item messages__item--right">
                             <div class="messages__details">
                                 <p>${a}</p>
                                 <small><i class="zwicon-clock"></i>${x.time}</small>
                             </div>
                         </div>`
                         
                        //  console.log(options);

                        $('.content_chat').append(options);
                        
                    }
                    
                    },

                error: function (exception) {
                    console.log(exception);
                }

            });

            });
        
            
            

            $('.navi_tab').on("click", function () {
                let url = $(this).attr('href');
                // alert(url);

                window.location.replace(url);
            });

            let pathname = window.location.pathname;
            // alert(pathname);
            let btn = null;

            switch (pathname) {
                case '/userpanel/myadvertises':
                    btn = $('#btn_myads');
                    break;
                case '/userpanel/markadvertises':
                    btn = $('#btn_markads');
                    break;
                case '/userpanel/offer':
                    btn = $('#btn_offer');
                    break;
                case '/userpanel/message':
                    btn = $('#btn_message');
                    break;
            }

            $('.tab').map((index, button) => {
                $(button).removeClass('active')
            })
            if (btn) {
                // alert('active');
                var p = btn.closest("li");
                p.addClass('current')
            }
            
            
            $(function () {
            $('.delete_btn').on('click', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                var types = $(this).data('type');
                var ads = $(this).closest('.ads_box');
                let url = "/delete/mark";
                let method = 'POST';
                let data = {'id': id, 'type' : types , '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        // console.log(response);
                        if (response.success) {
                            ads.remove();
                        }
                    },
                    error: function (xhr) {
                        alert('ارتباط با سرور قطع شده است.');
                        console.log(xhr)
                    }

                });
                
            });
        });
            
            
            
         $('#state').on('change', function () {
            var stateId = $(this).val();
            $('.state').val(stateId);
            $("#cityy").html('<option value="">شهر مورد نظر را وارد نمایید</option>');
            if (stateId == "")
                return;

            var pdata = {"stateId": stateId, "_token": "{{csrf_token()}}"};
            $.ajax({
                url: '/posts/getCity',
                data: pdata,
                method: 'post',
                success: function (x) {
                    // console.log(x);
                    var options = "";
                    x.data.forEach(op => {
                        options += `<option class="list_dropdown_option" value='${op.id}'>${op.name}</option>`
                    });

                    $('#cityy').append(options);
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });   


                $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            $('.closee').on('click', function () {
                var state = $("#state_id").data('id');
                var city = $("#city_id").data('id');
                var type = $("#type").data('id');
                var driver = $("#d_status").data('id');
                var data = {driver, type, city, state};
                var name = $(this).data('name');
                
                data[name] = null;
                if (name == "state") {
                    data["city"] = null;
                }
                // console.log(data)
                // return;

                if (data["state"] == null && data["city"] == null && data["type"] == null && data["driver"] == null) {
                    $('#result').html(`<div class="alert_Noresult my-4 text-center w-100"><h4>درخواستی برای جست و جو وجود ندارد</h4></div>`);
                } else {
                    $('#result').html(`<div class="alert_Noresult my-4 text-center w-100"><h4>باید بگردم ...</h4></div>`);
                }


                $.ajax({
                    type: 'POST',
                    url: '/tenant/get/ajax',
                    data: data,
                    success: function (data) {
                        // console.log("salam")
                        // console.log(data)


                        if (data) {
                            // console.log(data)


                            var posts = data.data;
                            var nullOffer = data.null_offer;
                            var boxes = "";
                            posts.forEach(function (value) {
                                // console.log(value);
                            });
                            posts.forEach(post => {

                                var date = new Date(post.created_at).toLocaleDateString('fa-IR');

                                // description ////////////
                                var desc = post.description;

                                var description = ""
                                
                                t = desc.split(" ")
                                
                                if (t.length >= 4) {
                                    for (var o = 0; o < 4; o++){
                                        description = description + t[o] + " ";
                                    }
                                        description += "..."
                                            }
                                else{
                                    description = desc
                                }
                                
                                // subject ////////////
                                var subj = post.subject;

                                var subject = ""
                                
                                t = subj.split(" ")
                                
                                if (t.length >= 3) {
                                    for (var o = 0; o < 3; o++){
                                        subject = subject + t[o] + " ";
                                    }
                                        subject += "..."
                                            }
                                else{
                                    subject = subj
                                }                                
                                
                                
                                


                                // for url
                                 var url = post.subject.replaceAll(' ' , "_");
                                 url = url.replaceAll("/" , "_");


                                boxes += `
            <div class="col-md-3 d-block gallery-item desserts" style="position: absolute; right: unset !important; left: unset !important;direction: rtl">
                <div class="grid-item-holder hov_zoo">
                    <img src="/post_images/related_images_watermark/${post.image_path}" alt="related_images_watermark">
                </div>
                <div class="grid-item-details">
                    <a href="/advertises/show/${post.id}/${url}">
                        <h3 class="text-right">${subject}<span>اجاره ای</span></h3>
                        <p class="text-right">${description}</p>
                    </a>
                    <div class="grid-item_price mb-0 mt-4">
                        <span class="pt-2">${date}</span>
                    </div>
                </div>
            </div>`;
                            });

                            if (boxes) {
                                // $('#result').empty();
                                $('#result').css('height' , 'unset');
                                
                                $('#result').html(boxes);
                            } else if (!nullOffer) {
                                $('#result').html(``);
                                $('#last_search').html(``);
                            } else {
                                $('#result').html(`
                            <div class="alert_Noresult my-4 text-center w-100"><h4>فعلا چیزی پیدا نشد، برو خبرت می کنم</h4></div>`);
                            }

                        } else {
                            $('#result').html(`
                            <div class="alert_Noresult my-4 text-center w-100"><h4>فعلا چیزی پیدا نشد، برو خبرت می کنم</h4></div>`);
                        }
                    },
                    error: function (err) {
                        $('#result').html('<div class="alert_Noresult my-4 text-center w-100"><h4>دریافت اطلاعات به مشکل خورد</h4></div>');
                        // console.log(err);
                    }
                });


                if (name == "state") {
                    let aa = $(".city_after_state");
                    aa.remove();
                }
                let parent = $(this).closest('.closebadge');
                parent.remove();
            });
        });

        function city_name(id) {
            $.ajax({
                type: 'POST',
                url: '/get/ajax/city',
                data: {id: id},
                success: function (data) {
                    return data;
                }
            });
        }

            $(".remove_lateral").on('click' , function () {
                var id = $(this).data('id');
                var typ = $(this).data('type');
                
                
                let ads = $(this).closest('.post_box');
                
                
                    swal({
                        title: "آیا مطمئن هستید؟",
                        text: "بعد از حذف آگهی شما هیچ دسترسی به آن نخواهید داشت",
                        icon: "warning",
                            buttons: [
                                'خیر',
                                    'بله'
                              ],
                            dangerMode: false,
                            confirmButtonColor: '#28A745',
                        }).then(function(isConfirm) {
                        if (isConfirm) {
                            var url = "/userpanel/" + typ + "/destroy"

                            
                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: {id : id , '_token':"{{csrf_token()}}"},
                                success: function (data) {
                                    // console.log("salam")
                                    // console.log(data);
                                    
                                    ads.remove();

                                },
                                error: function () {
                                swal({
                                title: 'ارتباط با سرور قطع شد',
                                icon: 'error'
                        });
                                }
                            });
                            
                            swal({
                                title: 'حذف شد',
                                icon: 'success',
                                buttons: false,
                                timer: 1800,
                        })
                        }
                        
                        else {
                                swal({
                                title: 'حذف نشد',
                                icon: 'error',
                                buttons: false,
                                timer: 1800,
                        })
                        }
                        })
                
            });

        });
        
        $('.messages__content').scrollTop($('.messages__content')[0].scrollHeight);
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    

@endsection
