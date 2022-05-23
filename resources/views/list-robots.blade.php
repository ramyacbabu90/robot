@extends('layout')
@section('css')
@endsection
@section('content')


<div class="row" >
	<h4>List robots</h4>
	<div class="row" id="form-div">
		<div class="col-md-6">
			<div class="">
				<div class="form-group">
					<label for="exampleInputEmail1">Robot Category</label>
					<select name="category" id="category" class="form-control">
						<option value="">All</option>
						<option value="Land">Land</option>
						<option value="Flying">Flying</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="" id="robot-table-div" style="margin-top: 20px;">
	
</div>
@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		loadListData();

		$("#category").on("change", function(event){
			loadListData();
		});


	});//end ready
	
	function loadListData() {

		var category = $('#category').val();
		console.log(category);
		$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         :"{{ url('/api/list-robot') }}", // the url where we want to POST
            data        : {category : category}, // our data object
            dataType    : 'json',
            success:function(res){
              //console.log(data);
              if(res.status) {
              	$('#result-div').show();
              	$("#robot-table-div").html('');
              	if(res.data){
              		var html = res.returnHTML;
              		$("#robot-table-div").append(html);
              	}
              	
              } else{

              	alert(res.message);
              }
             // window.location = "{{ url('home')}}";
         },
         error: function (data) {
              //console.log(data);
              alert('something went wrong... please try again');
          }
      });
	}
</script>
@endsection