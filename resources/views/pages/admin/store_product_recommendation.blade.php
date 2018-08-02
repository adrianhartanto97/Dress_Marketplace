<table class="table table-striped table-bordered table-hover" id="sample_2">
    <thead>
        <tr>
            <th></th>
            <th>Recommendation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $p)
        <tr>
            <td>
                <a href="{{url('/product_detail')}}/{{$p->product_id}}" target="_blank">
                    <img src="{{asset('/public/storage/').'/'.$p->photo}}" width="80px" style="margin: 0 auto;">
                    <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                </a>
            </td>
            <td>
                {{$p->recommendation}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>