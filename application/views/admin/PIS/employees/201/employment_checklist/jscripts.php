<?php
	/*
	* @Author: gian
	* @Date:   2016-04-26 09:28:27
	* @Last Modified by:   gian
	* @Last Modified time: 2016-04-26 09:28:54
	*/
?>
<script type="text/javascript">
'use strict';

	$(function(){
		var checklistData = {
						beforeSubmit: function(formData){
							$('#btn-checklist').attr('disabled','disabled');
							$('#btn-checklist').html('Submitting');
						},
						success: function(e){
							if(e.success == false){
								$.gritter.add({
							      title: "Warning..",
							      text: "Please select employee.",
							      class_name: "bg-red",
							      sticky: false,
							      time:6000
							    });
							}else{
								$.gritter.add({
							      title: "Submit success..",
							      text: "",
							      class_name: "bg-green",
							      sticky: false,
							      time:6000
							    });
							    globe_empID = $('[name="empID"]').attr('emp');
							    $('#'+globe_empID).trigger('click');
							}
							$('#btn-checklist').removeAttr('disabled');
							$('#btn-checklist').html('Submit');
						},
					  	// dataType:"JSON",
					  }
		$('#checklistForm').ajaxForm(checklistData);


		$(document).on('click','.req_checkbox',function(){
			var name = $(this).attr('req-id');
			if($(this).prop("checked")){
				$('#'+name).removeClass('hidden');
			}else{
				$('#'+name).addClass('hidden');
			}
		});
		

		$(document).on('click','.thumbnail',function(e){
		  	$('.modal-body').empty();
		  	var title = $(this).attr("title");
		  	$('.modal-title').html(title);
		  	$($(this).html()).appendTo('.modal-body');
		  	$('#myModal').modal({show:true});
		  	e.preventDefault();
		});

		$(document).on('click','#deleteImg',function(e){
			var imgSrc = $('.modal-body img').attr('fldImg');

			$.post('<?= base_url("index.php/admin/employees/delete_file"); ?>','imageSrc='+imgSrc,function(data){
				if(data.success == true){
					$.gritter.add({
				      title: "Image deleted.",
				      text: "",
				      class_name: "bg-green",
				      sticky: false,
				      time:6000
				    });
				    globe_empID = $('[name="empID"]').attr('emp');
					$('#'+globe_empID).trigger('click');
				}else{	
					$.gritter.add({
				      title: "Delete image failed.",
				      text: "",
				      class_name: "bg-red",
				      sticky: false,
				      time:6000
				    });
				}
			},'json');
			e.preventDefault();
		})
	});
</script>