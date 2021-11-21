@extends('layouts.admin')
<style>
    #output , #output2
    {
        width:50px;
        height:50px;
        
    }
    #textarea_subject
    {
        height: 245px;
    }
    #chooseimg-brand,#chooseimg-city{
            opacity: 0;
            top: 73px;
            right: 46px;
            left: 0;
            bottom: 0;
            position: absolute;
        
    }
</style>

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
                <!--<div class="actions">-->
                <!--    <a href="html-table.html" class="actions__item zwicon-cog"></a>-->
                <!--    <a href="/admin/adm_brand" class="actions__item zwicon-refresh-double"></a>-->

                <!--    <div class="dropdown actions__item">-->
                <!--        <i data-toggle="dropdown" class="zwicon-more-h"></i>-->
                <!--        <div class="dropdown-menu dropdown-menu-right">-->
                <!--            <a href="/admin/adm_brand" class="dropdown-item">بارگذاری مجدد</a>-->
                <!--            <a href="/admin/adm_brand" class="dropdown-item">لیست برند ها</a>                            -->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <h1 class="text-right"> ویرایش برند {{$brand->name}}</h1>

                
            </header>

            <div class="card">
                <div class="card-body" style="direction: rtl">
                    <!--<h4 class="card-title text-right">برند جدید خودرو </h4>     -->
                    
                    <form action="{{url('/brandupdate/')}}/{{$brand->id}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">نام برند</span>
                                    </div>
                                    <input type="text" id="brand_subject" name="brand" value="{{$brand->name}}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            کشور سازنده: (میتوانید از لیست موجود انتخاب کنید)
                                        </span>
                                    </div>
                                    <input type="text" id="brand_subject" name="country" value="{{$brand->country}}" class="form-control" list="countries" />
                                    
                                <datalist id="countries">
                                    @foreach($countries as $c)
                                    <option>{{$c}}</option>
                                    @endforeach

                                </datalist>
                                    
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> توضیحات</span>
                                        
                                    </div>
                                    <textarea id="textarea_subject" name="description" row="10" class="form-control" >{{$brand->description}}</textarea>
                                   
                                </div>
                            </div>
                             <div class="col-md-6">
                                 <div class="row">
                                      <div class="col-md-6">
                                <div class="card">
                                     <div class="card-body text-center">
                                         <h4 class="card-title text-right">عکس برند</h4>
                                         <!--<form class="dropzone" id="dropzone-upload"></form>-->
                                          <img id="output" src="{{asset("images/plusimg.png")}}"/>
                                          <input id="chooseimg-brand" type="file" accept="image/*" name="brand_img" onchange="loadFile(event)">
                                     </div>
                                 </div>
                             </div>
                                      <div class="col-md-6">
                                <div class="card">
                                     <div class="card-body text-center">
                                         <h4 class="card-title text-right">پرچم کشور</h4>
                                        
                                         <img id="output2" src="{{isset($brand->country_img) ? asset("brandIntro/" . $brand->country_img) : asset("images/plusimg.png") }}" />
                                          <input id="chooseimg-city" type="file" accept="image/*" name="country_img" onchange="loadFile2(event)">
                                     </div>
                                 </div>
                             </div>
                                 </div>
                             </div>
                             
                            <div class="col-md-6 text-center">
                                <button type="submit" id="brand_submit" class="btn btn-info btn--icon-text pl-4" style="font-size: 16px"><i class="zwicon-checkmark ml-1" style="font-size: 1.8rem;"></i> ویرایش </button>
                            </div>
                        </div> 
                        
                        </form>
                                                   
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    var loadFile = function(event) {

          var output = document.getElementById('output');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
          }
        };
         var loadFile2 = function(event) {


          var output = document.getElementById('output2');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
          URL.revokeObjectURL(output2.src) // free memory
          }
        };
</script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            
          

            
            // $("#brand_submit").on('click',function(){
            //     var brand_subject = $("#brand_subject").val();                

            //     if(brand_subject == "")

            //         Swal.fire({
            //             icon: 'error',
            //             title: 'خطا',
            //             text: 'عنوان را وارد کنید',                                
            //         });

            // });
        });

    </script>

@endsection

