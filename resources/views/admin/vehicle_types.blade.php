@extends('layouts.admin')

@section('content')

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
                <h1 class="text-right">انواع ماشین سنگین</h1>


            </header>
            @foreach($errors as $error)
                <span>{{$error}}</span>
            @endforeach
            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">تعریف مرکز جدید</h4>

                    <form action="{{route('add_types')}}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">نوع ماشین </span>
                                    </div>
                                    <select type="text" id="states" name="state_id" class="form-control states">
                                        <option>نوع ماشین را انتخاب کنید</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">نام ویژگی </span>
                                    </div>
                                    <input type="text" id="brand_subject" name="name" class="form-control"/>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">مقادیر</span>
                                    </div>
                                    <input type="text" id="brand_subject" name="name" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-md-6">
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


@endsection
