@extends('layouts.admin')

@section('content')

    <main class="main">

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
                    <a href="/blog/create" class="btn btn-warning"><i class="zwicon-plus"></i>بلاگ جدید</a>

                    <h1 class="text-right">وبلاگ 18 چرخ</h1>

                </header>

                <div class="row">
                    <div class="col-lg-8 text-right" style="direction: rtl">

                        @foreach ($blogs as $blog)
                            <div @if($blog->can_publish()) style="background: rgba(205,234,212,.2)" @endif class="card">
                                {{--                                <img class="card-img-top" src="{{asset('/storage/blogs/related_images/' . $blog->blogimges[$blog->index_img])}}" alt=""/>--}}

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h2 class="card-title">{{$blog->title}}</h2>
                                        </div>

                                        <div class="col-md-4">
                                            <span>نام ناشر : {{$blog->publisher()}}</span>
                                        </div>

                                        <div class="col-md-4">
                                            @if (\Illuminate\Support\Facades\Gate::allows('isEditor'))
                                                @if($blog->status === 0)
                                                    <span>در حال بررسی</span>
                                                @else
                                                    <span>منتشر شده</span>
                                                @endif
                                            @elseif (\Illuminate\Support\Facades\Gate::any(['isAdmin', 'isOwner']))

                                                <select class="verify" data-id="{{$blog->id}}">
                                                    <option value="1" @if($blog->status == 1) selected @endif>انتشار
                                                    </option>
                                                    <option value="0" @if($blog->status == 0) selected @endif>عدم انتشار
                                                    </option>
                                                </select>
                                            @endif
                                        </div>


                                    </div>

                                    <h4 class="card-subtitle mt-2">خلاصه : {{$blog->summary}}</h4>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <h6 class="card-subtitle">{{\Morilog\Jalali\Jalalian::forge($blog->created_at)->format('%A, %d %B %y')}}</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="card-subtitle">تعداد بازدید : {{$blog->view_count}}</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="card-subtitle">تعداد نظرات : {{count($blog->comments->toArray())}}</h6>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-2">برچسب ها :</div>
                                        <div class="col-md-10">
                                            @foreach($blog->tags as $tag)
                                                <span class="badge p-1 badge-info"
                                                >{{$tag->text}}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">دسته بندی ها :</div>
                                        <div class="col-md-9">
                                            @foreach($blog->categories as $cat)
                                                <span class="badge p-1 badge-primary"
                                                >{{$cat->text}}</span>
                                            @endforeach
                                        </div>
                                    </div>


                                    {{--                                    <p class="card-text">{{$blog->content}}</p>--}}

                                    @if($blog->can_publish() || \Illuminate\Support\Facades\Gate::any(['isAdmin', 'isOwner']))

                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="{{route('blog.edit', $blog->id) }}" class="card-link">ویرایش
                                                    بلاگ</a>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="{{route('blog.comment', $blog->id) }}" class="card-link">نظرات
                                                    بلاگ</a>
                                            </div>

                                        </div>
                                    @endif


                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="col-lg-4 d-none d-lg-block text-right">


                        <div class="card">
                            <div class="card-body p-2">
                                <div class="parent pb-2 mb-2">
                                    <div class="form-group">
                                        <label>*: نام ناشر</label>
                                        <input class="form-control width-25-per"
                                               value="{{$publisher ? $publisher->name : "" }}"
                                               id="publisher" name="publisher">
                                    </div>
                                    <div class="btn btn-sm btn-primary add_publisher">ثبت
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">دسته بندی ها</h4>

                                <div class="listview listview--hover">

                                    <div style="border-bottom: 2px solid black" class="parent pb-2 mb-2">
                                        <div class="form-group">
                                            <label>دسته بندی جدید:</label>
                                            <input class="form-control w-50 mx-0" id="cat" name="category">
                                        </div>
                                        <div class="btn btn-sm btn-primary add_cat"><i class="zwicon-plus"></i>
                                        </div>

                                    </div>
                                    <div class="tags" id="cats">
                                        @foreach($cats as $cat)

                                            <a href="{{route('cat.destroy', $cat->id) }}">{{$cat->text}}</a>

                                        @endforeach
                                    </div>


                                    <span style="font-size: 11px">با کلیک بر روی هر عنوان آن را پاک کنید، توجه کنید که بلاگی با این دسته بندی وجود نداشته باشد.</span>
                                </div>
                            </div>

                        </div>


                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">برچسب ها</h4>

                                <div class="tags">
                                    @foreach($tags as $tag)
                                        <a>{{$tag}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </main>


@endsection
@section('scripts')

    <script>
        $(function () {
            $('.add_cat').on('click', function (event) {
                event.preventDefault();

                let cat = $('#cat').val();
                let url = "/admin/set/category";
                let method = 'POST';
                let data = {'cat': cat, '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        $('#cat').val('');
                        console.log(response);

                        if (response.success) {
                            console.log(response)
                            $('#cats').prepend(`
                            <a href="/admin/destroy/category/${response.id}">${response.cat}</a>
                            `)
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
    <script>
        $(function () {
            $('.add_publisher').on('click', function (event) {
                event.preventDefault();

                let cat = $('#publisher').val();
                let url = "/admin/set/publisher";
                let method = 'POST';
                let data = {'publisher': cat, '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        // $('#publisher').val('');
                        console.log(response);

                    },
                    error: function (xhr) {
                        alert('ارتباط با سرور قطع شده است.');
                        console.log(xhr)
                    }

                });
            });
        });

    </script>
    <script>
        $(function () {
            $('.verify').on('change', function (event) {


                event.preventDefault();

                let blog_id = $(this).data('id');
                let status = $(this).val();


                let url = "/admin/blog/verify";
                let method = 'POST';
                let data = {'blog_id': blog_id, 'status': status, '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        // console.log(response);

                        if (response.success) {
                            if (response.message == 1) {
                                alert(`بلاگ منتشر شد`);
                            } else if (response.message == 0) {
                                alert(`بلاگ در حالت عدم انتشار قرار گرفت`);
                            }

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
