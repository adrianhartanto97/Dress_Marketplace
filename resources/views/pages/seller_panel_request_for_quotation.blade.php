@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/icheck/skins/all.css') }}
@endsection

@section('content')
        @if (session()->has('status') && session()->get('status') == false)
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span>{{ session('message')}}</span>
            </div>
        @elseif(session()->has('status') && session()->get('status') == true)
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button>
                <span>{{ session('message')}}</span>
            </div>
        @endif
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Request List </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> My Offer History </a>
            </li>
        </ul>
        <div class="tab-content">
           <div class="tab-pane active" id="tab_1">
           
            </div>
            <div class="tab-pane" id="tab_2">
           
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/icheck/icheck.min.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    <!--END PAGE LEVEL SCRIPTS-->

    <script>
        $(document).ready(function(){
            $('input.accept').iCheck({
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            $('input.reject').iCheck({
                radioClass: 'iradio_square-red',
                increaseArea: '20%' // optional
            });
        });

       
    </script>
@endsection