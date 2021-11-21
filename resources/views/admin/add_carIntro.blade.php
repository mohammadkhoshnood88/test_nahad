@extends('layouts.admin')

@section('content')
<style>
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
    #brand option , #model option
    {
        color:black !important;
    }
    
</style>
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
                <h1 class="text-right"> اضافه کردن مشخصات فنی</h1>
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <h4 class="card-title text-right">مشخصات فنی جدید خودرو </h>     
                    
                    <form action="{{route('add_carintro')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">برند: </span>
                                    </div>
                                    <select id="brand" class="form-control">
                                        <option>برند</option>
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">مدل: </span>
                                    </div>
                                    <select id="model" name="model" class="form-control">
                                        
                                        <option value="">مدل</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
نوع موتور: </span>
                                    </div>
                                    <input type="text" id="engine_type" name="engine_type" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
سیستم ترمز: </span>
                                    </div>
                                    <input type="text" id="brake" name="brake" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
حجم موتور: </span>
                                    </div>
                                    <input type="text" id="engine_volume" name="engine_volume" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
نوع گیربکس : </span>
                                    </div>
                                    <input type="text" id="gearbox" name="gearbox" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
نوع سوخت : </span>
                                    </div>
                                    <input type="text" id="fuel_type" name="fuel_type" class="form-control" />
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">قدرت موتور : </span>
                                    </div>
                                    <input type="text" id="engine_power" name="engine_power" class="form-control" />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
سیستم تعلیق : </span>
                                    </div>
                                    <input type="text" id="suspension" name="suspension" class="form-control" />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
تعداد دنده : </span>
                                    </div>
                                    <input type="text" id="gear_count" name="gear_count" class="form-control" />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">تعداد سیلندر : </span>
                                    </div>
                                    <input type="text" id="cylinder_count" name="cylinder_count" class="form-control" />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">
