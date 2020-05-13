<script>
	$(document).ready(function(){
		$('#form').on('submit', function(a){
  		 	a.preventDefault();

  		 	$.ajax({
			    url: '<?php echo base_url("index.php/employee/leave/leave_request"); ?>',
			    type: "post",
			    data: new FormData(this),
			    dataType:"JSON",
			    contentType: false,
			    processData: false,
			    success: function(data)
			    {
			    	if(data.leave_request == true){
			    		var callback = "<h4 style='color:#337ab7;'><b>Request sent successfuly.</b></h4>";
			    		$('.rqst-callback').html(callback);	
			    		$("#form").trigger('reset');
			    	}
			    }
			});

  		 });
	});
</script>