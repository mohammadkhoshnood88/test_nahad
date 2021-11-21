@extends('layouts.admin')

@section('content')
    <style>
        .exam-name {
            font-size: 14px;
            font-weight: bold;
            color: #73879C;
            width: 100%;
            text-align: right;
            margin-bottom: 5px;
            margin-right: 5px;
            display: inline-block;
            padding: 6px 12px;
            line-height: 1.42857143;
            vertical-align: middle;
            cursor: pointer;
            background: rgba(0,0,0,0.2);
        }
       
      .table-responsive::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgb(0 0 0 / 30%);
            background-color: #c4c0c000;
            border-radius: 10px;
            overflow: hidden;
      }

      .table-responsive::-webkit-scrollbar {
        width: 7px;
        border-radius: 10px;
        height: 5px;
        background-color: #bfb5b500;
      }

      .table-responsive::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background-image: -webkit-gradient( linear, left bottom, left top, 
        color-stop(0.44, rgb(238 237 219 / 20%)), 
        color-stop(0.72, rgba(230, 225, 211, 0.377)), 
        color-stop(0.86, rgba(248, 246, 237, 0.808)) );
}
    </style>


    <section class="content">
        <div class="content__inner">
            <header class="content__title">
                <h1 class="text-right">لیست بیمه </h1>
            </header>
            <div
             class="col-md-12 col-sm-12 col-xs-12 exam-child">
            <div class="content-exam">
                <div class="table-responsive text-center dir_rtl">
                    <table class="table table-hover table-dark table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">نام</th>
                        <th scope="col">استان-شهر</th>
                        <th scope="col">آدرس</th>
                        <th scope="col">تلفن</th>
                        <th scope="col">تصویر</th>
                        <th scope="col">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($insurances as $insurance)
                        <tr>
                            <th scope="row">{{$loop->index +1}}</th>
                            <th scope="row">{{$insurance->name}}</th>
                            <td>{{$insurance->state->name}}-{{$insurance->city->name}}</td>
                            <td>{{$insurance->address}}</td>
                            <td>{{$insurance->phone_number}}</td>
                            <td>
                                <img style="height: 100px;width: 100px" src="/post_images/related_images_watermark/{{$insurance->main_img}}">
                            </td>
                            <td>
                                <button id="remove-insurance" class="btn btn-outline-danger btnSwall remove_intro" style="font-family: 'YJ'">حذف</button> 
                                <a id="edit-insurance" href="/admin/insurance/{{$insurance->id}}/edit" class="btn btn-outline-success btnSwall edit_intro" style="font-family: 'YJ'">ویرایش</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
        </div>
    </section>


@endsection

@section('scripts')
    <script type="text/javascript">


        $(document).ready(function () {
            $(".states").select2({});
        });

        $(document).ready(function () {
            $(".cities").select2({});
        });
    </script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {

            $("#states").on('change', function () {
                var state_id = $("#states").val();

                if (state_id == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'عنوان را وارد کنید',
                    });

                var pdata = {"stateId":state_id};
                $.ajax({
                    url:'/posts/getCity',
                    data:pdata,
                    method:'post',
                    success:function(x){
                    var cities_item = ""
                    x.data.forEach(op => {
                        cities_item += `<option value='${op.id}'>${op.name}</option>`

                    });
                    $("#city_id").empty();
                    $("#city_id").append(cities_item);
                    },
                    error:function(exception){
                        console.log(exception);
                    }

                });
            });
        });

    </script>

@endsection
