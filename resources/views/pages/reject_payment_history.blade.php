<div id="load" style="position: relative;">
    @foreach ($transaction as $p)
        <div class="portlet box blue">
            <div class="portlet-title">
                <!-- <div class="caption"> -->
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-6">
                            Invoice Number {{$p->transaction_id}}
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            {{$p->invoice_date}}
                        </div>
                    </div>
                <!-- </div> -->
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Invoice Grand Total : IDR {{number_format($p->invoice_grand_total)}}</h4>
                        <p style="font-size:16px;">
                            Transfer Amount :  IDR {{number_format($p->amount)}} <br>
                            Receive Amount :  IDR {{number_format($p->receive_amount)}} <br>
                            Comment : {{$p->reject_comment}} <br>
                        </p>
                    </div>
                    <div class="col-md-6">
                        
                            <h4>Payment Confirmation</h4>
                        <p>
                            Date : {{$p->date}} <br>
                            Transfer to :  {{$p->company_bank_name}} {{$p->company_bank_account_number}}<br>
                            Your Bank :  {{$p->sender_bank}}<br>
                            Your Bank Account Number :  {{$p->sender_account_number}}<br>
                            Your Name in Account :  {{$p->sender_name}}<br>
                            Note :  {{$p->note}}<br>
                        </p>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="row">Status : {{$p->payment_status}}</div>
                        <div class="row" style="margin-top:5px;">
                            <button class="btn blue" data-toggle="modal" href="#modal_{{$p->transaction_id}}">View Payment Confirmation</button>
                        </div>
                    </div> -->
                </div>

                @foreach($p->order_store as $store)
                <div class="portlet box green-meadow" style="margin-top:20px;">

                    <div class="portlet-title">

                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                    {{$store->order_number}}
                                </div>
                                <div class="col-md-6" style="text-align:right">
                                    {{$store->store_name}}
                                </div>
                            </div>
                    </div>
                    <div class="portlet-body">
                        <p>
                            Shipping Address : {{$store->address}} <br>
                            Note : {{$store->note}}
                        </p>
                        <div class="panel-group accordion" id="accordion_{{$store->store_id}}">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_{{$store->store_id}}" href="#collapse_{{$store->store_id}}_1"> Products </a>
                                    </h4>
                                </div>
                                <div id="collapse_{{$store->store_id}}_1" class="panel-collapse in">
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
                                                    @foreach ($store->product as $pr)
                                                    <tr>
                                                    <td>
                                                            <img src="{{asset('/public/storage/').'/'.$pr->product_photo}}" width="80px" style="margin: 0 auto;">
                                                            <span style="margin-left:20px;"></span>
                                                            <b><a href="product_detail/{{$pr->product_id}}">{{$pr->product_name}}</a></b>
                                                    </td>
                                                    <td style="text-align:center;vertical-align:middle;">
                                                            IDR {{number_format($pr->price_unit)}}
                                                    </td>
                                                    <td style="text-align:center;vertical-align:middle;">
                                                            <b>Total : {{$pr->total_qty}}</b> <br>
                                                            @foreach($pr->size_info as $sz)
                                                                {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                            @endforeach
                                                    </td>
                                                    <td style="text-align:center;vertical-align:middle;">
                                                            IDR {{number_format($pr->price_total)}}
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
                            $('#collapse_{{$store->store_id}}_1').collapse('hide');
                        </script>
                        <p style="font-size:16px; line-height:24px;">
                            Sub Total : IDR {{number_format($store->subtotal_price)}}<br>
                            Shipping Fee : IDR {{number_format($store->shipping_price)}}<br>
                            Total : IDR {{number_format($store->total_price)}}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
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
            $('#reject_payment_history_container').html(data);
            App.unblockUI();
        }).fail(function () {
            alert('Articles could not be loaded.');
        });
    }
</script>