<h2 style="text-align: center;"> Testing Result</h2><br>
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
        @foreach($result as $r)
        <tr>
            <td> {{$r->n_firefly}} </td>
            <td> {{$r->maks_epoch_ffa}} </td>
            <td> {{$r->base_beta}}</td>
            <td> {{$r->gamma}}</td>
            <td>  {{$r->alpha}} </td>
            <td>  {{$r->maks_epoch_psnn}}</td>
            <td>  {{$r->summing_units}} </td>
            <td> {{$r->learning_rate}} </td>
            <td>  {{$r->momentum}}</td>
            <td>  {{$r->rmse}}</td>
        </tr>
        @endforeach
    </tbody>
</table>