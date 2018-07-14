<div id="load" style="position: relative;">
    @foreach($rfq as $r)
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-6">
                        {{$r->rfq_request_id}}
                    </div>
                    <div class="col-md-6" style="text-align:right">
                        {{$r->full_name}}
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="panel-group accordion" id="accordion_rfq_{{$r->rfq_request_id}}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_{{$r->rfq_request_id}}" href="#collapse_rfq_{{$r->rfq_request_id}}_1"> {{$r->item_name}} </a>
                            </h4>
                        </div>
                        <div id="collapse_rfq_{{$r->rfq_request_id}}_1" class="panel-collapse in">
                            <div class="panel-body">
                                <div class="form-horizontal">
                                    <div style="margin-top:-10px">
                                    </div>
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Description :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$r->description}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Qty :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$r->qty}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Date Expired :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">{{$r->request_expired}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Budget per Unit :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">IDR {{number_format($r->budget_unit_min)}} - IDR {{number_format($r->budget_unit_max)}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Photo :</label>
                                            <div class="col-md-3">
                                                <a href="{{asset('/public/storage/').'/'.$r->photo->file_path}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                                    <img class="img-responsive" src="{{asset('/public/storage/').'/'.$r->photo->file_path}}" width="90%" style="margin: 0 auto;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@add_rfq_offer') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="rfq_request_id" value="{{$r->rfq_request_id}}">
                    <h4 class="form-section">Add My Offer</h4>
                    <div class="form-group">
                        <label class="control-label col-md-3">Description :</label>
                        <div class="col-md-7">
                            <textarea type="text" class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Price per Unit :</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="price_unit"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Upload Image <span class="required"> * </span></label>
                        <div class="col-md-7">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                <div>
                                    <span class="btn red btn-outline btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="photo"> </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row" style="text-align:center;margin-top:20px;">
                            <button type="submit" class="btn green">Add Offer</button> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

<div class="row" style="text-align:center;">
    {{ $rfq->links() }}
</div>

<script>
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        App.blockUI({
            boxed: true
        });
        

        var url = $(this).attr('href');  
        getArticles(url);
        //window.history.pushState("", "", url);
    });

    function getArticles(url) {
        $.ajax({
            url : url  
        }).done(function (data) {
            $('#rfq_request_container').html(data);
            App.unblockUI();
        }).fail(function () {
            alert('Contents could not be loaded.');
        });
    }
</script>