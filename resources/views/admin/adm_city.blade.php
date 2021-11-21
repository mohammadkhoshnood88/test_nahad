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
                    <a href="/admin/adm_city" class="actions__item zwicon-refresh-double"></a>

                </div>
                <h1 class="text-right"> شهر ها</h1>

                
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">اضافه کردن شهر جدید </h4>                 

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="" style="background-color: rgba(0,0,255,0.3);color: black;">استان مورد نظر را انتخاب نمایید</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" style="background-color: rgba(0,0,255,0.3);color: black;">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">نام شهر </span>
                                    </div>
                                    <input type="text" id="city_subject" name="city_subject" class="form-control" />
                                </div>
                            </div>
    
                            <div class="col-md-12 mt-4 text-center">
                                <button type="submit" id="city_submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ثبت </button>
                            </div>
                        </div> 
                                                   
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-right">لیست شهرهای ثبت شده </h4>                    

                    <div class="table-responsive text-center">
                        <table class="table text-center table-hover mb-0">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>نام استان </th>
                                <th>نام شهر </th>
                                <th>عملیات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $index => $city)
                                <tr>
                                    <th scope="row">{{$index+1}} </th>
                                    <td>{{$city->state->name}} </td>
                                    <td>{{$city->name}} </td>
                                    <td><button class="btn btn-outline-danger btnSwall" onclick="btnSwall();" style="font-family: 'YJ'">حذف</button> </td>
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

        $(document).ready(function() {
            
            $("#city_submit").on('click',function(){
                var city_subject = $("#city_subject").val();                

                if(city_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'نام شهر را وارد کنید',                                
                    });

                var state_id = $("#state_id").val();                

                if(state_id == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'استان خود را انتخاب کنید',                                
                    });

                $.ajax({
                    url:'/citystore',
                    data:{"city_subject":city_subject, "state_id":state_id},
                    method:'post',
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'شهر جدید با موفقیت ثبت گردید',
                            timer: 2000,
                            confirmButton: false,
                        }) 
                        
                        location.reload();
                                               
                    },                    
                    error:function(exception){
                        console.log(exception);
                    }                    
                });                
            });
        });

    </script>
@endsection
