<?php

/**
 * @Author: gian
 * @Date:   2016-08-04 09:51:30
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 09:51:39
 */
?>
<script type="text/javascript">
	$(function(){
		moment().format();
	    $("#calendar").fullCalendar({
	      events:"<?= base_url('index.php/employee/dashboard/show_event'); ?>"
	    });  
	})
</script>