@extends('layouts.admin')

@section('header-scripts')

    <link rel="stylesheet" href="{{asset('/date-picker/persian-datepicker/dist/css/persian-datepicker.css')}}"/>

@endsection

@section('content')
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewbox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
            </svg>
        </div>
    </div>

    <section class="content">
        <div class="card">
            <div class="card-body">

                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">داشبورد </a></li>
                        <li class="breadcrumb-item"><a href="/admin/adm_manage">مدیریت آگهی </a></li>
                        <li class="breadcrumb-item active" aria-current="page">ویرایش </li>

                        <a href="/admin/adm_manage" class="btn btn-warning btn--icon-text" style="position: absolute;right: 40px;top: 25px;">بازگشت</a>
                    </ol>
                </nav>
            </div>
        </div>

        {!! Form::open(['action' => ['AdminRentController@update', $rents->id], 'method' => 'POST','files' => true]) !!}
        @csrf

        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-right">ویرایش آگهی </h4>

                <div class="row text-right">
                    <div class="col-sm-6">

                        {{Form::label('phone_number', 'شماره تلفن :', ['class' => 'lable-rtl'])}}

                        {{Form::text('phone_number', $rents->phone_number, ['class' => 'form-control lable-rtl', 'placeholder' => 'تلفن آگهی دهنده'])}}

                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">

                            {{Form::label('subject', 'عنوان :', ['class' => 'lable-rtl'])}}

                            {{Form::text('subject', $rents->subject, ['class' => 'form-control lable-rtl', 'placeholder' => 'عنوان آگهی'])}}

                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group">

                            {{Form::label('type', 'سایر مشخصات ماشین', ['class' => 'lable-rtl'])}}

                            {{Form::text('type', $rents->tonnage_name(), ['class' => 'form-control lable-rtl'])}}

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">

                            {{Form::label('type', 'نوع ماشین :', ['class' => 'lable-rtl'])}}

                            {{Form::text('type', $rents->type_name->name, ['class' => 'form-control lable-rtl', 'placeholder' => 'نوع ماشین'])}}

                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">

                            {{Form::label('email', 'آدرس ایمیل :', ['class' => 'lable-rtl'])}}

                            {{Form::email('email', $rents->email, ['class' => 'form-control lable-rtl', 'placeholder' => 'eg: Test@18Charkh.com'])}}

                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            {{Form::label('workers', 'تعداد کارگران :', ['class' => 'lable-rtl'])}}

                            {{Form::text('workers', $rents->workers, ['class' => 'form-control lable-rtl', 'placeholder' => 'تعداد کارگران'])}}


                        </div>
                    </div>

                    <div class="col-sm-6">

                        <div class="form-group">
                            {{Form::label('driver_Status', 'وضعیت راننده :', ['class' => 'lable-rtl'])}}

                            <select name="driver_status" class="form-control lable-rtl">
                                <option value="0" @if($rents->driver_status == '0') selected @endif>فرقی ندارد</option>
                                <option value="1" @if($rents->driver_status == '1') selected @endif>با راننده</option>
                                <option value="2" @if($rents->driver_status == '2') selected @endif>بدون راننده</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">

                            {{Form::label('expire_at', 'تاریخ انقضا :', ['class' => 'lable-rtl'])}}

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zwicon-calendar-never"></i></span>
                                </div>

                                {{Form::text('expire_at', \Carbon\Carbon::parse($rents->confimr_at)->addMonth(), ['class' => 'form-control expire lable-rtl' , 'data-status' => '0' , 'placeholder' => 'مدت زمان انقضا آگهی'])}}

                            </div>
                            <span style="font-size: 11px">به صورت پیشفرض یک ماه پس از تایید آگهی می باشد</span>
                            <input hidden value="" class="expire_at_status" name="expire_at_status">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">

                            {{Form::label('confirm_at', 'تاریخ تایید :', ['class' => 'lable-rtl'])}}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zwicon-calendar-never"></i></span>
                                </div>

                                {{Form::text('confirm_at', $rents->confirm_at, ['class' => 'form-control confirm1 lable-rtl', 'id'=>'confirm1' ,  'placeholder' => 'تاریخ تایید آگهی'])}}
                                {{--                                <input class="form-control" id="confirm1">--}}

                            </div>
                            <span style="font-size: 12px">این زمان به صورت پیشفرض از زمان تایید شما تنظیم میشود، ولی میتوانید آن را تغییر دهید</span>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">

                            {{Form::label('description', 'توضیحات آگهی :', ['class' => 'lable-rtl'])}}

                            {{Form::textarea('description', $rents->description, ['class' => 'form-control textarea-autosize text-right lable-rtl', 'placeholder' => 'متن کامل آگهی'])}}

                        </div>
                    </div>

                    <div class="col-sm-6">

                        <div class="form-group">

                            {{Form::label('admin_response', 'پیام مدیر :', ['class' => 'lable-rtl'])}}

                            {{Form::textarea('admin_response', $rents->admin_response, ['class' => 'form-control textarea-autosize text-right lable-rtl', 'placeholder' => 'پیام خود را برای این آگهی بنویسید'])}}

                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-right">تگ ها </h4>
                <h6 class="card-subtitle text-right">تگ های زیر برای این آگهی استفاده شده است </h6>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="form-group">

                            {{Form::select('tags', ['SU' => 'Subaru', 'MI' => 'Mitsubishi','SC' => 'Scion', 'DA' => 'Daihatsu'], null, ['class' => 'select2 lable-rtl','data-placeholder' => 'تگ ها را از لیست زیر انتخاب کنید', 'multiple' => ''])}}

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h5 class="card-body__title text-right">وضعیت آگهی </h5>

                        <div class="row">
                            <div class="col-sm-12">
                                <p class="text-right">با فعال کرد این گزینه آگهی از حالت تحت بررسی خارج و در وضعیت ( بررسی شده ) قرار خواهد گرفت </p>

                                <div class="demo-inline-wrapper">
                                    <div class="form-group">
                                        <div class="toggle-switch toggle-switch--teal">

                                            {{Form::checkbox('is_pending', 0, $rents->is_pending, ['class' => 'toggle-switch__checkbox'])}}

                                            <i class="toggle-switch__helper"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p class="text-right">با فعال کرد این گزینه آگهی تایید خواهد شد </p>

                                <div class="demo-inline-wrapper">
                                    <div class="form-group">
                                        <div class="toggle-switch toggle-switch--teal">

                                            {{Form::checkbox('is_active', 1, $rents->is_active, ['class' => 'toggle-switch__checkbox'])}}

                                            <i class="toggle-switch__helper"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <p class="text-center">! توجه !</p>
                        <p class="text-right lable-rtl">
                            تایید کردن آگهی به معنی نمایش آگهی در صفحه اصلی ( لیست آگهی ها ) می باشد.
                            خواهشمند است بعد از بررسی دقیق اطلاعات آگهی و مغایرت نداشتن با قوانین تصمیم به تایید بگیرید
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-right lable-rtl">تصاویر آگهی </h4>
                <div class="col-sm-12" style="margin: 20px auto;text-align:right">
                    <span style="font-size: 16px">انتخاب عکس</span>

                    <div class="Img_uploder">
                       <div class="row">
                            <div class="col-sm-3">
                                        <div class="Img_profile" id="profile"
                                             @if(isset($images[0]->path))
                                             @if($images[0]->path != "noimage.jpg")
                                             style="background-image:url('/post_images/related_images_watermark/{{$images[0]->path}}')"
                                                @endif
                                                @endif
                                        >
                                            <div class="Img_dashes"></div>
                                            <label>کلیک کنید</label>
                                        </div>
                                        <input type="file" class="Img_mediaFile"
                                               id="img-upload-one"/>
    
                                        <input id="img-base64-one" name="img_base64_one" hidden accept="image/*"
                                               value="{{isset($images[0]->path) ? $images[0]->path : ''}}" hidden>
    
                                    </div>
                            <div class="col-sm-3">
                                <div class="Img_profile" id="profile1"
                                     @if(isset($images[1]->path))
                                     style="background-image:url('/post_images/related_images_watermark/{{$images[1]->path}}')"
                                        @endif
                                >
                                    <div class="Img_dashes"></div>
                                    <label>کلیک کنید</label>
                                </div>
                                <input type="file" class="Img_mediaFile"
                                       id="img-upload-two"/>
    
                                <input id="img-base64-two" name="img_base64_two" accept="image/*" 
                                       value="{{isset($images[1]->path) ? $images[1]->path : ''}}" hidden>
    
                            </div>
                            <div class="col-sm-3">
                                <div class="Img_profile" id="profile2"
                                     @if(isset($images[2]->path))
                                     style="background-image:url('/post_images/related_images_watermark/{{$images[2]->path}}')"
                                        @endif
                                >
                                    <div class="Img_dashes"></div>
                                    <label>کلیک کنید</label>
                                </div>
                                <input type="file" class="Img_mediaFile"
                                       id="img-upload-three"/>
    
                                <input id="img-base64-three" name="img_base64_three" accept="image/*" 
                                       value="{{isset($images[2]->path) ? $images[2]->path : ''}}" hidden>
    
    
                            </div>
                            <div class="col-sm-3">
                                <div class="Img_profile" id="profile3"
                                     @if(isset($images[3]->path))
                                     style="background-image:url('/post_images/related_images_watermark/{{$images[3]->path}}')"
                                        @endif
                                >
                                    <div class="Img_dashes"></div>
                                    <label>کلیک کنید</label>
                                </div>
                                <input type="file" class="Img_mediaFile"
                                       id="img-upload-four"/>
    
                                <input id="img-base64-four" name="img_base64_four" accept="image/*" 
                                       value="{{isset($images[3]->path) ? $images[3]->path : ''}}" hidden>
    
                            </div>
                       </div>
                    </div>


                </div>

            </div>
        </div>

        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('ثبت تغییرات', ['class' => 'btn btn-success', 'style' => 'position: absolute; left: 50%'])}}

        {!! Form::close() !!}
    </section>

@endsection

@section('scripts')
    <script src="/js/admin_rent.js"></script>
    <script src="/js/reg_admin.js"></script>
    <script src="{{asset('/js/images.js')}}"></script>



    <script src="{{asset('/date-picker/persian-datepicker/dist/js/persian-datepicker.js')}}"></script>
    <script src="{{asset('/date-picker/persian-date/dist/persian-date.js')}}"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $(".expire").pDatepicker({
                observer: true,
                format: 'YYYY/MM/DD',
                autoClose: true,
                onSelect:function(){
                    $(".expire").data('status' , 1)
                    $(".expire_at_status").attr('value' , 1);
                    // alert($(".expire_at_status").attr('value'))
                },
                calendar: {
                    persian: {
                        locale: 'fa'
                    }
                }
            });


        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".confirm1").pDatepicker({
                observer: true,
                format: 'YYYY/MM/DD',
                autoClose: true,
                calendar: {
                    persian: {
                        locale: 'fa'
                    }
                }
            });
        });
    </script>


@endsection
