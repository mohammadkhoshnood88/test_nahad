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
                    <a href="/admin/adm_cbody" class="actions__item zwicon-refresh-double"></a>

                </div>
                <h1 class="text-right"> وضعیت بدنه خودرو</h1>

                
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">وضعیت بدنه جدید خودرو </h4>     


                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">عنوان </span>
                                    </div>
                                    <input type="text" id="cbody_subject" name="cbody_subject" class="form-control" />
                                </div>
                            </div>
    
                            <div class="col-md-6 text-center">
                                <button type="submit" id="cbody_submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ثبت </button>
                            </div>
                        </div> 
                                                   
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-right">لیست وضعیت بدنه خودرو </h4>                    
                    
                    <div class="table-responsive text-center">
                        <table class="table text-center table-hover mb-0">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>وضعیت بدنه </th>
                                <th>آخرین آپدیت </th>
                                <th>عملیات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cbodies as $index => $cbody)
                                <tr>
                                    <th scope="row">{{$index+1}} </th>
                                    <td>{{$cbody->name}} </td>
                                    <td>{{$cbody->updated_at}} </td>
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
            
            $("#cbody_submit").on('click',function(){
                var cbody_subject = $("#cbody_subject").val();                

                if(cbody_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'عنوان را وارد کنید',                                
                    });

                $.ajax({
                    url:'/cbodystore',
                    data:{"cbody_subject":cbody_subject},
                    method:'post',
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'وضعیت بدنه جدید با موفقیت ثبت گردید',
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

