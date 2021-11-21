@extends('userpanel.index')

@section('inner_tab')

<div class="col-md-12" style="direction: rtl">

    @if(!$phone_number)
    <div class="col-md-12 mx-auto text-center" id="login_panel">
        <p class="text-center" style="direction: rtl;font-weight: 700;"></p>
        <div class="alert_Noresult">
            <h4>ابتدا وارد
                حساب کاربری
                خود شوید
            </h4>
        </div>
        <a class="btn btn-success mx-auto my-4 show-rb">حساب کاربری</a>
    </div>
    @endif
    <div class="row">
        @if(count($all)==0)
        <p style="text-align: center">آگهی ثبت نکرده اید</p>
        @endif
        @foreach($all as $lux)
        <div class="col-md-6 mb-5 post_box">
            <div class="row mx-1 py-3  post_box_shadow">
                <div class="col-md-6 text-right">
                    <a href="/{{$lux['type']}}/show/{{$lux['id']}}/{!! str_replace(' ', '_', $lux['subject']) !!}"><img
                            class="w-100 w-md-75"
                            src="/post_images/related_images_watermark/{{$lux['main_img'] ? $lux['main_img'] : "noimage.jpg"}}"
                            alt="{{$lux['subject']}}"></a>
                </div>
                <div class="col-md-6 parent-post mr-md-n5">
                    <div class="text-right text-white mt-3 flex-row-reverse">
                        <h6 class="some-titles">{{Str::words($lux['subject'], $words = 3, $end = '...')}}</h6>
                    </div>
                    <div class="contents mt-4 text-white text-right">
                        <h6>{{Str::words($lux['description'], $words = 9, $end = '...')}}</h6>

                        <div class="time d-inline-block mt-3">
                            <h6 class="type_advertise">
                                <?php

                                            $d = \Carbon\Carbon::now();
                                            $ct = $lux['created_at'];
                                            $di = $d->diff($ct)->format('%Y,%M,%d,%H,%I');
                                            $arr = explode(',' , $di);
                                            $is_now = 0;
                                        if($arr[0] == '0' && $arr[1] == '0' && $arr[2] == '0' && $arr[3] == '0' && $arr[4] == '0'){
                                                echo "همین الان";
                                                $is_now = 1;
                                            }
                                        
                                        if($arr[0] == '0' && $arr[1] == '0' && $arr[2] == '1'){
                                                echo "دیروز";
                                                $is_now = 1;
                                            }
                                        
                                        if($arr[0] == '0' && $arr[1] == '0' && $arr[2] == '2'){
                                                echo "پریروز";
                                                $is_now = 1;
                                            }

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

                                            if($is_now == 0)
                                                echo \Morilog\Jalali\Jalalian::forge($time_compare)->ago();

                                            ?>
                            </h6>
                        </div>
                        <div class="situation d-inline-block float-left mt-3 mr-3">
                            @if($lux['is_active'])
                            <h5 class="text-success">منتشر شده</h5>
                            @elseif($lux['is_pending'] && !$lux['is_active'] && !$lux['is_delete'])
                            <h5 class="text-warning">منتظر تایید</h5>
                            @elseif($lux['is_pending'] == 0 && $lux['is_active'] == 0 && !$lux['is_delete'])
                            <h5 class="text-danger">رد شده</h5>
                            @elseif($lux['is_delete'] == 1)
                            <h5 class="text-danger">منتشر نشده</h5>
                            @endif
                        </div>
                    </div>
                    <div class="action_btn text-md-right text-center mt-3">
                        <a class="navi_btn btn-danger btn-sm remove_lateral" data-id="{{$lux['id']}}" data-type="{{$lux['type']}}"
                            style="cursor:pointer">حذف</a>
                        <a href="/userpanel/{{$lux['type']}}/{{$lux['id']}}/edit" class="navi_btn btn-info mr-2 btn-sm">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</div>

@endsection