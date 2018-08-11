<div id="load" style="position: relative;">
    @foreach($transaction as $t)
        <div class="portlet box blue">
            <div class="portlet-title">
                <!-- <div class="caption"> -->
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-6">
                            Invoice Number {{$t->transaction_id}}
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            {{$t->invoice_date}}
                        </div>
                    </div>
                <!-- </div> -->
            </div>
            <div class="portlet-body">
            @foreach($t->transaction as $o)
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-6">
                                {{$o->order_number}}
                            </div>
                            <div class="col-md-6" style="text-align:right">
                                {{$o->store_name}}
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form action="#" class="form-horizontal">
                            <div style="margin-top:-20px">
                            </div>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Invoice Date :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->invoice_date}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Receiver Name :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->receiver_name}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Shipping Address :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->address}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Province :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->province_name}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">City :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->city_name}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Phone Number :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->phone_number}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Postal Code :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->postal_code}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:-25px;">
                                            <label class="control-label col-md-4">Courier :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->courier_name}} {{$o->courier_service}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Note :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$o->note}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-group accordion" id="accordion_h_{{$o->order_number}}">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_h_{{$o->order_number}}" href="#collapse_h_{{$o->order_number}}_1"> Products </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_h_{{$o->order_number}}_1" class="panel-collapse in">
                                            <div class="panel-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-striped table-bordered table-advance table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:center;">
                                                                    Item </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Unit Price </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Qty </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Subtotal </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($o->product_ordered as $p)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="80px" style="margin: 0 auto;">
                                                                    <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    IDR {{number_format($p->price_unit)}}
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    <b>Total : {{$p->total_qty}}</b> <br>
                                                                    @foreach($p->size_info as $sz)
                                                                        {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                                    @endforeach
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    IDR {{number_format($p->price_total)}}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $('#collapse_h_{{$o->order_number}}_1').collapse('hide');
                                </script>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Subtotal :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($o->subtotal_price)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Shipping Fee :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($o->shipping_price)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Total :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($o->total_price)}}</p>
                                    </div>
                                </div>

                                
                            </div>
                        </form>

                        
                        <div class="row" style="text-align:center">
                            <div class="col-md-8 col-md-offset-2">
                                
                                <div class="panel-group accordion" id="accordion_h_app_{{$o->order_number}}">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_h_app_{{$o->order_number}}" href="#collapse_h_app_{{$o->order_number}}_1"> Product Approved </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_h_app_{{$o->order_number}}_1" class="panel-collapse in">
                                            <div class="panel-body">
                                                <h4>Accepted</h4>
                                                @if (sizeof($o->product_accepted) != 0)
                                                <div class="table-scrollable">
                                                    <table class="table table-striped table-bordered table-advance table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:center;">
                                                                    Item </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Unit Price </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Qty </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Subtotal </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($o->product_accepted as $p)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="80px" style="margin: 0 auto;">
                                                                    <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    IDR {{number_format($p->price_unit)}}
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    <b>Total : {{$p->total_qty}}</b> <br>
                                                                    @foreach($p->size_info as $sz)
                                                                        {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                                    @endforeach
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    IDR {{number_format($p->price_total)}}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <h5>No Product Accepted</h5>
                                                @endif

                                                <h4 style="margin-top:20px;">Rejected</h4>
                                                @if (sizeof($o->product_rejected) != 0)
                                                <div class="table-scrollable">
                                                    <table class="table table-striped table-bordered table-advance table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:center;">
                                                                    Item </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Unit Price </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Qty </th>
                                                                <th class="hidden-xs" style="text-align:center;">
                                                                    Subtotal </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($o->product_rejected as $p)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="80px" style="margin: 0 auto;">
                                                                    <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    IDR {{number_format($p->price_unit)}}
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    <b>Total : {{$p->total_qty}}</b> <br>
                                                                    @foreach($p->size_info as $sz)
                                                                        {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                                    @endforeach
                                                                </td>
                                                                <td style="text-align:center;vertical-align:middle;">
                                                                    IDR {{number_format($p->price_total)}}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <h5>No Product Rejected</h5>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $('#collapse_h_app_{{$o->order_number}}_1').collapse('hide');
                                </script>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<div class="row" style="text-align:center;">
    {{ $transaction->links() }}
</div>

<script>
    $('body').on('click', '.pagination a', function(e) {
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
            $('#transaction_history_container').html(data);
            App.unblockUI();
        }).fail(function () {
            alert('Articles could not be loaded.');
        });
    }
</script>