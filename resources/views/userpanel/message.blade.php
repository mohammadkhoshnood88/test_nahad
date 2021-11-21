@extends('userpanel.index')

@section('inner_tab')
    <div class="content__inner">
        
          @if(!$phone_number)
            <div class="col-md-12 mx-auto text-center" id="login_panel">
                <p class="text-center" style="direction: rtl;font-weight: 700;"></p>
                <div class="alert_Noresult">
                    <h4>ابتدا وارد
                {{--<span class="show-rb" style="color: white;cursor: pointer;font-size: 20px">حساب کاربری</span>--}}
                        حساب کاربری
                        خود شوید
                    </h4>
                </div>
                <a class="btn btn-success mx-auto my-4 show-rb">حساب کاربری</a>
            </div>
        @else
        
        <div class="messages">
            <div class="messages__body">
                <div class="messages__header">
                     <div class="toolbar toolbar--inner mb-0">
                         <img class="ml-2" src="/images/icons/chat.png" />
                         <div class="toolbar__label">گفتگو با ادمین <a class="toolbar__link" href="http://18charkh.com/">18 چرخ</a></div>
                     </div>
                 </div>
        
                <div class="messages__content">
                     <div class="scrollbar message_body_a content_chat">
                         <!--<div class="messages__item my-3 text-center">-->
                         <!--    <div class="message__time mx-auto p-0">-->
                         <!--       <p class="text-center p-0">چهارشنبه 3 دی</p>-->
                         <!--   </div>-->
                         <!--</div>-->
                         
                         @foreach($chats as $chat)
                         @if($chat->reply == 1)
                         <div class="messages__item">
                             <img src="{{asset('images/avatar/admin.png')}}" class="avatars-img" alt="" />
        
                             <div class="messages__details">
                                 <p class="text-justify">{{$chat->content}}</p>
                                 <small class='text-left'><i class="zwicon-clock"></i>{{\Morilog\Jalali\Jalalian::forge($chat->created_at)->addHours(3)->addMinutes(30)->format('H:i - %B %d')}}</small>
                             </div>
                         </div>
                         @else
                         <div class="messages__item messages__item--right">
                             <div class="messages__details">
                                 <p>{{$chat->content}}</p>
                                 <small><i class="zwicon-clock"></i>{{\Morilog\Jalali\Jalalian::forge($chat->created_at)->addHours(3)->addMinutes(30)->format('H:i - %B %d')}}</small>
                             </div>
                         </div>
                         @endif
                         @endforeach
                     </div>
                 </div>
        
                <div class="messages__reply">
                    <textarea  class="messages__reply__text content_ajax_message" placeholder="متن پیام ..."></textarea>
                    <button class="btn-message btn-theme-dark btn--icon send-possition answer_btn send_ajax_btn" style="outline: none;">
                        <img src="/images/icons/send.png" />
                    </button>
                </div>
            </div>
        </div>
        
        @endif
    </div>
@endsection
