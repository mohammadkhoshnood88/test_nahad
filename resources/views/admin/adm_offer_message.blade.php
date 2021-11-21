@extends('layouts.admin')

@section('content')

    <style>
        .exam-name {
            font-size: 14px;
            color: white;
            width: 100%;
            text-align: right;
            margin-bottom: 5px;
            margin-top: 3px;
            margin-right: 5px;
            display: inline-block;
            padding: 6px 12px;
            line-height: 1.42857143;
            vertical-align: middle;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.2);
        }

        .content-msg {
            width: 90%;
            background: rgba(0, 0, 0, .1);
            padding: 10px 5px;
            margin: 0 auto;
        }
    </style>

    <section class="content" style="text-align: right;direction: rtl;vertical-align: middle">

        <div class="p-2 m-2">برای پاسخ به هر پیام روی آن کلیک کنید.</div>

        @foreach($messages as $message)
            <div class="col-md-12 col-sm-12 col-xs-12 exam-parent">
                    <span class="exam-name">
                <div class="row mb-3 mt-1">
                     <span class="col-md-3 col-sm-1">عنوان : {{$message->subject}}</span>
                    <span class="col-md-4 col-sm-1">ایمیل : {{$message->email}}</span>
                    <span class="col-md-4 col-sm-1">شماره تماس : {{$message->phone_number}}</span>
                    <span class="col-md-1 col-sm-1 zwicon-chevron-down"></span>
                </div>
                <span class="mb-2">متن پیام : {{$message->content}}</span>



            </span>
                <div class="row">


                    <div style="display: none"
                         class="col-md-12 col-sm-12 col-xs-12 exam-child">
                        <div class="content-msg">

                            <div class="row">
                                <span class="col-md-11 col-sm-11">
                                    <input class="form-control response" value="{{$message->response ? $message->response : ""}}" placeholder="پاسخ خود را اینجا بنویسید...">
                                </span>
                                <span data-id="{{$message->id}}" style="font-size: 21px;padding: 7px"
                                      class="col-md-1 col-sm-1 zwicon-send send_response"></span>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        @endforeach

    </section>

@endsection

@section('scripts')

    <script>
        $(function () {
            $('.exam-name').on('click', function () {
                let parent = $(this).closest('.exam-parent');
                let content = parent.find('.exam-child');
                $(content).slideToggle("slow");
            });
        });

    </script>
    <script>
        $( document ).ready(function() {

            $('.send_response').on('click', function () {
                let id = $(this).data('id');
                let parent = $(this).closest('.exam-parent');
                let response = parent.find('.response').val();

                let url = "/admin/send/response";
                let method = 'POST';
                let data = {'id': id, 'response': response, '_token': "{{csrf_token()}}"};
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        console.log(response.success);

                        if (response.success) {
                            alert('پاسخ شما ثبت شد.')
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
