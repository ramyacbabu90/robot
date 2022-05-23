@extends('layout')
@section('css')
@endsection
@section('content')


<div class="row" id="form-div">
	<h4 class="mt-4">Last Location</h4>
	<div class="col-md-6">
		<div class="">
			<form role="form" class="form" id="js-update-location-form" method="post">
				
				<div class="form-group">
					<label for="exampleInputEmail1">Title</label>
					<select name="survivor_id" id="survivor_id" class="form-control" required="">
						<option>select survivor</option>
					</select>
					<!-- <input type="text" name="survivor_id" class="form-control" id="survivor_id"  placeholder="survivor name" required=""> -->
					@if($errors->has('survivor_id')) <p>{{ $errors->first('survivor_id') }}</p> @endif
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
@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function(){

	loadListingData();

	$("#js-update-location-form").on("submit", function(event){
		event.preventDefault();

		var formData = {
			'survivor_id': $('#survivor_id').val(),
			'latitude': $('input[name=latitude]').val(),
			'longitude': $('input[name=longitude]').val(),
		};

		$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         :"{{ url('/api/update-location') }}", // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json',
            success:function(res){
              //console.log(data);
              if(res.status) {
              
              		alert(res.message);
              		setTimeout(function() {
              			location.reload();
              		}, 2000);
              		
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
	

	function loadListingData(){
		$.ajax({
			url: "{{ url('/api/select-list') }}",
			dataType    : 'json',
			success: function(res) {
				
				if(res.status){

					count = res['data'].length;
					console.log(res.count);
					for (var i = 0; i < count; i++) {
						var option = '<option value="' + res['data'][i].id + '"';
						option += '>' + res['data'][i].survivor_id + '-'+res['data'][i].name+'</option>';
						$('select[name="survivor_id"]').append(option);
					}

				}
				
			}

		});
	}
  </script>


  @endsection