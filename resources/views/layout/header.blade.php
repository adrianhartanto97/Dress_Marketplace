<div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="{{url('/index')}}" >
                            <img  src="{{asset('public/layouts/layout/img/dress.png')}}" alt="logo" class="logo-default" style="width: 200px;line-height: 200px;margin-top: 8px" /></a>
                        
                    </div>
<!-- 
                     <form class="search-form search-form-expanded" action="{{url('/search')}}"" method="GET">
                        <div class="input-group">
                              <form method="post" action="{{ action('Web_Controller\App2Controller@search') }}"  id="search" enctype="multipart/form-data">
                                <input type="text" class="form-control" placeholder="Search..." name="product_name" value="">
                                     <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit" form="search">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                            </form>
                        </div>
                    </form> -->

                    <form class="search-form search-form-expanded" action="{{ action('Web_Controller\App2Controller@search') }}"" method="post" id="search" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." name="product_name" value="" style="color: white;">
                             <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit" form="search">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                        </div>
                    </form>
                    
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
<!--
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
-->
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                       
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                            
                            @if($login_info->login_status == false)
                            <li class="dropdown dropdown-user">
                                <a href="{{url('/login_page')}}" style="color:white">
                                    <span class="username"> <b>Login</b> </span>
                                    <i class="icon-login"></i>
                                </a>
                            </li>
                            
                            @else
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
<!--                                     <span class="badge badge-default"> 7 </span>
 -->                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{url('/purchase')}}" class="list-group-item"> Purchase </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="list-group-item"> Request for Quotation </a>                  
                                    </li>
                                </ul>
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->
                            <!-- BEGIN INBOX DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-extended" id="header_inbox_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="fa fa-building-o"></i>
<!--                                     <span class="badge badge-default"> 4 </span>
 -->                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                         <div class="col-md-2">
                                         </div>

                                        <div class="col-md-8" style="width: 100%">
                                            <p><b>My Store</b></p>
                                            <p style="margin-top:-15px;text-align: center;">
                                                @if ($login_info->user_store_info->have_store == true)
                                                    <i class="fa fa-building"></i>
                                                    {{$login_info->user_store_info->store->store_name}}
                                                @else
                                                    no store yet
                                                @endif
                                            </p>
                                            @if ($login_info->user_store_info->have_store == true)
                                                <a href="{{url('/seller_panel')}}" style="margin-top:-10px;" type="button" class="btn blue btn-sm btn-block">Open Seller Panel</a>
                                            @else
                                                <a href="{{url('/open_store')}}" style="margin-top:-10px;" type="button" class="btn blue btn-sm btn-block">Open Store</a>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <br>
                                         </div>

                                    </li>
                                </ul>
                            </li>
                            <!-- END INBOX DROPDOWN -->
                            <!-- BEGIN TODO DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bag"></i>
                                    @if($login_info->user_cart_info->total_qty != 0)
                                    <span class="badge badge-default"> {{$login_info->user_cart_info->total_qty}} </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu extended tasks">
                                    <li class="external">
                                        <h3>
                                             @if($login_info->user_cart_info->total_qty != 0)
                                            <span class="bold">{{$login_info->user_cart_info->total_qty}} items</span> in shopping bag
                                            @else
                                                shopping bag is empty
                                            @endif
                                        </h3>
                                        
                                        @if ($login_info->user_cart_info->total_qty != 0)
                                            <a href="{{url('/view_shopping_bag')}}">view all</a>
                                        @endif
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                            @foreach ($login_info->user_cart_info->bag as $store)
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">{{$store->store_name}}</h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="list-group">
                                                            @foreach ($store->product as $p)
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <img class="img-responsive" src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="100%" style="margin: 0 auto;">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            <b>{{$p->product_name}}</b>
                                                                        </div>
                                                                        <div class="row">
                                                                            Total : {{$p->total_qty}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <!-- <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Application deployment</span>
                                                        <span class="percent">65%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">65% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Mobile app release</span>
                                                        <span class="percent">98%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">98% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Database migration</span>
                                                        <span class="percent">10%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">10% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Web server upgrade</span>
                                                        <span class="percent">58%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">58% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Mobile development</span>
                                                        <span class="percent">85%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">85% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">New UI release</span>
                                                        <span class="percent">38%</span>
                                                    </span>
                                                    <span class="progress progress-striped">
                                                        <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">38% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- END TODO DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{asset('/public/storage').'/'.$login_info->user_info->avatar}}" />
                                    <span class="username username-hide-on-mobile"> <b>{{ $login_info->user_info->full_name }}</b> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        

                                        <a href="{{url('/settings')}}">
                                            <i class="icon-user"></i> Settings </a>
                                    </li>
                                   
                                    <li>
                                        <a href="{{url('/logout')}}">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<!--
                            <li class="dropdown dropdown-quick-sidebar-toggler">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <i class="icon-logout"></i>
                                </a>
                            </li>
-->
                            <!-- END QUICK SIDEBAR TOGGLER -->
                            @endif
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>