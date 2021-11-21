@extends('layouts.admin')

@section('content')
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
                <div class="actions">
                    <a href="html-table.html" class="actions__item zwicon-cog"></a>
                    <a href="/admin/adm_user" class="actions__item zwicon-refresh-double"></a>
                </div>
                <h1 class="text-right"> مدیریت کاربران</h1>
            </header>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            <div id="new_user_register" class="btn btn-light" style="cursor: pointer">ثبت یوزر جدید</div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <h4 class="card-title text-right m-0">لیست یوزرهای مدیریت </h4>
                        </div>
                    </div>

                    <div id="register_panel" style="width: 50%;direction: rtl;display: none">


                        <div class="mb-3 p-1 register_content">
                            <input class="form-control user_name m-2" placeholder="نام کاربری">
                            <input class="form-control user_email m-2" placeholder="ایمیل">
                            <p>در صورت خالی گذاشتن رمز عبور به صورت رندم رمز عبور انتخاب می گردد</p>
                            <input class="form-control user_password m-2" placeholder="رمز عبور">
                            <select class="form-control user_role m-2">
                                <option>نقش کاربر را تعیین کنید</option>
                                @foreach($roles as $role)
                                    <option value="{{$role['name']}}">
                                        {{$role['role']}}
                                    </option>
                                @endforeach

                            </select>

                            <button class="set_new_user btn btn-success m-1">ثبت</button>
                        </div>

                    </div>

                    <div class="table-responsive text-center dir_rtl">
                        <table class="table text-center table-hover mb-0 mt-1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربری</th>
                            <th>ایمیل</th>
                            <th>نقش</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <th scope="row">{{$index+1}} </th>
                                <td>{{$user->name}} </td>
                                <td>{{$user->email}} </td>
                                <td>{{count($user->userpermissions) === 1 ? $user->userpermissions[0]->role : 'تعیین نقش نشده است'}}</td>
                                <td><a href="/admin/adm_showuser/{{$user->id}}">
                                        <button class="btn btn-outline-info btnSwall" id="btn_info"
                                                style="font-family: 'YJ'">ویرایش
                                        </button>
                                    </a></td>
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

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {

            $("#btn_info").on('click', function () {
                var year_subject = $("#year_subject").val();

                if (year_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'سال تولید را وارد کنید',
                    });

                $.ajax({
                    url: '/yearstore',
                    data: {"year_subject": year_subject},
                    method: 'post',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'سال تولید جدید با موفقیت ثبت گردید',
                            timer: 2000,
                            confirmButton: false,
                        })

                        location.reload();

                    },
                    error: function (exception) {
                        console.log(exception);
                    }
                });
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $("#new_user_register").click(function () {
                $("#register_panel").slideToggle("slow");
            });
        });

        $(function () {
            $('.set_new_user').on('click', function (event) {

                event.preventDefault();


                let user_name = $('.user_name').val();
                let user_email = $('.user_email').val();
                let user_password = $('.user_password').val();
                let user_role = $('.user_role').val();


                let url = "/admin/add_new_user";
                let method = 'POST';
                let data = {'user_name': user_name, 'user_email' : user_email ,  'user_password' : user_password , 'user_role':user_role ,   '_token': "{{csrf_token()}}"};

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function (response) {
                        console.log(response);

                        if (response.status) {

                            // swal({
                            //     title: "کاربر جدید ثبت شد",
                            //     text: "نام کاربری : " + user_name + "رمز عبور :" + response.password,
                            //     icon: "success",
                            //     button: "تایید",
                            // });

                            alert(
                                'نام کاربری : ' + response.name + "  " +
                                'رمز عبور : ' + response.password
                            )

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

