@extends('layouts.admin')

@section('header-scripts')

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        .exam-name {
            font-size: 14px;
            color: white;
            width: 100%;
            text-align: right;
            margin-bottom: 5px;
            margin-top: 3px;
            margin-right: 5px;
            display: inline-block;
            padding: 6px 12px;
            line-height: 1.42857143;
            vertical-align: middle;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.2);
        }

        .content-msg {
            width: 90%;
            background: rgba(0, 0, 0, .1);
            padding: 10px 5px;
            margin: 0 auto;
        }
    </style>

@endsection

@section('content')

    
    
    <section class="content">
        <div class="content__inner">
         <header class="content__title text-right">
             <h1>پیام های دریافت شده  <small>برای پاسخ به هر پیام روی آن کلیک کنید</small></h1>
         </header>
        
         <div class="messages">
             <div class="messages__sidebar">
                 <div class="toolbar toolbar--inner">
                     <div class="toolbar__label">{{auth()->user()->name}} </div>
        
                     <div class="actions toolbar__actions">
                         <a href="messages.html" class="actions__item zwicon-plus"></a>
                     </div>
                 </div>
        
                 <div class="messages__search">
                     <div class="form-group">
                         <input type="text" class="form-control" placeholder="جستجو ..." />
                     </div>
                 </div>
        
                 <div class="listview listview--hover">
                     <div class="scrollbar">
                         <div class="new_mobile">
                         @foreach($chats as $chat)
                         <a class="listview__item enter_chat" data-id="{{$chat->last()->user_id}}"
                         id="user{{$chat->last()->user_id}}" data-mobile="{{$chat->last()->mobile()}}">
                             <img src="{{asset('/img/profiles/' . rand(1,8) .'.jpg')}}" alt="" class="avatar-img" />
        
                             <div class="listview__content text-right">
                                 <div class="listview__heading">{{$chat->last()->mobile()}}</div>
                                <p class="new_msg_content">
                                     {{Str::words($chat->first()->content, $words = 4, $end = '...')}}
                                 </p>
                             </div>
                         </a>
                         @endforeach
                         </div>

                     </div>
                 </div>
             </div>
        
             <div class="messages__body chat_body" style="display : none">
                 <div class="messages__header">
                     <div class="toolbar toolbar--inner mb-0">
                         <div class="toolbar__label mobile_chat"></div>
        
                         <div class="actions toolbar__actions">
                             <i class="actions__item zwicon-search" data-sa-action="toolbar-search-open"></i>
                             <a href="messages.html" class="actions__item zwicon-clock"></a>
                             <a href="messages.html" class="actions__item zwicon-info-circle"></a>
                             <div class="dropdown actions__item">
                                 <i class="actions__item zwicon-more-h" data-toggle="dropdown"></i>
                                 <div class="dropdown-menu dropdown-menu-right">
                                     <a href="messages.html" class="dropdown-item">Refresh </a>
                                     <a href="messages.html" class="dropdown-item">Delete all </a>
                                     <a href="messages.html" class="dropdown-item">Settings </a>
                                 </div>
                             </div>
                         </div>
        
                         <div class="toolbar__search">
                             <input type="text" placeholder="جستجو ..." />
                             <i class="toolbar__search__close zwicon-arrow-left" data-sa-action="toolbar-search-close"></i>
                         </div>
                     </div>
                 </div>
        
                 <div class="messages__content" id="messages__content">
                     <div class="scrollbar content_chat">
                         
                     </div>
                 </div>
        
                 <div class="messages__reply answer_box">
                     <textarea class="messages__reply__text answer_text" placeholder="نوشتن پیام ..."></textarea>
                     <button class="btn btn-theme-dark btn--icon send-possition answer_btn"><i class="zwicon-send"></i></button>
                 </div>
             </div>
         </div>
        
        </div>
    </section>

@endsection

