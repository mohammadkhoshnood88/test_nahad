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
                    <a href="/admin/adm_state" class="actions__item zwicon-refresh-double"></a>

                </div>
                <h1 class="text-right"> استان ها</h1>

                
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">استان جدید </h4>     


                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">استان ها </span>
                                    </div>
                                    <input type="text" id="state_subject" name="state_subject" class="form-control" />
                                </div>
                            </div>
    
                            <div class="col-md-6 text-center">
                                <button type="submit" id="state_submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ثبت </button>
                            </div>
                        </div> 
                                                   
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-right">لیست استان ها </h4>                    

                    <div class="table-responsive text-center">
                        <table class="table text-center table-hover mb-0">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>نام استان </th>
                                <th>آخرین آپدیت </th>
                                <th>عملیات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($state as $index => $state)
                                <tr>
                                    <th scope="row">{{$index+1}} </th>
                                    <td>{{$state->name}} </td>
                                    <td>{{$state->updated_at}} </td>
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
            
            $("#state_submit").on('click',function(){
                var state_subject = $("#state_subject").val();                

                if(state_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'نام استان را وارد کنید',                                
                    });

                $.ajax({
                    url:'/statestore',
                    data:{"state_subject":state_subject},
                    method:'post',
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'استان جدید با موفقیت ثبت گردید',
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

