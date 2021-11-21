@extends('layouts.admin')

@section('header-scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/js/reg.js')}}"></script>
    {{-- <script src="{{asset('/js/app.js')}}"></script>         --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


@endsection

@section('content')

    <main class="main" style="text-align: right;direction: rtl">

        <div class="page-loader">
            <div class="page-loader__spinner">
                <svg viewbox="25 25 50 50">
                    <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                </svg>
            </div>
        </div>

        <section class="content">
            <div class="content__inner">
                <header class="content__title">

                    <h1 class="text-right">ایجاد بلاگ جدید</h1>

                    <a href="/admin/blog/index" class="btn btn-warning btn--icon-text"><i class="zwicon-arrow-left"></i>بازگشت</a>


                </header>
                <form id="form1" action="{{route('store.blog')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card new-contact">
                        {{--                        <div class="new-contact__header">--}}
                        {{--                            <a href="new-contact.html" class="zwicon-camera new-contact__upload"></a>--}}

                        {{--                            <img src="demo/img/contacts/user_empty.png" class="new-contact__img" alt=""/>--}}
                        {{--                        </div>--}}

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تیتر اصلی </label>
                                        <input type="text" name="title" class="form-control"
                                               placeholder="تیتر را وارد نمایید"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>زیر تیتر </label>
                                        <input type="text" name="subtitle" class="form-control"
                                               placeholder="زیر تیتر را وارد نمایید"/>
                                    </div>
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="mb-1">خلاصه متن</label>
                                <br>
                                <textarea class="form-control" name="summary"></textarea>
                            </div>

                            <div class="form-group">
                                <label>متن اصلی</label>
                                <textarea name="content" id="ckeditor-textarea" class="form-control ckeditor"
                                          placeholder="متن اصلی را وارد کنید"></textarea>
                            </div>

                            <div class="form-group">
                                <label>بر چسب ها</label>
                                <span style="font-size: 11px">  (از بین برچسب های موجود انتخاب کنید یا خودتان برچسبی را اضافه نمایید)</span>
                                <select name="tags[]" class="form-control tags" style="background: #49181e"
                                        multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option>{{$tag}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label>دسته بندی ها</label>
                                <select name="cat" class="form-control" style="background: #49181e">
                                    @foreach ($cats as $cat)
                                        <option value="{{$cat->id}}">{{$cat->text}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-12" style="margin: 20px auto">

                                <label>انتخاب تصویر شاخص <span style="font-size: 11px"> ( این تصویر به عنوان عکس اصلی بلاگ در صفحات لیست آگهی ها و نمایش بلاگ استفاده می شود )</span></label>
                                <div class="Img_uploder">

                                    {{-- ----- Box Img One ----- --}}
                                    <div class="ImgBox">
                                        <div class="Img_table">
                                            <div class="Img_table-cell">
                                                <div class="Img_modal">
                                                    <div class="Img_profile" id="profile">
                                                        <div class="Img_dashes"></div>
                                                        <label>کلیک کنید</label>
                                                    </div>

                                                    <div class="ImgCaotion">
                                                        <i class="fa fa-plus-square-o fa-2x"></i>
                                                        {{--                                                    <div class="Img_editable"><h3>افزودن عکس*</h3></div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" class="Img_mediaFile" name="img-upload-one"
                                               id="img-upload-one"/>
                                    </div>

                                </div>


                            </div>

                            <div class="clearfix"></div>

                            <div class="mt-5 text-center">
                                <button type="submit" href="new-contact.html" class="btn btn-theme">ثبت بلاگ</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </main>


@endsection

@section('scripts')

    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>


    <script>
        CKEDITOR.replace('ckeditor-textarea', {
            language: 'fa',
            content: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

    </script>

    <script type="text/javascript">


        $(document).ready(function () {
            $(".tags").select2({
                tags: true
            });
        });

    </script>

@endsection
