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
                    <a href="/admin/adm_year" class="actions__item zwicon-refresh-double"></a>

                </div>
                <h1 class="text-right"> سال تولید خودرو</h1>

                
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">سال تولید جدید خودرو </h4>     


                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">سال تولید </span>
                                    </div>
                                    <input type="text" id="year_subject" name="year_subject" class="form-control" />
                                </div>
                            </div>
    
                            <div class="col-md-6 text-center">
                                <button type="submit" id="year_submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ثبت </button>
                            </div>
                        </div> 
                                                   
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-right">لیست سال تولید خودرو </h4>                    

                    <div class="table-responsive text-center">
                        <table class="table text-center table-hover mb-0">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>سال تولید </th>
                                <th>آخرین آپدیت </th>
                                <th>عملیات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($year as $index => $year)
                                <tr>
                                    <th scope="row">{{$index+1}} </th>
                                    <td>{{$year->name}} </td>
                                    <td>{{$year->updated_at}} </td>
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
            
            $("#year_submit").on('click',function(){
                var year_subject = $("#year_subject").val();                

                if(year_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'سال تولید را وارد کنید',                                
                    });

                $.ajax({
                    url:'/yearstore',
                    data:{"year_subject":year_subject},
                    method:'post',
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'سال تولید جدید با موفقیت ثبت گردید',
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

