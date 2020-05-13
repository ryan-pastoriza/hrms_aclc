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
	<div class="col-md-12 col-lg-8 col-sm-12">
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
</section>