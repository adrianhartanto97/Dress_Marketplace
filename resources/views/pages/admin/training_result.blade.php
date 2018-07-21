<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="form-actions" style="text-align:center;margin-bottom:50px;">
    <h3>Result RMSE : {{$result->rmse_terbaik}}</h3>
    <h2>Current Best RMSE : 0.2</h2>
    <button type="submit" class="btn blue" onclick="generate_recommendation({{$param_id}})">
            Generate Recommendation</button>
</div>

<script>
    function generate_recommendation(param_id)
    {
        App.blockUI({
            boxed: true
        });
        $.ajax({
            type:"POST",
            url : "http://localhost/dress_marketplace/admin/generate_recommendation_api",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                param_id : param_id
            },
            async: false,
            success : function(response) {
                //location.reload();
                console.log(response);
                App.unblockUI();
            },
            error: function() {
                alert('Error occured');
                App.unblockUI();
            }
        });
    }
</script>