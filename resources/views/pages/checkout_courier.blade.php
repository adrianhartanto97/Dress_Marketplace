<div class="row" style="margin-top:50px;">
    <div class="col-md-12">
        @foreach($result->result as $store)
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    {{$store->store_name}}
                </div>
            </div>
            <div class="portlet-body">
                <input type="hidden" name="store_id[{{$store->store_id}}]" value="{{$store->store_id}}">
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
                            @foreach ($store->product as $p)
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

                <div class="row" style="font-weight:bold">
                    <div class="col-md-3">
                        Total : {{$store->total_qty}} item(s)
                    </div>
                    <div class="col-md-3">
                        IDR {{number_format($store->total_price)}}
                    </div>
                </div>
                <div class="row" style="margin-top:20px;">
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3">courier Service
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <input type= "hidden" name="courier_id[{{$store->store_id}}]" id="courier_id_{{$store->store_id}}">
                            <input type= "hidden" name="courier_service[{{$store->store_id}}]" id="courier_service_{{$store->store_id}}">
                            <select class="form-control courier_select" name="fee[{{$store->store_id}}]" onchange="myFunction(this, {{$store->store_id}})" data-store-id="{{$store->store_id}}">
                                @foreach($store->courier_service as $cs)
                                    @foreach($cs->cost as $cost)
                                        <option value="{{$cost->cost[0]->value}}" data-courier-id="{{$cs->courier_id}}" data-courier-service="{{$cost->service}}">{{$cs->courier_name}}  {{$cost->service}} : IDR {{number_format($cost->cost[0]->value)}} ( Estimated {{$cost->cost[0]->etd}} day(s) )</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="form-group">
                        <label class="control-label col-md-12">Note for Seller
                        </label>
                        <div class="col-md-12">
                            <textarea type="text" class="form-control" name="note[{{$store->store_id}}]"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    var subtotal_price = {{$result->total_price}};
    var balance = {{$result->available_points}};
</script>