@extends('pages.seller_panel_layout')

@section('content')
    @php
        $stat = $store_info->store_active_status;
    @endphp
    <h2>
        Store Status :
        @if ($stat == "0")
            Waiting Admin Approval
        @elseif($stat == "1")
            Active 
        @elseif($stat == "2")
            Rejected
        @endif
    </h2>
    @if($stat == "2")
        <p>
            Reject Comment : {{$store_info->reject_comment}}
        </p>
    @endif
@endsection