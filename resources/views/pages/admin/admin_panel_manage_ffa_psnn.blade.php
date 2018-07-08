@extends('pages.admin.admin_panel_layout')

@section('css')   
    <style>
    .left{
        text-align:left;
    }
    .{
        text-align:left;
    }
    </style>
@endsection



@section('content')
    <div class="tabbable-custom left">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Training </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Testing</a>
            </li>
            <li>
                <a href="#tab_3" data-toggle="tab"> Product Recommendation</a>
            </li>
            <li>
                <a href="#tab_4" data-toggle="tab"> Training Result</a>
            </li>
            <li>
                <a href="#tab_5" data-toggle="tab"> Testing Result</a>
            </li>
        </ul>
        <div id="info">
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="portlet box">
                    <div class="portlet-body">
                        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="submit_form" method="POST">
                             {{ csrf_field() }}
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
                            <div class="form-body row">
                                <div class="col-xs-12 col-md-6">
                                    <h2 > Firefly Parameters</h2>
                                    <div class="form-group">
                                        <label class="kiri control-label col-md-3">Firefly
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="n_firefly"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Maks Epoch
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="maks_epoch"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Base Beta
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="base_beta"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 kiri">Gamma
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="gamma"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Alpha
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="aplha"/>
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="col-xs-12 col-md-6">
                                    <h2> Pi Sigma Neural Network Parameters</h2>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Maks Epoch
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="maks_epoch_psnn"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Summing Units
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="summing_units"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Learning Rate
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="learning_rate"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 kiri">Momentum
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="Momentum"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-actions" style="text-align:center;">
                                <button type="submit" class="btn blue">
                                     Start Training</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
               <div class="portlet box">
                    <div class="portlet-body">
                        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="submit_form" method="POST">
                             {{ csrf_field() }}
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
                            <div class="form-body row">
                                <div class="col-xs-12 col-md-6">
                                    <h2> Firefly Parameters</h2>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Firefly
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="n_firefly"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Maks Epoch
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="maks_epoch"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Base Beta
                                            <span class="required"> * </span>
                                        </label>
                                       <div class="col-md-3">
                                            <input type="text" class="form-control" name="min" placeholder="min" />
                                        </div>
                                        <div class="control-label col-md-2" style="text-align: center;">range
                                        </div>

                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="max" placeholder="max" />
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">
                                        </label>
                                        <label class="control-label col-md-1" style="text-align: center;">step
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="step" placeholder="step" />
                                        </div>
                                    </div>
                                     
                                    <div class="form-group">
                                        <label class="control-label col-md-3 kiri">Gamma
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="min" placeholder="min" />
                                        </div>
                                        <label class="control-label col-md-2" style="text-align: center;">range
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="max" placeholder="max" />
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Alpha
                                            <span class="required"> * </span>
                                        </label>
                                       <div class="col-md-3">
                                            <input type="text" class="form-control" name="min" placeholder="min" />
                                        </div>
                                        <label class="control-label col-md-2" style="text-align: center;">range
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="max" placeholder="max" />
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">
                                        </label>
                                        <label class="control-label col-md-1" style="text-align: center;">step
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="step" placeholder="step" />
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="col-xs-12 col-md-6">
                                    <h2> Pi Sigma Neural Network Parameters</h2>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Maks Epoch
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="maks_epoch_psnn"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Summing Units
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="summing_units"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Learning Rate
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="learning_rate"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 kiri">Momentum
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="min" placeholder="min" />
                                        </div>
                                        <label class="control-label col-md-2" style="text-align: center;">range
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="max" placeholder="max" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">
                                        </label>
                                        <label class="control-label col-md-1" style="text-align: center;">step
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="step" placeholder="step" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-actions" style="text-align:center;">
                                <button type="submit" class="btn blue">
                                     Start Testing</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_3">

                <div class="portlet box">
                    <div class="portlet-body">
                        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="submit_form" method="POST">
                             {{ csrf_field() }}
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

                            
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th>Product ID</th>
                                                    <th>Product Name</th>
                                                    <th>Size</th>
                                                    <th>Recomendation</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> 1 </td>
                                                    <td> Mini Dress </td>
                                                    <td> M </td>
                                                    <td> 0.65 </td>
                                                    <td style="text-align: center;">
                                                        <button type="button" class="btn blue" data-toggle="modal" href="" >View Product Page</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> 2 </td>
                                                    <td> Casual Dress</td>
                                                    <td> L </td>
                                                    <td> 0.66</td>
                                                    <td style="text-align: center;">
                                                        <button type="button" class="btn blue" data-toggle="modal" href="" >View Product Page</button>
                                                    </td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>   
            </div>
            <div class="tab-pane" id="tab_4">
                <div class="portlet box">
                    <div class="portlet-body">
                        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="submit_form" method="POST">
                           
                            <div class="form-body row">
                                <div class="col-xs-12 col-md-6">
                                    <h2 > Firefly Parameters</h2>
                                    <div class="form-group">
                                        <label class="kiri control-label col-md-3">Firefly
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="n_firefly" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Maks Epoch
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="maks_epoch" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Base Beta
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="base_beta" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 kiri">Gamma
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="gamma" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 left">Alpha
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="aplha" readonly="true"/>
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="col-xs-12 col-md-6">
                                    <h2> Pi Sigma Neural Network Parameters</h2>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Maks Epoch
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="maks_epoch_psnn" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Summing Units
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="summing_units" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 left">Learning Rate
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="learning_rate" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 kiri">Momentum
                                        </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="Momentum" readonly="true"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                    <div class="form-actions" style="text-align:center;">
                        <h3>Result RMSE : 0.3</h3>
                        <h2>Current Best RMSE : 0.2</h2>
                        <button type="submit" class="btn blue">
                             Generate Recommendation</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_5">
                <div class="portlet box">
                    <div class="portlet-body">
                         <h2 style="text-align: center;"> Testing Result</h2><br>

                        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="submit_form" method="POST">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th>Firefly</th>
                                                    <th>Maks Epoch FFA</th>
                                                    <th>Base Beta</th>
                                                    <th>Gamma</th>
                                                    <th>Alpha</th>
                                                    <th>Maks Epoch PSNN</th>
                                                    <th>Summing Unit</th>
                                                    <th>Learning Rate</th>
                                                    <th>Momentum</th>
                                                    <th>RMSE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for($i=1,$satu=1,$dua=0.5;$i<=5;$i++,$satu+=2,$dua+=0.5)
                                                <tr>
                                                    <td> {{$i}} </td>
                                                    <td> {{$satu}} </td>
                                                    <td> {{$dua}}</td>
                                                    <td> {{2*$satu-1}}</td>
                                                    <td>  {{3*$dua-1}} </td>
                                                    <td>  {{4*$dua-1}}</td>
                                                    <td>  {{$satu+$i}} </td>
                                                    <td> {{$dua/5}} </td>
                                                    <td>  {{2*$dua+2}}</td>
                                                    <td>  {{$dua/10}}</td>
                                                </tr>
                                               
                                                @endfor
                                               
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>   
            </div>
          
        </div>
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