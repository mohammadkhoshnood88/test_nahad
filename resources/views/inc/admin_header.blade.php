<header class="header">
    <div class="navigation-trigger d-xl-none" data-sa-action="aside-open" data-sa-target=".sidebar">
        <i class="zwicon-hamburger-menu"></i>
    </div>

    <div class="logo d-none d-sm-inline-flex">
        <a href="/admin/dashboard">پنل ادمین 18 چرخ</a>
    </div>

    <form class="search">
        <div class="search__inner">
            <input type="text" class="search__text" placeholder="جستجو کنید ..." />
            <i class="zwicon-search search__helper"></i>
            <i class="zwicon-arrow-left search__reset" data-sa-action="search-close"></i>
        </div>
    </form>

    <ul class="top-nav">
        <li class="d-xl-none"><a href="/admin/dashboard" data-sa-action="search-open"><i class="zwicon-search"></i></a></li>

        <li class="dropdown">
            <a href="/admin/dashboard" data-toggle="dropdown" 
                                        class="<?php
                                                if(count(session('new_msg')) == 0) 
                                                echo " "; 
                                                else
                                                echo "top-nav__notify";
                                                ?> "><i class="zwicon-mail"></i></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                <div class="dropdown-header">
                   پیام ها

                    <div class="actions">
                        <a href="/admin/adm_received_message" class="actions__item zwicon-plus"></a>
                    </div>
                </div>

                <div class="listview listview--hover">
                    
                    <?php
                    $aa = session('new_msg');
                    foreach($aa as $a){
                        echo "<a href='/admin/adm_received_message' class='listview__item'>";
                        echo "<img src='/img/profiles/".rand(1,8) . ".jpg' class='avatar-img' alt='avatar'/>";
                        echo "<div class='listview__content'>";
                            echo "<div class='listview__heading'>";
                               echo $a->subject;
                                echo "<small>02:45 PM </small></div>";
                            echo "<p>";
                            echo $a->content;
                            echo "</p></div></a>";
                    }
                    ?>
                   
                    <a href="/admin/adm_received_message" class="view-more">نمایش پیام های بیشتر</a>
                </div>
            </div>
        </li>

        <li class="dropdown top-nav__notifications">
            <a href="/admin/dashboard" data-toggle="dropdown" class="
                                                <?php
                                                if(count(session('new_pay')) == 0) 
                                                echo " "; 
                                                else
                                                echo "top-nav__notify";
                                                ?>">
                <i class="zwicon-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                <div class="dropdown-header">
                   اعلان ها

                    <div class="actions">
                        <a href="/admin/dashboard" class="actions__item zwicon-checkmark-square clear_payment" data-sa-action="notifications-clear"></a>
                    </div>
                </div>

                <div class="listview listview--hover">
                    <div class="listview__scroll scrollbar">
                        
                    <?php
                    $aa = session('new_pay');
                    foreach($aa as $a){
                        echo "<a href='/admin/payments' class='listview__item'>";
                        echo "<div class='listview__content'>";
                            echo "<div class='listview__heading'>";
                            echo "<p>";
                               echo "عنوان آگهی : " . post_subject($a->post_id);
                               echo "</p>";
                                echo "</div>";
                            echo "<p>";
                            echo "مبلغ پرداختی : " . $a->amount;
                            echo "</p></div></a>";
                    }
                    ?>
                  
                    </div>

                    <div class="p-1"></div>
                </div>
            </div>
        </li>

        <li class="dropdown d-none d-sm-inline-block">
            <a href="/admin/dashboard" data-toggle="dropdown"><i class="zwicon-checkmark-circle"></i></a>

            <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                <div class="dropdown-header">کارهای درخواستی </div>

                <div class="listview listview--hover">
                    <a href="/admin/adm_manage" class="listview__item">
                        <div class="listview__content">
                            <div class="listview__heading">آگهی های فروش تایید نشده </div>

                            <div class="progress mt-1">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{session('task_deactives_post')}}%" aria-valuenow="{{session('task_deactives_post')}}" aria-valuemin="0" aria-valuemax="50"></div>
                            </div>
                        </div>
                    </a>

                    <a href="/admin/rent_ads_manage" class="listview__item">
                        <div class="listview__content">
                            <div class="listview__heading">آگهی های اجاره تایید نشده </div>

                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" style="width: {{session('task_deactives_rent')}}%" aria-valuenow="{{session('task_deactives_rent')}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </a>

                    <a href="/admin/adm_received_message" class="listview__item">
                        <div class="listview__content">
                            <div class="listview__heading">پیام های خوانده نشده </div>

                            <div class="progress mt-1">
                                <div class="progress-bar bg-success" style="width: {{session('task_new_msg')}}%" aria-valuenow="{{session('task_new_msg')}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </a>

                    <a href="index.html" class="listview__item">
                        <div class="listview__content">
                            <div class="listview__heading">بررسی پرداختی ها </div>

                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </li>

        <li class="dropdown d-none d-sm-inline-block">
            <a href="index.html" data-toggle="dropdown"><i class="zwicon-grid"></i></a>

            <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                <div class="row app-shortcuts">
                    <a class="col-4 app-shortcuts__item" href="index.html">
                        <i class="zwicon-calendar-never"></i>
                        <small class="">Calendar </small>
                    </a>
                    <a class="col-4 app-shortcuts__item" href="index.html">
                        <i class="zwicon-document"></i>
                        <small class="">Files </small>
                    </a>
                    <a class="col-4 app-shortcuts__item" href="index.html">
                        <i class="zwicon-mail"></i>
                        <small class="">Email </small>
                    </a>
                    <a class="col-4 app-shortcuts__item" href="index.html">
                        <i class="zwicon-line-chart"></i>
                        <small class="">Reports </small>
                    </a>
                    <a class="col-4 app-shortcuts__item" href="index.html">
                        <i class="zwicon-broadcast"></i>
                        <small class="">News </small>
                    </a>
                    <a class="col-4 app-shortcuts__item" href="index.html">
                        <i class="zwicon-image"></i>
                        <small class="">Gallery </small>
                    </a>
                </div>
            </div>
        </li>

        <li class="dropdown d-none d-sm-inline-block">
            <a href="index.html" data-toggle="dropdown"><i class="zwicon-more-h"></i></a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="index.html" class="dropdown-item" data-sa-action="fullscreen">تمام صفحه </a>
                <a href="/admin/dashboard" class="dropdown-item">رفرش کردن </a>
            </div>
        </li>

        <li class="d-none d-sm-inline-block">
            <a href="index.html" class="top-nav__themes" data-sa-action="aside-open" data-sa-target=".themes"><i class="zwicon-palette"></i></a>
        </li>
    </ul>

    <div class="clock d-none d-md-inline-block">
        <div class="time">
            <span class="time__hours"></span>
            <span class="time__min"></span>
            <span class="time__sec"></span>
        </div>
    </div>
</header>