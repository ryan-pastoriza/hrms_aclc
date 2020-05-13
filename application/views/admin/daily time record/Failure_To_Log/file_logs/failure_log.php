<script>
  var empSelected;
  	var opts;
	$(function(){
		$.fn.combodate.defaults.maxYear = <?= date('Y') ?>;
		$.fn.combodate.defaults.minYear = "2015";
		opts = {
			url:"<?= base_url() ?>index.php/admin/failure_to_log/update_fail_log",
			ajaxOptions:{
				dataType:'json'
			},
			success: function(r){
				// console.log(r);
				if(r.success == true){
					$.gritter.add({
								   	title: "Successfuly update.",
								    text: "",
								    class_name: "bg-green",
								    sticky: false,
								    time:6000
								   });
				}
			},
			send: "always",
		};
	});
</script>

<?php
$val = "";
$formOpen = "";

if($this->userInfo->user_privilege == "admin"){
	$val = "Add";
	$formOpen = form_open('admin/failure_to_log/add_failure_logs', 'class="form-horizontal" id="failureForm"');
}else if($this->userInfo->user_privilege == "employee"){
	$val = "Request";
	$formOpen = form_open('employee/failure_to_log/add_failure_logs', 'class="form-horizontal" id="failureForm"');
}

/**
 * @Author: gian
 * @Date:   2016-04-06 08:35:28
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-11 15:16:57
 */
	

	echo lte_widget(4,array('header' => 'Failure to Login / Logout form',
							'col_grid' => col_grid(12,12,6),
							'bgColor' => 'box-info',
							'collapsable' => true,
							'body' => $this->load->view("admin/Daily_Time_Record/Failure_To_Log/file_logs/form",[],true),
							'foot' => '
										<input type="submit" name="addFailureBtn" value="'.$val.'" id="addFailureBtn" class="btn btn-primary btn-flat">
										<input type="reset"  value="Reset" class="btn btn-default btn-flat">
						   			  ',
							'formData' => array(
												
												'form_open' => $formOpen,
												'ajaxform'  => array(
																	  'beforeSubmit' => 'function(e){
																							$("#addFailureBtn").val("Adding...").addClass("disabled");
																						}',
																	  'complete'	=> 'function(data){
																	  						if(data.responseJSON.success == false){
																	  							$.gritter.add({
																							      title: "Adding failed.",
																							      text: "No Login or Logout specified.",
																							      class_name: "bg-red",
																							      sticky: false,
																							      time:6000
																							    });

																	  						}else{
																	  							$.gritter.add({
																							      title: "Adding success.",
																							      text: "",
																							      class_name: "bg-green",
																							      sticky: false,
																							      time:6000
																							    });
																	  						}

																	  						ftlTbl.ajax.reload();
																	  						$("#addFailureBtn").val("Add").removeClass("disabled");
																	  				   }',
																	  'dataType'	=> '"JSON"'			
																	),
												),
							'formID' => 'failureForm'
							)
					);
?>