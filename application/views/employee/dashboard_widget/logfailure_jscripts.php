<?php
/**
 * @Author: gian
 * @Date:   2016-08-04 10:16:39
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 10:17:06
 */
?>
<script type="text/javascript">
	$(function(){
		$("#example1").dataTable({
	      "bLengthChange": false,
	      "bSort": true,
	      "pageLength": 10,
	      "ajax" : "<?= base_url('index.php/employee/dashboard/get_emp_logfailure')?>"
	    });
	});
</script>