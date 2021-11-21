@extends('userpanel.index')

@section('inner_tab')

    @if(!$phone_number)
        <div class="col-md-12 mx-auto text-center" id="login_panel">
            <p class="text-center" style="direction: rtl;font-weight: 700;"></p>
            <div class="alert_Noresult ">
                <h4>ابتدا وارد حساب کاربری خود شوید</h4>
            </div>
            <a class="btn btn-success mx-auto my-4 show-rb">حساب کاربری</a>
        </div>
    @else

        <div class="col-md-12">
            <div class="offer_filter">
                <div>
                    <div class="offer_title">
                        <h5 class="p-4 text-right">
                            خبرم کن
                        </h5>
                    </div>
                    <div class="offer_content" style="direction: rtl">
                        <form action="{{route('tenant.store')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row my-3 mx-3">
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label class="offer_label offer_label float-right mx-2 mb-2"
                                               for="state_id">استان</label>
                                        <select class="form-control" name="state_id" id="state">
                                            <option value="" hidden>انتخاب نمایید</option>
                                            @foreach ($states as $state)
                                                <option
                                                        value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label class="offer_label offer_label float-right mx-2 mb-2"
                                               for="city_id">شهر</label>
                                        <select class="form-control" name="city_id" id="cityy">
                                            <option value="" hidden>ابتدا استان را انتخاب کنید</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label class="offer_label float-right mx-2 mb-2" for="state_id">نوع
                                            ماشین</label>
                                        <select class="form-control" name="type">
                                            <option value="" hidden>انتخاب نمایید</option>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label class="offer_label float-right mx-2 mb-2" for="state_id">وضعیت
                                            راننده</label>
                                        <select class="form-control" name="d_status">
                                            <option value="" hidden>انتخاب نمایید</option>
                                            <option value="0">فرقی نمیکند</option>
                                            <option value="1">با راننده</option>
                                            <option value="2">بدون راننده</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="px-3 py-2 mb-2 btn-success">ثبت اطلاعات</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($tenant)
            <div class="col-md-12 text-right" style="direction: rtl">
                @if($tenant->state_id)

                        <div class="show_filters mt-3 closebadge" data-name="state">
                            <div class="badge badge-filter p-3 closee"  data-name="state">
                                <span>استان :</span>
                                <span id="state_id" data-id="{{$tenant->state_id}}" class="m-1">{{$tenant->state_name()}}</span>
                                <i class="fa fa-close"></i>
                            </div>
                        </div>


                @endif
                @if($tenant->city_id)

                    <div class="show_filters mt-3 closebadge city_after_state" data-name="city">
                        <div class="badge badge-filter p-3 closee" data-name="city">
                            <span>شهر :</span>
                            <span id="city_id" data-id="{{$tenant->city_id ? $tenant->city_id : null}}" class="m-1">{{$tenant->city_name()}}</span>
                            <i class="fa fa-close"></i>
                        </div>
                    </div>

                @endif
                @if($tenant->type)

                    <div class="show_filters mt-3 closebadge" data-name="type">
                        <div class="badge badge-filter p-3 closee" data-name="type">
                            <span>نوع ماشین :</span>
                            <span id="type" data-id="{{$tenant->type}}" class="m-1">{{$tenant->type_name->name}}</span>
                            <i class="fa fa-close"></i>
                        </div>

                        </div>
                @endif
                @if(($tenant->driver_status || $tenant->driver_status == 0) && $tenant->driver_status != null)

                        <div class="show_filters mt-3 closebadge" data-name="driver">
                        <div class="badge badge-filter p-3 closee" data-name="driver">
                            <span>وضعیت راننده :</span>
                            <span id="d_status" data-id="{{$tenant->driver_status}}" class="m-1">{{  $tenant->driver_status === "0" ? " فرقی نمی کند" : ($tenant->driver_status === "1" ? "با راننده" : "بدون راننده") }}</span>
                            <i class="fa fa-close"></i>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        <div class="clearfix"></div>
        <div class="bold-separator mt-5 bold-separator_dark"><span></span></div>
        <div class="clearfix"></div>

        <div class="gallery_label mb-4 text-right">
            <h4>لیست نمایش
                @if($null_offer)
                <span id="last_search">بر اساس جست و جو قبلی</span>
                    @endif
            </h4>
        </div>
        <div id="result" class="gallery-items grid-big-pad lightgallery three-column fl-wrap justify-content-end" style="margin-bottom:50px; height: unset !important">

            @if($null_offer && count($offers) == 0)
                <div class="alert_Noresult my-4 text-center w-100">
                    <h4>فعلا چیزی پیدا نشد، برو خبرت میکنم</h4>
                </div>
            @endif

            @foreach($offers as $offer)
            <div class="col-md-3 d-block gallery-item desserts" style="position: absolute; right: unset !important; left: unset !important; direction: rtl">
                <div class="grid-item-holder hov_zoo">
                    <img src="/post_images/related_images_watermark/{{$offer->image_path}}" alt="related_images_watermark">
                </div>
                <div class="grid-item-details">
                    <a href="/advertises/show/{{$offer->id}}/{!! str_replace(' ', '_', $offer->subject) !!}">
                        <h3 class="text-right">{{Str::words($offer->subject, $words = 3, $end = ' ...')}}<span>اجاره ای</span></h3>
                        <p class="text-right">{{Str::words($offer->description, $words = 4, $end = '...')}}</p>
                    </a>
                    <div class="grid-item_price mb-0 mt-4">
                        <span class="pt-2">{{\Morilog\Jalali\CalendarUtils::convertNumbers(\Morilog\Jalali\Jalalian::forge($offer->created_at)->format('Y/m/d'))}}</span>
                    </div>
                </div>
            </div>
                @endforeach

        </div>
    @endif
@endsection