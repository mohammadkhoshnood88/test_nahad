@extends('layouts.blogmain')

@section('content')

    <div class="container   text-center ">
        <div class="logo mx-1 p-2">
            <h3>
                {{$blog->title}}
            </h3>

        </div>

    </div>




    <div class="container">
        <div class="row" style="direction:ltr">

            <div class="col-md-10  offset-1 text-center  text-md-center mt-4">
                <div class="contentt">
                    <div class="col-md-12 mt-3 p-2 text-md-center ">
                        <a class="btn btn-primary m-2 mb-4 text-center" href="/admin/blog/index">بازگشت</a>
                        <a href=""><img
                                src="{{asset('/storage/blogs/related_images/' . $blog->index(0))}}"
                                height="100%" width="100%" class="images text-center" alt="Responsive image">
                        </a>
                    </div>

                    <div class="col-md-12 mt-5   ">
                        <div class="content_blog pl-5 mb-5">
                            <h3 class="mt-4 mb-4  px-5 text-center quesction">{{$blog->subtitle}}</h3>
                            <p class=" mt-4 mb-2 px-5 descquestion text-center">
                                {!! html_entity_decode($blog->content) !!}

                            </p>
                            <div class="icon1 ">
                                <i class="fa fa-calendar" style="font-size:18px;color: white;"></i>
                                <span class="feild-content"
                                      style="font-size:13px;color: white;">{{\Morilog\Jalali\Jalalian::forge($blog->created_at)->format('%d %B %Y')}}</span>
                                <i class="fa fa-comment-o mr-2" style="font-size:18px;color: white;"></i>
                                @if($blog->comments)
                                    <span class="feild-content" style="font-size:13px;color: white;">{{count($blog->comments)}} نظر</span>
                                @else
                                    <span class="feild-content" style="font-size:13px;color: white;">0 نظر</span>
                                @endif
                            </div>
                        </div>


                    </div>




                    <div class="col-md-12">
                        <div class="comments mt-5">
                            @if($blog->comments)
                                @foreach($blog->comments as $comment)
                                        <div class="col-md-12 mt-5 p-0">
                                            <div class="commm mx-2" style="direction:rtl;">
                                                <div class="row px-3">

                                                    <div class="col-md-2  pt-4">
                                                        <img src="https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" class="" style="border-radius:50px;" width="80px" alt="">
                                                    </div>
                                                    <div class="col-md-10 mt-3 mb-3 text-right comment ">
                                                        <h3 class="txt-com mr-3 mt-3 mb-3">{{$comment->email}}</h3>
                                                        <p class="txt-com mr-3 mt-3 mb-3 text-justify">{{$comment->text}}</p>
                                                        <span class="mr-3 mt-3 mb-3"
                                                              style="float:left;color:white">{{\Morilog\Jalali\Jalalian::forge($blog->created_at)->format('%D/%M/%Y')}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="commm mt-2 mx-2" style="direction:rtl;">
                                                <div class="row px-3">
                                                    <div class="col-md-2  pt-4">
                                                        <img src="https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" class="" style="border-radius:50px;" width="80px" alt="">
                                                    </div>
                                                    <div class="col-md-10 comment mt-3 mb-5 text-right pl-3">
                                                        <div class="row">
                                                            <p class="txt-com mr-3 mt-3 mb-3 col-md-4">پاسخ شما </p>
                                                                <select class="col-md-2 mt-3 change_status" data-id="{{$comment->id}}">
                                                                    <option @if($comment->status == 1) selected @endif value="1">انتشار</option>
                                                                    <option @if($comment->status == 0) selected @endif value="0">عدم انتشار</option>
                                                                </select>

                                                        </div>

                                                        <div class="row box_com">
                                                            <input class="col-md-9 txt-com mt-3 mb-3 mr-2 text-justify response" value="{{$comment->response}}">
                                                            <div class="col-md-2 mt-4 response_send" data-id="{{$comment->id}}"><i class="fa fa-send-o"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                @endforeach
                            @else
                            <p>هیچ پیامی ثبت نشده است</p>
                            @endif
                        </div>
                    </div>


                </div>

            </div>


        </div>
    </div>


@endsection

@section('script')


    <script src="{{asset('/blog/js/jquery.js')}}"></script>
    <script src="{{asset('/js/sweetalert2/sweetalert2.all.min.js')}}"></script>

    <script>

        $(function () {
            $('.response_send').on('click', function (event) {
                event.preventDefault();

                let parent = $(this).closest('.box_com');
                let text = parent.find('.response').val();
                // let comment_id = parent.find('.comment_id').val();
                let comment_id = $(this).attr('data-id');


                let url = "/admin/comment/response";
                let method = 'POST';
                let data = {'text': text,  'id' : comment_id , '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            swal.fire("پیام شما با موفقیت ارسال شد")
                        }

                    },
                    error: function (xhr) {
                        alert('ارتباط با سرور قطع شده است.');
                        console.log(xhr)
                    }

                });
            });
        });

        $(function () {
            $('.change_status').on('change', function (event) {
                event.preventDefault();
                let button = $(this);
                let comment_id = $(this).attr('data-id');



                let url = "/admin/comment/status";
                let method = 'POST';
                let data = {'id' : comment_id , '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        console.log(response);
                        if (response.success) {

                            swal.fire(response.message)

                            // if (response.new_status === 1){
                            //     button[0].innerHTML = "عدم نمایش";
                            // }
                            // else {
                            //     button[0].innerHTML = "نمایش";
                            // }


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

