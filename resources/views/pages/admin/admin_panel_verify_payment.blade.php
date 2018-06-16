@extends('pages.admin.admin_panel_layout')

@section('content')
    @foreach($payment as $p)
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="row" style="margin-top:10px;">
                <div class="col-md-6">
                    Invoice Number {{$p->transaction_id}}
                </div>
                <div class="col-md-6" style="text-align:right">
                    {{$p->invoice_date}}
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <form action="#" class="form-horizontal">
                <div style="margin-top:-20px">
                    <h3>Invoice Grand Total :  IDR {{number_format($p->invoice_grand_total)}}</h3>
                    <h4>{{$p->full_name}}</h4>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Transfer to :</label>
                        <div class="col-md-7">
                            <p class="form-control-static">{{$p->bank_name}} {{$p->account_number}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Amount :</label>
                        <div class="col-md-7">
                            <p class="form-control-static">IDR {{number_format($p->amount)}}</p>
                            <script>
                                var invoice_amount_{{$p->transaction_id}} = {{$p->invoice_grand_total}}
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Sender Bank Name :</label>
                        <div class="col-md-7">
                            <p class="form-control-static">{{$p->sender_bank}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Sender Bank Account Number :</label>
                        <div class="col-md-7">
                            <p class="form-control-static">{{$p->sender_account_number}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Sender Name in Bank Account :</label>
                        <div class="col-md-7">
                            <p class="form-control-static">{{$p->sender_name}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Note :</label>
                        <div class="col-md-7">
                            <p class="form-control-static">{{$p->note}}</p>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Receive Amount :</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{$p->amount}}" name="receive_amount[{{$p->transaction_id}}]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="button" class="btn blue" id="accept_btn_{{$p->transaction_id}}" onclick="accept({{$p->transaction_id}})">Accept</button>
                            <button type="button" class="btn red" data-toggle="modal" href="#modal_{{$p->transaction_id}}">Reject</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade bs-modal-sm" id="modal_{{$p->transaction_id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Reject - Invoice {{$p->transaction_id}}</h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Note
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <textarea type="text" class="form-control" id="reject_note_{{$p->transaction_id}}"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn green" onclick="reject({{$p->transaction_id}})">Reject</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endforeach
@endsection

@section('script')
    <script>
        @foreach($payment as $p)
        $("input[name='receive_amount[{{$p->transaction_id}}]']").keyup(function() {
            var rec = $(this).val() || 0;

            if (rec < invoice_amount_{{$p->transaction_id}}) {
                $('#accept_btn_{{$p->transaction_id}}').prop('disabled', true);
            }
            else {
                $('#accept_btn_{{$p->transaction_id}}').prop('disabled', false);
            }
        });
        @endforeach 

        function accept(transaction_id)
        {
            var str = "receive_amount[" + transaction_id + "]";
            var str2 = "input[name='" + str +"']";
            var receive_amount = $(str2).val();
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/accept_payment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    transaction_id : transaction_id,
                    receive_amount : receive_amount

                },
                async: false,
                success : function(response) {
                    location.reload();
                    //console.log(response);
                },
                error: function() {
                    alert('Error occured');
                }
            });
        } 

        function reject(transaction_id)
        {
            var reject_note = $('textarea#reject_note_'+transaction_id).val();
            var str = "receive_amount[" + transaction_id + "]";
            var str2 = "input[name='" + str +"']";
            var receive_amount = $(str2).val();
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/reject_payment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    transaction_id : transaction_id,
                    receive_amount : receive_amount,
                    reject_comment : reject_note
                },
                async: false,
                success : function(response) {
                    location.reload();
                    //console.log(response);
                },
                error: function() {
                    alert('Error occured');
                }
            });
        } 
    </script>
@endsection