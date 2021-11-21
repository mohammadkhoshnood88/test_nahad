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
</style>

    <section class="content">
        <div class="content__inner">
            <header class="content__title">
                <div class="actions">
                    <a href="html-table.html" class="actions__item zwicon-cog"></a>
                    <a href="/admin/adm_brand" class="actions__item zwicon-refresh-double"></a>

                    <div class="dropdown actions__item">
                        <i data-toggle="dropdown" class="zwicon-more-h"></i>
                        <div class="dropdown-menu dropdown-menu-right">

                        </div>
                    </div>
                </div>
                <h1 class="text-right"> مراکز معاینه فنی</h1>


            </header>
            @foreach($errors as $error)
                <span>{{$error}}</span>
            @endforeach
            <div class="card dir_rtl">
                <div class="card-body">
                    <h4 class="card-title text-right">تعریف مرکز جدید</h4>

                    <form action="{{route('add_tech_checkup')}}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">نام مرکز </span>
                                    </div>
                                    <input type="text" id="brand_subject" name="name" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">تلفن </span>
                                    </div>
                                    <input type="text" name="tel" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label>استان </label>
                                    <select type="text" id="states" name="state_id" class="form-control states w-100">
                                        <option>استان مورد نظر را وارد کنید</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label>شهر </label>
                                    <select type="text" name="city_id" id="city_id" class="form-control cities w-100">
                                        <option value="">ابتدا استان را انتخاب کنید</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">آدرس </span>
                                    </div>
                                    <input type="text" id="brand_subject" name="address" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn--icon-text pl-4"
                                            style="font-size: 16px"><i class="zwicon-checkmark ml-1"
                                                                       style="font-size: 1.8rem;"></i> ثبت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        @foreach($states as $state)
            <div class="col-md-12 col-sm-12 col-xs-12 exam-parent">
            <span class="exam-name">{{$state->name}} ({{count($state->techs())}})<span
                    class="fa fa-chevron-down"></span></span>
                <div class="row">


                        <div style="height: 320px;padding: 10px;display: none"
                             class="col-md-12 col-sm-12 col-xs-12 exam-child">
                            <div class="content-exam">
                                <div class="table-responsive text-center">
                                    <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام</th>
                                        <th scope="col">شهر</th>
                                        <th scope="col">آدرس</th>
                                        <th scope="col">تلفن</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($state->techs() as $techstate)
                                        <tr>
                                            <th scope="row">{{$loop->index +1}}</th>
                                            <th scope="row">{{$techstate->name}}</th>
                                            <td>{{$techstate->city()}}</td>
                                            <td>{{$techstate->address}}</td>
                                            <td>{{$techstate->tel}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                </div>

            </div>
        @endforeach


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
        $(function () {
            $('.exam-name').on('click', function () {
                let parent = $(this).closest('.exam-parent');
                let content = parent.find('.exam-child');
                $(content).slideToggle("slow");
            });
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
                        console.log(x.data);
                    var options = ""
                    
                    x.data.forEach(op => {
                        options += `<option value='${op.id}'>${op.name}</option>`
                    });

                    $('#city_id').html(options);
                    },
                    error:function(exception){
                        console.log(exception);
                    }

                });
            });
        });

    </script>

@endsection
