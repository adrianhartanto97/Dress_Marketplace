<div class="portlet light bordered">
    <div class="portlet-body">
        <div class="row">
            @foreach ($product_active as $w)
            
            <a href="{{url('/product_detail')}}/{{$w->product_id}}"  style="text-decoration:none;">
            <div class="col-lg-3 col-xs-6 col-sm-4 col-md-3 center">
                <div class="thumbnail" style="text-align: center;">
                    <img src="{{asset('/public/storage/').'/'.$w->photo}}" alt="" style="width: 100%; height: 170px;">
                        <div style="height: 60px;">
                                <h4 class="black">
                                @if(strlen($w->product_name) > 60 )
                                {{substr($w->product_name,0,60)."..."}}
                                @else
                                {{$w->product_name}}
                                @endif
                            </h4>
                        </div>
                        
                    <b>{{$w->store_name}}</b>
                    <h3>IDR {{$w->max_price}}</h3>
                        <p class="my-rating" data-rating="{{$w->average_rating}}"></p>
                </div>
            </div>
            </a>
            @endforeach 

        
        </div>

        <div class="row" style="text-align:center;">
            {{ $product_active->links() }}
        </div>
    </div>
</div>

<script>
    $('.pagination a').on('click', function(e) {
        e.preventDefault();
        App.blockUI({
            boxed: true
        });
        //$('#load a').css('color', '#dfecf6');
        //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

        var url = $(this).attr('href');  
        getArticles(url);
        //window.history.pushState("", "", url);
    });

    function getArticles(url) {
        $.ajax({
            url : url  
        }).done(function (data) {
            $('#product_active_container').empty();
            $('#product_active_container').html(data);
            App.unblockUI();
        }).fail(function () {
            alert('Products could not be loaded.');
        });
    }
</script>