@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ HTML::style('public/css/iconeffects.css')}}
   
    <style>
       a {
           text-decoration:none;
       }
    </style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">

        <div class="row" style="padding:0px 10px;">
            @include('layout.user_sidebar',['login_info' => $login_info])
            <div class="col-xs-12 col-sm-9 col-md-10" >
                    <div class="tab-content">
                               
                        @if (session()->has('status') && session()->get('status') == false)
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <span>{{ session('message')}}</span>
                            </div>
                        @elseif (session()->has('status') && session()->get('status') == true)
                            <div class="alert alert-success">
                                <button class="close" data-close="alert"></button>
                                <span>{{ session('message')}}</span>
                            </div>
                        @endif
                       
                         
                        <div class="portlet light bordered">
                            <div class="row" style="text-align:center;">
                                <h1>Favorite Store</h1>
                            </div>
                        </div>
                        <div class="portlet light bordered">
                            <div class="portlet-body">
                                  <div class="row">
                                    @foreach ($result->result as $w)
                                    <a href="store_detail/{{$w->store_id}}"  style="text-decoration:none;">
                                        <div class="col-lg-3 col-xs-6 col-sm-4 col-md-3 center">
                                            <div class="thumbnail">
                                                <img src="{{asset('/public/storage/').'/'.$w->photo}}" alt="" style="width: 100%; height: 170px;">
                                                    <div style="height: 60px;">
                                                         <h4 class="black">
                                                            @if(strlen($w->name) > 60 )
                                                            {{substr($w->name,0,60)."..."}}
                                                            @else
                                                            {{$w->name}}
                                                            @endif
                                                        </h4>
                                                    </div>
                                                   
                                                 <p class="my-rating" data-rating="{{$w->rating}}"></p>
                                            </div>
                                        </div>
                                     </a>

                                   
                                    @endforeach 

                                
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')


    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/star-rating-svg-master/src/jquery.star-rating-svg.js')}}
  

    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    <!--END PAGE LEVEL SCRIPTS-->

    <script>
    
        $( document ).ready(function() {
            $(".my-rating").starRating({
                starSize: 25,
                readOnly: true,   
            });
        });

    </script>
@endsection