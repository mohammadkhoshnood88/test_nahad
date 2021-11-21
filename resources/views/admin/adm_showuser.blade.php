@extends('layouts.admin')

@section('content')

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
                    <h4 class="card-title text-right" style="direction: rtl">ویرایش کاربر {{$showuser->name}} </h4>

                    {!! Form::open(['action' => ['AdminController@update_user', $showuser->id], 'method' => 'post','files' => false]) !!}
                    @csrf

                    <div class="row" style="direction: rtl">
                        <div class="col-sm-7 m-auto">
                            <div class="input-group mb-5">
                                <div class="input-group-prepend">
                                    {{Form::label('newusername', 'نام کاربر', ['class' => 'input-group-text lable-rtl'])}}
                                </div>
                                {{Form::text('newusername', $showuser->name, ['class' => 'form-control lable-rtl'])}}

                            </div>
                        </div>

                        <div class="col-sm-7 m-auto">
                            <div class="input-group mb-5">
                                <div class="input-group-prepend">
                                    {{Form::label('newemail', 'ایمیل کاربر', ['class' => 'input-group-text lable-rtl'])}}
                                </div>
                                {{Form::email('newemail', $showuser->email, ['class' => 'form-control lable-rtl'])}}
                            </div>
                        </div>

                        <div class="col-sm-7 m-auto">
                            <div class="input-group mb-5">
                                <div class="input-group-prepend">
                                    {{Form::label('newpassword', 'پسورد', ['class' => 'input-group-text lable-rtl'])}}
                                </div>
                                {{Form::password('newpassword', ['class' => 'form-control lable-rtl', 'placeholder' => 'رمز جدید را وارد کنید'])}}

                            </div>
                        </div>

                        <div class="col-sm-7 m-auto">
                            <div class="input-group mb-5">
                                <div class="input-group-prepend">
                                    {{Form::label('roles', 'نقش', ['class' => 'input-group-text lable-rtl'])}}
                                </div>
                                {{--                                {{Form::select('roles', ['class' => 'form-control lable-rtl'])}}--}}
                                <select name="role" class="form-control" style="background: #49181e">
                                    @foreach($roles as $role)
                                        <option value="{{$role}}"
                                                @if(count($showuser->userpermissions) && $showuser->userpermissions[0]->role === $role) selected @endif>
                                            {{$role}}
                                        </option>
                                    @endforeach

                                </select>

                            </div>
                        </div>

                        <div class="col-sm-7 m-auto text-center">


                            {{Form::submit('ثبت تغییرات', ['class' => 'btn btn-success mt-3', 'id' => 'editbutton'])}}

                            <a href="/admin/adm_user">
                                <button class="btn btn-info  mt-3">بازگشت</button>
                            </a>

                        </div>
                    </div>

                    {!! Form::close() !!}

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

    </script>

@endsection

