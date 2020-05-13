<?php
/**
 * @Author: gian
 * @Date:   2016-08-04 10:03:17
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 10:03:48
 */
?>
<script type="text/javascript">
	
	$(function(){
		$("#leavePrev").dataTable({
	      "bLengthChange": false,
	      "bSort": true,
	      "pageLength": 10,
	      "ajax" : "<?= base_url('index.php/employee/dashboard/emp_json') ?>" 
	    });
	})
</script>