

@foreach ($product_info as $w)

<a href="{{url('/product_detail')}}/{{$w->product_id}}"  style="text-decoration:none;">
    <div class="col-lg-3 col-xs-6 col-sm-4 col-md-3 center">
        <div class="thumbnail">
            <img src="{{asset('/public/storage/').'/'.$w->photo}}" alt="" style="width: 100%; height: 170px;">
                <div style="height: 90px;">
                    <h4 class="black">
                        @if(strlen($w->product_name) > 60 )
                        {{substr($w->product_name,0,60)."..."}}
                        @else
                        {{$w->product_name}}
                        @endif
                    </h4>
                </div>
            
            <b>{{$w->store_name}}</b>
            <h3>
                IDR {{number_format($w->max_price)}}
            </h3>
            <div class="my-rating" data-rating="{{$w->average_rating}}"></div>
            <div style="text-align:center">{{$w->recommendation}}</div>
        </div>
    </div>
</a>
@endforeach

<script>
    $( document ).ready(function() {
        $(".my-rating").starRating({
            starSize: 25,
            readOnly: true,   
        });
    });
</script>
