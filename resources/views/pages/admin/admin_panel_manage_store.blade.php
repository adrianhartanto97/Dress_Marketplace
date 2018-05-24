@extends('pages.admin.admin_panel_layout')

@section('content')
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Pending Store </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Store List </a>
            </li>
        </ul>
        <div id="info">
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
            @foreach($pending_store as $s)
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            {{$s->name}}
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="panel-group accordion" id="accordion_{{$s->store_id}}">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_{{$s->store_id}}" href="#collapse_{{$s->store_id}}_1"> Store Information </a>
                                    </h4>
                                </div>
                                <div id="collapse_{{$s->store_id}}_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <form action="#" class="form-horizontal">
                                            <div class="form-body">
                                                <div class="col-xs-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Store Name :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Established Year :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->established_year}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Province :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->province_name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">City :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->city_name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Business Type :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->business_type}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Description :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->description}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-md-6">
                                                    <h4 class="form-section">Contact Person</h4>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Name :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->contact_person_name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Job Title :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->contact_person_job_title}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Phone Number :</label>
                                                        <div class="col-md-8">
                                                            <p class="form-control-static">{{$s->contact_person_phone_number}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_{{$s->store_id}}" href="#collapse_{{$s->store_id}}_2"> Photo & Banner </a>
                                    </h4>
                                </div>
                                <div id="collapse_{{$s->store_id}}_2" class="panel-collapse collapse">
                                    <div class="panel-body" style="height:100px; overflow-y:auto;">
                                        
                                            <div>
                                            @if ($s->photo != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->photo}}" target="_blank"> View Photo </a>
                                            @else
                                            No Photo
                                            @endif
                                            </div>

                                            <div style="margin-top:10px;">
                                            @if ($s->banner != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->banner}}" target="_blank"> View Banner </a>
                                            @else
                                            No Banner
                                            @endif
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_{{$s->store_id}}" href="#collapse_{{$s->store_id}}_3"> Supporting Documents </a>
                                    </h4>
                                </div>
                                <div id="collapse_{{$s->store_id}}_3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <div>
                                            @if ($s->ktp != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->ktp}}" target="_blank"> View KTP </a>
                                            @else
                                            No KTP
                                            @endif
                                            </div>

                                            <div style="margin-top:10px;">
                                            @if ($s->siup != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->siup}}" target="_blank"> View SIUP </a>
                                            @else
                                            No SIUP
                                            @endif
                                            </div>

                                            <div style="margin-top:10px;">
                                            @if ($s->npwp != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->npwp}}" target="_blank"> View NPWP </a>
                                            @else
                                            No NPWP
                                            @endif
                                            </div>

                                            <div style="margin-top:10px;">
                                            @if ($s->skdp != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->skdp}}" target="_blank"> View SKDP </a>
                                            @else
                                            No SKDP
                                            @endif
                                            </div>

                                            <div style="margin-top:10px;">
                                            @if ($s->tdp != null) 
                                            <a class="btn blue" href="{{url('public/storage').'/'.$s->tdp}}" target="_blank"> View TDP </a>
                                            @else
                                            No TDP
                                            @endif
                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-4 col-md-offset-4" style="text-align:center;">
                            <a class="btn green" style="margin:0 auto;" onclick="accept({{$s->store_id}})"> Accept </a>
                            <a class="btn red" data-toggle="modal" href="#modal_{{$s->store_id}}" style="margin:0px 30px;"> Reject </a>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-sm" id="modal_{{$s->store_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Reject - {{$s->name}}</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Note
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <textarea type="text" class="form-control" id="reject_note_{{$s->store_id}}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                <button type="button" class="btn green" onclick="reject({{$s->store_id}})">Reject</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endforeach
            </div>
            <div class="tab-pane" id="tab_2">
                tes
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function accept(store_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/accept_store",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    store_id : store_id
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

        function reject(store_id) {
            var reject_note = $('textarea#reject_note_'+store_id).val();
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/reject_store",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    store_id : store_id,
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