استاندارد آلایندگی : </span>
                                    </div>
                                    <input type="text" id="pollution" name="pollution" class="form-control" />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">گشتاور : </span>
                                    </div>
                                    <input type="text" id="torque" name="torque" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-width-me">سیستم سوخت رسانی : </span>
                                    </div>
                                    <input type="text" id="fuel_system" name="fuel_system" class="form-control" />
                                </div>
                            </div>
    
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ثبت </button>
                            </div>
                        </div>
                    </form>
                                                   
                </div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="content__inner">
            <header class="content__title">

                <h1 class="text-right">لیست برند ها </h1>

                
            </header>

            <div class="card dir_rtl">
                <div class="card-body">
                    <h4 class="card-title text-right">برندهای معروف خودرو </h4>                    
                    <div class="table-responsive text-center">
                        <table class="table table-hover table-dark table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th># </th>
                                <th>برند</th>
                                <th> مدل</th>
                                <th>نوع موتور </th>
                                <th>سیستم ترمز </th>
                                <th>حجم موتور</th>
                                <th>نوع گیربکس</th>
                                <th>نوع سوخت </th>
                                <th>قدرت موتور </th>
                                <th>سیستم تعلیق </th>
                                <th>تعداد دنده </th>
                                <th>تعداد سیلندر</th>
                                <th>استاندارد آلایندگی </th>
                                <th>گشتاور </th>
                                <th>سیستم سوخت رسانی </th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="card-body">
                            
                                @foreach($intros as $intro)
                                <tr class="body_intro">
                                    <td scope="row"> {{$loop->index + 1}} </td>
                                    
                                    <td class="intro_brand"> {{$intro->cmodel->cbrand->name}} </td>
                                    <td class="intro_model" data-id="{{$intro->cmodel->id}}"> {{$intro->cmodel->name}} </td>
                                    <td class="intro_engine_type"> {{$intro->engine_type}} </td>
                                    <td class="intro_brake"> {{$intro->brake}} </td>
                                    <td class="intro_engine_volume"> {{$intro->engine_volume}} </td>
                                    <td class="intro_gearbox"> {{$intro->gearbox}} </td>
                                    <td class="intro_fuel_type"> {{$intro->fuel_type}} </td>
                                    <td class="intro_engine_power"> {{$intro->engine_power}} </td>
                                    <td class="intro_suspension"> {{$intro->suspension}} </td>
                                    <td class="intro_gear_count"> {{$intro->gear_count}} </td>
                                    <td class="intro_cylinder_count"> {{$intro->cylinder_count}} </td>
                                    <td class="intro_pollution"> {{$intro->pollution}} </td>
                                    <td class="intro_torque"> {{$intro->torque}} </td>
                                    <td class="intro_fuel_system"> {{$intro->fuel_system}} </td>
                                    <td>
                                        <button data-id="{{$intro->id}}" class="btn btn-outline-danger btnSwall remove_intro" style="font-family: 'YJ'">حذف</button>    
                                        <button id="edit-fanni" class="btn btn-outline-success btnSwall edit_intro" style="font-family: 'YJ'">ویرایش</button>  
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

    <script>
    $(".edit_intro").on('click',function(){
        
        var body_intro = $(this).closest('.body_intro')
        
        $('#engine_type').val(body_intro.find('.intro_engine_type').text())
        $('#brake').val(body_intro.find('.intro_brake').text())
        $('#engine_volume').val(body_intro.find('.intro_engine_volume').text())
        $('#gearbox').val(body_intro.find('.intro_gearbox').text())
        $('#fuel_type').val(body_intro.find('.intro_fuel_type').text())
        $('#engine_power').val(body_intro.find('.intro_engine_power').text())
        $('#suspension').val(body_intro.find('.intro_suspension').text())
        $('#gear_count').val(body_intro.find('.intro_gear_count').text())
        $('#cylinder_count').val(body_intro.find('.intro_cylinder_count').text())
        $('#pollution').val(body_intro.find('.intro_pollution').text())
        $('#torque').val(body_intro.find('.intro_torque').text())
        $('#fuel_system').val(body_intro.find('.intro_fuel_system').text())
        
        var intro_brand = body_intro.find('.intro_brand').text();
        $('#brand').append(`<option selected>` + intro_brand + `</option>`);
        
        var intro_model = body_intro.find('.intro_model').text();
        var intro_model_id = body_intro.find('.intro_model').data('id');
        $('#model').empty();
        $('#model').append(`<option selected value='${intro_model_id}'>${intro_model}</option>`);
        
        
        
        
        
        
         document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    })

    
    
    

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            
        $('#brand').on('change', function () {
            var cbrandId = $(this).val();
            $("#model").empty();
            $("#model").append(`<option value="">مدل</option>`);

            if (cbrandId == "")
                return;

            var pdata = {"cbrandId": cbrandId , 'intro' : true};
            $.ajax({
                url: '/posts/ajax/models',
                data: pdata,
                method: 'post',
                success: function (x) {
                    
                    // console.log(x.data);
                    
                    var opt = ""
                    
                    x.data.forEach(op => {
                        opt += `<option value='${op.id}'>${op.name}</option>`
                    });
                    $("#model").append(opt);
                    
                },
                error: function (exception) {
                    console.log(exception);
                }

            });
        });            
            
            $("#brand_submit").on('click',function(){
                var brand_subject = $("#brand_subject").val();                

                if(brand_subject == "")

                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'عنوان را وارد کنید',                                
                    });

                $.ajax({
                    url:'/brandstore',
                    data:{"brand_subject":brand_subject},
                    method:'post',
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'تایید',
                            text: 'برند جدید با موفقیت ثبت گردید',
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

            $(".remove_intro").on('click',function(){
                var intro_id = $(this).data('id');
                let body_intro = $(this).closest('.body_intro');
                

                $.ajax({
                    url:'/admin/remove/intro',
                    data:{"intro_id":intro_id , "_token": "{{ csrf_token() }}"},
                    method:'post',
                    success:function(data){
                        if(data.success){
                            body_intro.remove();
                        }
                        
                    },                    
                    error:function(exception){
                        console.log(exception);
                    }                    
                });                
            });            
        });

    </script>

@endsection

