<?php
/**
 * @Author: khrey
 * @Date:   2015-09-24 09:20:00
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-09-28 09:49:51
 */
?>
<script type="text/javascript">
	var tableOptions;
	var options;
        $(function(){

        	$('#upload-attendance-form').ajaxForm({
        		beforeSubmit: function(a,b,c,d){
        			$(b).find(":submit").attr('disabled','disabled');
        			$(b).find('.display').html('Saving, please wait till the process is complete before navigating away from this page.');
        		},
        		success: function(a){
        			console.log(a);
        		},
        		complete:function(a,b,c,d){
        			$(c).find('.display').html(a);

        			// var ret = a.responseJSON;
        			$(c).find(':submit').removeAttr('disabled');
        			// $(c).find('.display').html(ret.text);
        			
        		},
        		// dataType : "json"
        	});

        	 options = {
			          url:"<?= base_url() ?>index.php/admin/biometrics/assign_id",
			          mode:"inline",
			          ajaxOptions: {dataType:"json"},
			          success: function(r,nval){
			          			if (!r.success) {
			          				return r.view;
			          			};
			                        },
			          send: "always",
			                };


        	tableOptions = {
	          "ajax": "<?= base_url() ?>index.php/admin/biometrics/bio_list",
	            fnDrawCallback: function(){
	            	$('.editable').editable(options);
	            },
	        }
        	$('#bioTable').dataTable(tableOptions);
        	$('.editable').editable(options);
        })

        
</script>
<section class="content-header">
	<h1>Biometric Accounts</h1>
</section>
<section class="content">
	<div class="col-md-8 col-lg-8 col-sm-12">
		<div class="box">
			<div class="box-header with-border">	
				<span class="box-title">
					Employees with biometric accounts
				</span>
			</div>
			<div class="box-body">
				<table id="bioTable" class="table table-bordered table-hover">
					<thead>
			          <th>Employee</th>
			          <th>Biometric ID</th>
			        </thead>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 row">
		<?php 
			$this->load->view('admin/biometrics/manual_upload/main');
		 ?>
	</div>
</section>