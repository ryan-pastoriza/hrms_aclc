

<script type="text/javascript">

  	$(document).ready(function() {

  		 $('#form').on('submit', function(a){
  		 	a.preventDefault();

  		 	$.ajax({
			    url: '<?php echo base_url("index.php/employee/update_request/add_request"); ?>',
			    type: "post",
			    data: new FormData(this),
			    dataType:"JSON",
			    contentType: false,
			    processData: false,
			    success: function(data)
			    {
			    	// if(data.result === true){
			    	// 	var callback = "<h5 style='color:#337ab7;'><b>Request sent successfuly.</b></h5>";
			    	// 	$('.rqst-callback').html(callback);	
			    	// }
			    	console.log(data.file);
			    }
			});

  		 });


  	});
	
</script>