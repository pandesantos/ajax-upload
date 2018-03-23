
<!DOCTYPE html>
<html>
<head>
	<title>Ajax upload</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
	
	
</style>
</head>
<body>
	<div class="container">
		<div class="col-md-9 col-md-offset-2" style="margin-top: 20px;">
			<div class="panel panel-primary">
				<div class="panel-heading text-center"><i class="fa fa-cloud"></i> Image uploader</div>
				<div class="panel-body">
					<form method="POST" enctype="multipart/form-data" id="upload_form">
						<div class="form-group">
							<input type="file" class="form-control" name="image" id="file_input">
						</div>
					</form>
					<div class="progress" style="display: none;">
						<div class="progress-bar progress-bar-success" role="progressbar"  style="width: 0%;">
							
						</div>
					</div>

					<div class="col-md-12 well" id="upload_area" style="min-height: 250px;">

					</div>

					<!-- <div class="col-md-4 pull-right">
						<form>
							<button class="btn btn-primary pull-right">Save to gallery</button>
						</form>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$('#file_input').change(function(){
		var form_data = new FormData($('#upload_form')[0]);
		$('.progress').show();
		$('.progress-bar').css('width', '0%');
		$('.progress-bar').html('0%');
		

		$.ajax({
			url: 'lib/uploadHandler.php',
			method: 'POST',
			data: form_data,
			cache: false,
			contentType: false,
			processData: false,
			enctype: 'multipart/form-data',
			xhr: function () {
				var xhr = $.ajaxSettings.xhr();
				xhr.onprogress = function e() {
					if (e.lengthComputable) {
						console.log(e.loaded / e.total);
					}

				};
				xhr.upload.onprogress = function (e) {
	               // For uploads
	               if (e.lengthComputable) {
	               	var percentage = (e.loaded / e.total) * 100;
	               	if(percentage > 100) percentage = 100;

	               	$('.progress-bar').css('width', percentage+'%');
	               	$('.progress-bar').html(percentage+'%');


	               }
	           };
	           return xhr;
	       },
	       success: function (data){
	       	var response = JSON.parse(data);
	       	if(response.error){
	       		alert(response.error);
	       	}
	       	else
	       	{
	       		setTimeout(function() {
	       			$('.progress').hide();
	       		},1500);

	       		$('#upload_area').append(response.view);
	       		$('#upload_form').trigger('reset');
	       	}
	       },
	       error: function(response){
	       	console.log(response);
	       }
	   })
	});
</script>
</html>