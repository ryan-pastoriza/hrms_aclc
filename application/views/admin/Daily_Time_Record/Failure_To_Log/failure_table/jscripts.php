<?php
/**
 * @Author: gian
 * @Date:   2016-04-11 08:55:35
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-11 15:16:13
 */
?>
<script type="text/javascript">
	$(function(){
		var opts = {
			url:"<?= base_url() ?>index.php/admin/failure_to_log/update_fail_log",
			mode:"inline",
			ajaxOptions:{
				dataType:'json'
			},
			success:function(r,nval){
				if(r.success != true){
					return false;
				}
			},
			send:"always",
		};
	});
</script>