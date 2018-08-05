@extends('pages.admin.admin_panel_layout')

@section('content')
    <!-- <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Pending Product</a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Product List </a>
            </li>
        </ul>
        <div id="info">
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
            @foreach($pending_product as $s)
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            {{$s->store_name}}
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div>
                        <form action="#" class="form-horizontal">
                            <div class="form-body row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Product Name :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->product_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Min Order :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->min_order}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Weight (gr) :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->weight}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Description :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->description}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Price : </label>
                                        <div class="col-md-7">
                                            <div class="table-scrollable">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <i class="fa fa-cart-plus"></i> Qty </th>
                                                            <th class="hidden-xs">
                                                                <i class="fa fa-money"></i> Price </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($s->price as $pp)
                                                        <tr>
                                                            <td class="highlight">
                                                                @if ($pp->qty_max != "max")
                                                                    {{$pp->qty_min}} - {{$pp->qty_max}}
                                                                @else
                                                                    >= {{$pp->qty_min}}
                                                                @endif
                                                            </td>
                                                            <td class="hidden-xs"> IDR {{$pp->price}} </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Photo :</label>
                                        <div class="col-md-12" style="text-align:center; margin-top:10px;">
                                            <a href="{{url('public/storage').'/'.$s->photo}}" target="_blank">
                                                <img alt="" src="{{asset('/public/storage').'/'.$s->photo}}" width="70%"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <h4 class="form-section">Dress Attributes</h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Style :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->style_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Size :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                @for ($i = 0; $i < count($s->size) ; $i++)
                                                    {{$s->size[$i]->size_name}}
                                                    @if ($i != count($s->size)-1)
                                                    , 
                                                    @endif
                                                @endfor
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Season :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->season_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Neckline :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->neckline_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Sleeve Length :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->sleevelength_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Waiseline :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->waiseline_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Material :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->material_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Fabric Type :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->fabrictype_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Decoration :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->decoration_name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Pattern Type :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">{{$s->patterntype_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>

                        <div class="row">
                        <div class="col-md-4 col-md-offset-4" style="text-align:center;">
                            <a class="btn green" style="margin:0 auto;" onclick="accept({{$s->product_id}})"> Accept </a>
                            <a class="btn red" data-toggle="modal" href="#modal_{{$s->product_id}}" style="margin:0px 30px;"> Reject </a>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade bs-modal-sm" id="modal_{{$s->product_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Reject Product - {{$s->product_id}}</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Note
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <textarea type="text" class="form-control" id="reject_note_{{$s->product_id}}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                <button type="button" class="btn green" onclick="reject({{$s->product_id}})">Reject</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            @endforeach
            </div>
            <div class="tab-pane" id="tab_2">


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
                        </div>
                    </div>
            </div>
        </div>
    </div> -->

    <div style="text-align:center;">
    <h2>Product List</h2>
    </div>
    <div class="row" style="margin-top:50px;">
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
@endsection

@section('script')
    <script>
        function accept(product_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/accept_product",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    product_id : product_id
                },
                async: false,
                success : function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }

        function reject(product_id) {
            var reject_note = $('textarea#reject_note_'+product_id).val();
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/reject_product",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    product_id : product_id,
                    reject_comment : reject_note
                },
                async: false,
                success : function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }
    </script>
@endsection