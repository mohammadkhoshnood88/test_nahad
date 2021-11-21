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
                <div>
                    
                    <a href="/admin/add_brand" class="btn btn-light">ثبت برند جدید</a>
                    <!--<a href="/admin/adm_brand" class="actions__item zwicon-refresh-double"></a>>-->

                    <!--<div class="dropdown actions__item">-->
                    <!--    <i data-toggle="dropdown" class="zwicon-more-h"></i>-->
                        <!--<div class="dropdown-menu dropdown-menu-right">-->
                            
                            <!--<a href="/admin/adm_brand" class="dropdown-item">بارگذاری مجدد</a>-->
                            <!--a>                            -->
                        <!--</div>-->
                    <!--</div>-->
                </div>
                <h1 class="text-right">لیست برند ها </h1>

                
            </header>

            <div class="card dir_rtl">
                <div class="card-body">
                    <h4 class="card-title text-right">برندهای معروف خودرو </h4>                    
                    <div class="table-responsive text-center">
                        <table class="table">
                        <thead>
                            <tr>
                                <th># </th>
                                 <th>عکس برند</th>
                                <th>نام برند </th>
                                <th>کشور سازنده </th>
                                <th>عملیات </th>
                            </tr>
                        </thead>
                        <tbody id="card-body">
                            @foreach ($brands as $index => $brand)
                                <tr>
                                    <td scope="row">{{$index+1}} </td>
                                    <td>

                                        @if(isset($brand->brand_img))
                                        <img class="rounded-5" id="output2" src="{{asset("brandIntro/" . $brand->brand_img) }}" />
                                        @endif
                                                                                
                                    </td>
                                    <td>{{$brand->name}} </td>
                                    <td>
                                        
                                        {{$brand->country}} - 

                                        @if(isset($brand->country_img))
                                        <img class="rounded-5" id="output2" src="{{asset("brandIntro/" . $brand->country_img) }}" />
                                        @endif                                        
                                        
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-info btnSwall"  href="/admin/edit_brand/{{$brand->id}}">ویرایش</a>
                                        <button class="btn btn-outline-danger btnSwall" onclick="btnSwall();" style="font-family: 'YJ'">حذف</button>                                        
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
        async function btnSwall(){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'این رکورد حذف شود؟',
                text: " ! بعد از حذف کردن امکان بازگشت وجود ندارد",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'حذف کن',
                cancelButtonText: 'منصرف شدم ',
                reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        swalWithBootstrapButtons.fire(
                        ' ! حذف شد',
                        ' ! رکورد مورد نظر حذف شد',
                        'success'
                        )
                    }   else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ){
                            swalWithBootstrapButtons.fire(
                            'کنسل',
                            ' :) رکورد حذف نشد',
                            'error'
                            )
                        }
                })
            }
        

    </script>
@endsection

