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
                    <a href="data-table.html" class="actions__item zwicon-cog"></a>
                    <a href="/admin/adm_manage" class="actions__item zwicon-refresh-double"></a>

                    <div class="dropdown actions__item">
                        <i data-toggle="dropdown" class="zwicon-more-h"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="data-table.html" class="dropdown-item">Manage Widgets </a>
                            <a href="data-table.html" class="dropdown-item">Settings </a>
                        </div>
                    </div>
                </div>

                <h1 class="text-right">لیست آگهی ها </h1>
            </header>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-right">آگهی های ثبت شده </h4>
                    <h6 class="card-subtitle text-right">از طریق لیست زیر می توانید آگهی ها را مدیریت کنید </h6>

                    <div class="table-responsive text-center">
                        <table class="table" style="direction: rtl" id="table-rent">
                            <thead>
                            <tr>
                                <th># </th>
                                <th>تصویر آگهی </th>
                                <th>عنوان </th>
                                <th>شماره تماس </th>
                                <th>وضعیت آگهی </th>
                                <th>عملیات </th>
                            </tr>
                            </thead>
                            <tbody id="rent-body">
                            @foreach ($rents as $index => $post)
                                <tr>
                                    <th scope="row">{{$loop->index+1}} </th>
                                    <td style="width: 150px"><img class="img-rounded" src="/post_images/related_images_watermark/{{$post->image_path}}" alt="" style="width: 100%"> </td>
                                    <td>{{$post->subject}} </td>
                                    <td>{{$post->phone_number}} </td>
                                    <td>
                                        <?php
                                        $active = $post->is_active;
                                        $pending = $post->is_pending;

                                        if ($pending == "1" && $active == "1") {
                                            echo "<p style='color:#00bcd4'>تایید شد</p> / <p style='color:greenyellow'>منتشر شد</p>";
                                        } else if ($pending == "0" && $active == "1") {
                                            echo "<p style='color:#ff9800'>منتظر تایید</p> / <p style='color:greenyellow'>منتشر شد</p>";
                                        } else if ($pending == "1" && $active == "0") {
                                            echo "<p style='color:#00bcd4'>تایید شد</p> / <p style='color:red'>منتشر نشد</p>";
                                        } else {
                                            echo "<p style='color:#ff9800'>منتظر تایید</p> / <p style='color:red'>منتشر نشد</p>";
                                        }

                                        ?>

                                    </td>
                                    <td>
                                        <button class="btn btn-outline-danger btnSwall" onclick="btnSwall();" style="font-family: 'YJ'">حذف</button>
                                        <a href="/admin/rents/{{$post->id}}/edit" class="btn btn-outline-info btnSwall" onclick="btnSwall();" style="font-family: 'YJ'">ویرایش</a>
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
 
    $(document).ready(function () {
             
        var h = 2 * $("#rent-body").height() / 3;
        var page = 2;
        var c = 2;
        
        $(window).scroll(function () {
            

        if ($(window).scrollTop() > h) {
            
            loadMoreData(page , c);
            
            page = page + 1;
            c = c + 2;
            h = $('#card-body').height()
        }
        
        // console.log("------"+ $(window).scrollTop() +"----------"+ h +"-------------"+ page +"-------")

    });    
        
        function loadMoreData(page , c) {
        
        var data = {'page': page , '_token': "{{csrf_token()}}"};
        
        var url = '/admin/adm_manage';
        var req_type = "GET";

        $.ajax({
            type: req_type,
            url: url,
            data: data,

            success: function (response) {
                
                console.log(response)
                
                var posts = response.data.data;
                console.log(posts)
                var boxes = "";

                posts.forEach(function (post, i) {
                    console.log(i)
                    boxes += `
                             <tr class="post_box">
                                    <td scope="row">${(c*10) +1 + i}</td>
                                    <td style="width: 150px"><img class="img-rounded"
                                                                  src="/post_images/related_images_watermark/${post.image_path}"
                                                                  alt="" style="width: 100%"></td>
                                    <td>${post.subject}</td>
                                    <td>${post.phone_number}</td>
                                    <td class="post_status">
                              ${set_status(post.is_active , post.is_pending , post.is_delete , post.own_delete)}
                                    </td>
                                    <td>
                                    <button type="submit" data-id="{{$post->id}}" class="btn btn-outline-danger btnSwall remove_btn">حذف</button>
                                    </td>
                                    <td>
                                        <a href="/admin/${post.id}/edit" class="btn btn-outline-info btnSwall"
                                        style="font-family: 'YJ' ; padding: 6px!important;">ویرایش</a>
                                    </td>
                                </tr>
                                `;
                });
                

                if (boxes){
                    $('#card-body').append(boxes);
                }
            }
        });

    }
         })
         
    function set_status(is_active , is_pending , is_delete , own_delete){
        
        var active = is_active;
        var pending = is_pending;
        var delet = is_delete;
        var own_delete = own_delete;
        
        if (delet === "0") {
            if (pending === "1" && active === "1") {
                return "<p style='color:#00bcd4'>تایید شد</p> / <p style='color:greenyellow'>منتشر شد</p>";
                    } else if (pending === "0" && active === "1") {
                return "<p style='color:#ff9800'>منتظر تایید</p> / <p style='color:greenyellow'>منتشر شد</p>";
                    } else if (pending === "1" && active === "0") {
                return "<p style='color:#00bcd4'>تایید شد</p> / <p style='color:red'>منتشر نشد</p>";
                    } else {
                return "<p style='color:#ff9800'>منتظر تایید</p> / <p style='color:red'>منتشر نشد</p>";
                    }
        } else if (own_delete === "1") {
                return "<p style='color:red'>منقضی شد</p>";
        }
    }
    
    function set_btn(x , y){
        
        if(x === "0"){
            return "<form><button type='submit' class='btn btn-outline-danger btnSwall'>حذف</button></form>";
        }else{
            return "<a href='/admin/re_active' class='btn btn-outline-success btnSwall' style='padding: 6px!important;'>تمدید</a>"
        }
    }

    </script>
    <script>
        
        $(document).ready(function () {
            $('.remove_btn').on('click', function () {
                
            var id = $(this).data('id');
            
            let parent = $(this).closest('.post_box');
            let status = parent.find('.post_status');

            $.ajax({
                url: '/admin/delete/post',
                data: {"id": id},
                method: 'post',
                success: function (x) {
                    
                    status.html("<p style='color:red'>حذف شد</p>")
                    
                },
                error: function (exception) {
                    console.log(exception);
                }

            });

            })
        })
        
    </script>
    
    
@endsection

