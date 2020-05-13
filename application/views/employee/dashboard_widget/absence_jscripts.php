<?php

/**
 * @Author: gian
 * @Date:   2016-08-04 09:39:28
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 09:43:21
 */
?>
<script type="text/javascript">
	$(function(){
		 $.post("<?= base_url('index.php/employee/dtr/absence_bar') ?>","",function(r){
	        Morris.Bar({
	          
	          element: 'bar-chart',
	          data: r,
	          xkey: 'y',
	          ykeys: ['a'],
	          labels: ['Absent'],
	          hideHover: 'auto'

	        });
	    },'json')
	});
</script>