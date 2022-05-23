@extends('layout')
@section('css')
@endsection
@section('content')


<div class="row" id="form-div">
	<h4 class="mt-4">Add New survivor</h4>
	<div class="col-md-6">
		<div class="">
			<form role="form" class="form" id="js-add-form" method="post">
				
				<div class="form-group">
					<label for="exampleInputEmail1">Survivor Id</label>
					<input type="text" name="survivor_id" class="form-control" id="survivor_id"  placeholder="survivor name" required="">
					@if($errors->has('survivor_id')) <p>{{ $errors->first('survivor_id') }}</p> @endif
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Title</label>
					<input type="text" name="name" class="form-control" id="name"  placeholder="survivor name" required="">
					@if($errors->has('name')) <p>{{ $errors->first('name') }}</p> @endif
				</div>
				
				<div class="form-group">
					<label for="exampleInputEmail1">Age</label>
					<input type="number" name="age" class="form-control" id="age"  placeholder="survivor age" required="">
					@if($errors->has('age')) <p>{{ $errors->first('age') }}</p> @endif
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Gender</label>
					<select name="gender" class="form-control" id="gender">
						<option value="1">Male</option>
						<option value="3">Female</option>
					</select> 
					@if($errors->has('gender')) <p>{{ $errors->first('gender') }}</p> @endif
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Latitude</label>
					<input type="text" name="latitude" class="form-control" id="latitude"  placeholder="latitude " required="">
					@if($errors->has('latitude')) <p>{{ $errors->first('latitude') }}</p> @endif
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">longitude</label>
					<input type="text" name="longitude" class="form-control" id="longitude"  placeholder="longitude" required="">
					@if($errors->has('longitude')) <p>{{ $errors->first('longitude') }}</p> @endif
				</div>
				
				<input type="submit" class="btn btn-primary" style="margin-top: 30px;" value="Submit">
				
			</form>
		</div>
	</div>
</div>
<div class="row" id="result-div" style="display: none;">
	<h4>Inventory allocated</h4>
	<table class="table table-responsive" id="inventory_table">
		<thead>
			<th>Water</th>
			<th>Food</th>
			<th>Medicine</th>
			<th>Ammunition</th>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function(){
console.log('inside ready');
	$("#js-add-form").on("submit", function(event){
		event.preventDefault();

		var formData = {
			'survivor_id': $('input[name=survivor_id]').val(),
			'name': $('input[name=name]').val(),
			'age': $('input[name=age]').val(),
			'gender': $('#gender').val(),
			'latitude': $('input[name=latitude]').val(),
			'longitude': $('input[name=longitude]').val(),
		};

		$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         :"{{ url('/api/add-survivor') }}", // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json',
            success:function(res){
              //console.log(data);
              if(res.status) {
              	$('#result-div').show();
              	$("#form-div").hide();
              	if(res.data){
              		var inventory =res.data; 
              		var html = '<tr><td>'+inventory['water']+' L</td><td>'+inventory['food_items']+'</td><td>'+inventory['medicine']+'</td><td>'+inventory['ammunition']+'</td></tr>';
              		$("#inventory_table").append(html);
              		alert(res.message);
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
        });//end ajax

      });//end form1


	});//end ready
	
  </script>
  @endsection