@section('scripts')

    <script>
    
        $(function () {
            
            
            var users = []
            @foreach($chats as $c)
            users.push(parseInt("{{$c->last()->user_id}}"))
            @endforeach
            

            Pusher.logToConsole = true;

            var pusher = new Pusher('64822af523b84ea0b333', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('message_channel');
            channel.bind('message_event', function (data) {
                
                if (data.from_user === 1) {
                    if (users.includes(data.userId)) {
                        var user = $("#user" + data.userId);
                        user.find('.new_msg_content').text(data.content);
                        user.css('background', 'lightBlue');
                        let par = $("#user_content" + data.userId).closest('.content_chat');

                        par.append(`
                <div class="messages__item">
                <img src="/img/profiles/1.jpg" class="avatars-img" alt=""/>

                <div class="messages__details"> 
                    <p class="text-justify">${data.content}</p>
                    <small>
                        <i class="zwicon-clock"></i>${data.time}</small>
                </div>
            </div>
                `)


                    }
                    else {
                        $(".new_mobile").prepend(`
                        <a class="listview__item enter_chat" data-id="${data.userId}" style="background : lightBlue"
                                   id="user${data.userId}" data-mobile="${data.mobile}">

                                    <img src="https://18charkh.com/img/profiles/1.jpg" alt=""
                                         class="avatar-img"/>

                                    <div class="listview__content text-right">
                                        <div class="listview__heading">${data.mobile}</div>

                                        <p class="new_msg_content">
                                        ${data.content}
                            </p>
                        </div>
                    </a>
`)
                    }

                }
            });
            
            
            var user_id = 0
            $('.enter_chat').on('click', function () {
            
            $(this).css('background', '');

            user_id = $(this).data('id');

            // var app = @json($chats);
            
            // console.log(app);
            // console.log(app[user_id]);
            // return;

            var mobile = $(this).data('mobile');

            
            $.ajax({
                url: '/admin/get/chat',
                data: {"id": user_id},
                method: 'post',
                success: function (x) {
                    $('.mobile_chat').text(mobile);
                    
                    $('.content_chat').html(x);
                 
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
                $(".chat_body").show()
            });
            
            $('.answer_btn').on('click', function () {
                
                let parent = $(this).closest('.answer_box');
                let super_parent = $(this).closest('.content_chat');
                let content = parent.find('.answer_text');
                if(content.val() === ""){
                    return;
                }
                
                $.ajax({
                url: '/admin/send/chat/response',
                data: {"id": user_id , "res" : content.val()},
                method: 'post',
                success: function (x) {

                    if(x.success){

                        var options = `<div class="messages__item messages__item--right">
                             <div class="messages__details">
                                 <p>${content.val()}</p>
                                 <small><i class="zwicon-clock"></i>${x.time}</small>
                             </div>
                         </div>`
                         
                         console.log(options);

                        $('.content_chat').append(options);
                        content.val("")
                    }
                    
                    },

                error: function (exception) {
                    console.log(exception);
                }

            });

            });
        });
        
        function toDate(date) {
            var d = new Date(date).toLocaleDateString('fa-IR')
            return d
        }

    </script>
    
    <script>
        $( document ).ready(function() {
            
            function updateScroll(){
                var element = document.getElementById("#messages__content");
                element.scrollTop = element.scrollHeight;
            }
    
            var element = document.getElementById("#messages__content");
            element.scrollTop = element.scrollHeight;

            $('.send_response').on('click', function () {
                let id = $(this).data('id');
                let parent = $(this).closest('.exam-parent');
                let response = parent.find('.response').val();

                let url = "/admin/send/response";
                let method = 'POST';
                let data = {'id': id, 'response': response, '_token': "{{csrf_token()}}"};
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        console.log(response.success);

                        if (response.success) {
                            alert('پاسخ شما ثبت شد.')
                        }

                    },
                    error: function (xhr) {
                        alert('ارتباط با سرور قطع شده است.');
                        console.log(xhr)
                    }

                });


            });
        });

    </script>

@endsection
