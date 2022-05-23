@extends('layout')
@section('css')
@endsection
@section('content')


<div class="row" >
	<h4>List Survivors</h4>
	<div class="row" id="form-div" style="margin-top: 20px;">
		<div class="col-md-6">
			<div class="">
				<div class="form-group">
					<label for="exampleInputEmail1">Percentage of infected survivors.</label>
					<label id="infected_rate" style="font-weight: bolder;"></label>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Percentage of non-infected survivors.</label>
					<label id="non_infected_rate" style="font-weight: bolder;"></label>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="form-div" style="margin-top: 50px;">
		<div class="col-md-6">
			<div class="">
				<div class="form-group">
					<label for="exampleInputEmail1">Infected</label>
					<select name="is_infected" id="is_infected" class="form-control">
						<option value="">All</option>
						<option value="1">Infected</option>
						<option value="0">Not-infected</option>
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

		$("#is_infected").on("change", function(event){
			loadListData();
		});


	});//end ready
	
	function loadListData() {

		var is_infected = $('#is_infected').val();

		$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         :"{{ url('/api/list-survivors') }}", // the url where we want to POST
            data        : {is_infected : is_infected}, // our data object
            dataType    : 'json',
            success:function(res){
              //console.log(data);
              if(res.status) {
              	$('#result-div').show();
              	$("#robot-table-div").html('');
              	if(res.data){

              		$('#infected_rate').text(res.infected_rate+'%');
              		$('#non_infected_rate').text(res.non_infected_rate+'%');
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