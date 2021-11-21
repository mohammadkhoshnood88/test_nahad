@extends('userpanel.index')

@section('inner_tab')
<div id="mark_parent_box" class="gallery-items grid-big-pad  lightgallery three-column fl-wrap" style="height: 100% !important;">

    @if(count($favorites)==0)
        <div class="container" style="direction: rtl">

            <div class="unmarked_content text-center">
            
                <div class="alert_Noresult">
                    <h5 class="text-center" style="line-height: 1.8;">آگهی‌های مورد علاقه خود را توسط دکمه 
                        <span style="font-size: 15px;color: yellow">« نشان کردن »</span>
                        به این صفحه اضافه کنید تا در هر زمانی
                        به راحتی به آنها دسترسی داشته باشید.</h5>
                </div>

            </div>

        </div>
    @else

        <div class="row justify-content-end all">
            @foreach($favorites as $favorite)
                <div class="gallery-item ads_box" style="position: static !important; direction: rtl">
                    <div class="grid-item-holder hov_zoo">
                        <img src="/post_images/related_images_watermark/{{$favorite->image_path}}" alt="{{$favorite->subject}}">
                    </div>
                    
                    <div class="grid-item-details">
                        <a href="/advertises/show/{{$favorite->id}}/{!! str_replace(' ', '_', $favorite->subject) !!}">
                            @if(isset($favorite->price))
                                <h3 class="text-right">{{Str::words($favorite->subject, $words = 4, $end = '...')}}<span>{{$favorite->price === null || $favorite->price === "0" ? "توافقی" : number_format((float)$favorite->price) . " تومان "}}</span></h3>
                            @endif
                            <p class="text-right">{{Str::words($favorite->description, $words = 5, $end = '...')}}</p>
                        </a>
                        <div class="grid-item_price mb-0 mt-3">
                            <span class="pt-2" dir="rtl">
                                 <?php

                                $d = \Carbon\Carbon::now();
                                $ct = $favorite->created_at;
                                $di = $d->diff($ct)->format('%Y,%M,%d,%H,%I');
                                $arr = explode(',' , $di);
                                

                                $aa = 0;
                                foreach ($arr as $i => $a){

                                    if ($a != 0){
                                        $aa = $i;
                                        break;
                                    }
                                }
                                $time_compare = "";
                                
                                switch ($aa){
                                    case 0:
                                        $time_compare = "now - $arr[0] years";
                                        break;

                                    case 1:
                                        $time_compare = "now - $arr[1] months";
                                        break;

                                    case 2:
                                        $time_compare = "now - $arr[2] days";
                                        break;

                                    case 3:
                                        $time_compare = "now - $arr[3] hours";
                                        break;

                                    case 4:
                                        $time_compare = "now - $arr[4] minutes";
                                        break;
                                }

                                echo \Morilog\Jalali\Jalalian::forge($time_compare)->ago();

                                ?>
                            </span>
                                <a class="navi_btn btn-danger delete_btn float-right" data-id="{{$favorite->mid}}" data-type="{{isset($favorite->type) ? $favorite->type : "0"}}">حذف از تاریخچه</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        @endif

</div>
@endsection
