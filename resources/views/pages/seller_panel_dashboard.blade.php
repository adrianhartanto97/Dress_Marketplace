@extends('pages.seller_panel_layout')

@section('content')
    @php
        $stat = $store_info->store_active_status;
    @endphp
    <h2>
        Store Status :
        @if ($stat == "0")
            Waiting Admin Approval
        @elseif($stat == "1")
            Active 
        @elseif($stat == "2")
            Rejected
        @endif
    </h2>
    @if($stat == "2")
        <p>
            Reject Comment : {{$store_info->reject_comment}}
        </p>
    @endif

    @if($stat == "1")
         <!-- <h1>Balance : IDR {{ number_format($login_info->user_info->balance,0,",",".") }} </h1>
          <div class="form-group">
                <div class="col-md-12" style="padding-top: 50px">
                    <h2>Transaction History</h2>
                </div>
            </div>
            <div class="form-group">
                 <form method="POST" action="{{ action('Web_Controller\SellerController@seller_panel_dashboard')}}"  id="History">
                    {{ csrf_field() }}
                    <div class="col-md-2">
                        <select name="date" class="form-control" value="" onclick="getWaktu()" id="date">
                            <option value="2018-08">Agustus 2018</option>
                            <option value="2018-07">July 2018</option>
                            <option value="2018-06">June 2018</option>
                            <option value="2018-05">May 2018</option>
                        </select>  
                        <input type="text" name="year"  value="" hidden=""> 
                        <input type="text" name="month" value="" hidden="">        

                    </div>
                    </form>
                     <div class="form-actions">
                        <div class="col-md-10">
                            <button  type="submit" class="btn blue" form="History" onclick="reload()">Show History</button>
                           <br><br>
                        </div>
                    </div>
            </div>
             <div class="form-group">
                <div class="col-md-12">
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <th class="center">Date</th>
                                    <th class="center">Transaction</th>
                                    <th class="center">Debit</th>
                                    <th class="center">Credit</th>
                                    <th class="center">Balance</th>
                                    <th class="center">Note</th>
                                </tr>
                            </thead>
                            <tbody class="center">
                                @foreach ($financial_history as $h)
                                <tr>
                                    <td> {{$h->date}}</td>
                                    <td> {{$h->transaction}} </td>
                                    <td> IDR {{number_format($h->debit)}}</td>
                                    <td> IDR {{number_format($h->credit)}} </td>
                                    <td> IDR {{number_format($h->balance)}}</td>
                                    <td> {{$h->note}}</td>

                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                
            </div> -->

            <div class="row" style="margin-top:50px;">
                <div class="col-md-6">
                    <div style="font-size:24px;">Total Sales : </div>
                    <h4 id="desc"></h4>
                    <h1><b>IDR <span id="total"></span></b></h1>
                </div>
                <div class="col-md-3">
                    <input type="hidden" name="token" value="{{$jwt}}">
                    <select class="form-control" name="type" onchange="refresh()">
                        <option value="1">Today</option>
                        <option value="2">Year-to-date</option>
                        <option value="3">Month-to-date</option>
                    </select>
                </div>
            </div>        

    @endif
@endsection

@section('script')

        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });

                @if ($stat == "1")
                refresh();
                @endif
            })
            function getWaktu()
            {
                 var objfrm = document.getElementById("History");
                 var idx_opsi = objfrm.date.selectedIndex;
                 var date= objfrm.date.options[idx_opsi].value;

                var year="";
                var month="";
                for(var i=0 ; i<=3;i++){
                    year+=date[i];
                }
                for(var i=5 ; i<=6;i++){
                    month+=date[i];
                }
                objfrm.year.value= year;
                objfrm.month.value= month;
            }

            function refresh() {
                App.blockUI({
                    boxed: true
                });
                $.ajax({
                    type:"POST",
                    url: "http://localhost/dress_marketplace/api/dashboard",
                    data : {
                        token : $('input[name="token"]').val(),
                        type : $('select[name="type"]').val()
                    },
                    success: function(res) {
                        $('#desc').html(res.result.description);
                        $('#total').html(res.result.total);
                        App.unblockUI();
                    }
                });
            }
        </script>

@endsection