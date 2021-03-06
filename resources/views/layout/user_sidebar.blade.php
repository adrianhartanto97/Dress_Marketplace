   

@if($login_info->login_status == true)
    <div class="col-xs-12 col-sm-3 col-md-2">
        <div class="row">
            <div class = "portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <img alt="" width="30px" class="img-circle" src="{{asset('/public/storage').'/'.$login_info->user_info->avatar}}" />
                        <span class="username username-hide-on-mobile"> <b>{{ $login_info->user_info->full_name }}</b> </span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row list-group">
                        <a href="{{url('/balance_detail')}}" class="list-group-item @if($active_nav == 'balance_detail')abu @else @endif" style="font-size:16px;">
                            <i class="fa fa-money"></i>
                            IDR {{ number_format($login_info->user_info->balance,0,",",".") }}
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p><b>My Store</b></p>
                            <p style="margin-top:-15px;">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        Notification
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row list-group">
                        <a href="{{url('/purchase')}}" class="list-group-item  @if($active_nav == 'purchase')abu @else @endif"> Purchase </a>
                        <a href="{{url('/request_for_quotation')}}" class="list-group-item  @if($active_nav == 'rfq')abu @else @endif"> Request for Quotation </a>                  
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="portlet box yellow">
                <div class="portlet-title">
                    <div class="caption" style="text-align: right;margin-right: 0px;padding-right: 0px;">
                        My Profile
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row list-group">
                        <a href="{{url('/my_wishlist')}}" class="list-group-item @if($active_nav == 'wishlist')abu @else @endif"> Wishlist </a>
                        <a href="{{url('/favorite_store')}}" class="list-group-item @if($active_nav == 'favorite_store')abu @else @endif"> Favorite Store </a>  
                        <a href="{{url('/settings')}}" class="list-group-item @if($active_nav == 'settings')abu @else @endif"> Settings </a>                 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif