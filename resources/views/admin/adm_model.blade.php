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
                    <a href="/admin/adm_model" class="actions__item zwicon-refresh-double"></a>

                </div>
                <h1 class="text-right"> مدل ها</h1>

                
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">اضافه کردن مدل جدید </h4>                 

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="cbrand_id" id="cbrand_id" class="form-control">
                                        <option value="" style="background-color: rgba(0,0,255,0.3);color: black;">انتخاب نمایید</option>
                                        @foreach($cbrands as $cbrand)
                                            <option value="{{$cbrand->id}}" style="background-color: rgba(0,0,255,0.3);color: black;">{{ $cbrand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">عنوان </span>
                                    </div>
                                    <input type="text" id="cmodel_subject" name="cmodel_subject" class="form-control" />
                                </div>
                            </div>
    
                            <div class="col-md-12 mt-4 text-center">
                                <button type="submit" id="cmodel_submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ثبت </button>
                            </div>
                        </div> 
                                                   
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-right">مدل برندهای معروف خودرو </h4>                    

                    <div class="table-responsive text-center">
                        <table class="table text-center table-hover mb-0">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>نام برند </th>
                                <th>نام مدل </th>
                                <th>عملیات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cmodels as $index => $cmodel)
                                <tr>
                                    <th scope="row">{{$index+1}} </th>
                                    <td>{{$cmodel->cbrand->name}} </td>
                                    <td>{{$cmodel->name}} </td>
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
            
            $("#cmodel_submit").on('click',function(){
                var cmodel_subject = $("#cmodel_subject").val();                

                if(cmodel_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'عنوان را وارد کنید',                                
                    });

                var cbrand_id = $("#cbrand_id").val();                

                if(cbrand_id == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'نوع برند خودرو را انتخاب کنید',                                
                    });

                $.ajax({
                    url:'/cmodelstore',
                    data:{"cmodel_subject":cmodel_subject, "cbrand_id":cbrand_id},
                    method:'post',
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'مدل جدید با موفقیت ثبت گردید',
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
