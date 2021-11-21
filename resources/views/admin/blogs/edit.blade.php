@extends('layouts.admin')

@section('header-scripts')


    <script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{asset('/js/reg.js')}}"></script>
    <script src="{{asset('/js/app.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{asset('js/jquery.js')}}"></script>


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

                    <h1 class="text-right">ویرایش بلاگ {{$blog->id}}</h1>

                    <a href="/admin/blog/index" class="btn btn-warning btn--icon-text"><i class="zwicon-arrow-left"></i>بازگشت</a>


                </header>
                <form id="myform" method="POST" enctype="multipart/form-data"
                      action="{{route('blog.update', $blog->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="card new-contact">
                        <div class="new-contact__header">
                            <a href="new-contact.html" class="zwicon-camera new-contact__upload"></a>

                            <img src="demo/img/contacts/user_empty.png" class="new-contact__img" alt=""/>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تیتر اصلی </label>
                                        <input type="text" name="title" class="form-control"
                                               value="{{$blog->title}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>زیر تیتر </label>
                                        <input type="text" name="subtitle" class="form-control"
                                               value="{{$blog->subtitle}}"/>
                                    </div>
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="mb-1">خلاصه متن</label>
                                <br>
                                <textarea class="form-control" name="summary">{{$blog->summary}}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="mb-1">متن خبر</label>
                                <br>
                                <textarea class="form-control" name="content" id="contentarea">
                                    {!! $blog->content !!}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>بر چسب ها</label>
                                <select name="tags[]" class="form-control tags" style="background: #49181e"
                                        multiple="multiple">
                                    @foreach($tags as $tag)
                                        <option @if($blog->tags != "")
                                                @foreach($blog->tags as $blog_tag)
                                                @if($blog_tag->id == $tag->id)
                                                selected
                                                @endif
                                                @endforeach
                                                @endif
                                                value="{{$tag->id}}">
                                            {{$tag->text}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label>دسته بندی</label>
                                <select name="cat" class="form-control" style="background: #49181e"
                                >
                                    @foreach($cats as $cat)
                                        <option @if($blog->categories != "" && count($blog->categories) != 0)
                                                @if($blog->categories[0]->id == $cat->id)
                                                selected
                                                @endif
                                                @endif
                                                value="{{$cat->id}}">
                                            {{$cat->text}}</option>
                                    @endforeach

                                </select>
                            </div>


                            @if (\Illuminate\Support\Facades\Gate::any(['isAdmin', 'isOwner']))
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <span style="font-size: 11px">( وضعیت نمایش آگهی در سایت را تعیین کنید )</span>
                                    <select style="padding: 5px" name="status" class="form-control">
                                        <option @if($blog->status === 1) selected @endif value="1">نمایش</option>
                                        <option @if($blog->status === 0) selected @endif value="0">عدم نمایش</option>
                                    </select>
                                </div>
                            @endif


                            <div class="Img_uploder">

                                <div class="col-sm-12">
                                    <div class="Img_uploder">

                                        <div class="ImgBox">
                                            <div class="card-body">
                                                <div class="col-sm-12"
                                                     style="margin: 20px auto;text-align:right">
                                                    <div class="Img_uploder row">

                                                        <div class="col-md-6 parent">
                                                            <input type="file" data-id="0" name="img-upload-one"
                                                                   onchange="readURL(this);"
                                                                   id="img-upload-one"/>
                                                            <img
                                                                src="{{asset('/storage/blogs/related_images/' . $blog->index(0))}}"
                                                                style="height: 50px;width: 50px">
                                                        </div>

                                                    </div>


                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                </div>


                            </div>
                            <input hidden class="new_pic" name="index_img" value="{{$blog->index_img}}">

                            <div class="clearfix"></div>

                            <div class="mt-5 text-center">
                                <button type="submit" href="new-contact.html" class="btn btn-theme">ثبت تغییرات</button>
                                <a href="/admin/blog/index" class="btn btn-warning btn--icon-text"><i class="zwicon-arrow-left"></i>بازگشت</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </main>


@endsection

@section('scripts')


    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('contentarea', {
            language: 'fa',
            content: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>

    <script type="text/javascript">

        $(document).ready(function () {
            $(".tags").select2({
                tags:true
            });

        });

    </script>
    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).closest('.parent').find('img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

