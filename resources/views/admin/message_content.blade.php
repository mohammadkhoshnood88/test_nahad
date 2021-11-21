<div id="user_content{{$id}}">
    @foreach($chats as $m)

        @if($m->reply == 1)
            <div class="messages__item messages__item--right">
                <div class="messages__details">
                    <p>{{$m->content}}</p>
                    <small>
                        <i class="zwicon-clock"></i>{{\Morilog\Jalali\Jalalian::forge($m->created_at)->format('H:i - %B %d')}}
                    </small>
                </div>
            </div>
        @elseif($m->reply == 0)
            <div class="messages__item">
                <img src="/img/profiles/1.jpg" class="avatars-img" alt=""/>

                <div class="messages__details">
                    <p class="text-justify">{{$m->content}}</p>
                    <small>
                        <i class="zwicon-clock"></i>{{\Morilog\Jalali\Jalalian::forge($m->created_at)->addHours(3)->addMinutes(30)->format('H:i - %B %d')}}
                    </small>
                </div>
            </div>
        @endif

    @endforeach
</div>