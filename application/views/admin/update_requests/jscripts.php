<?php

/**
 * @Author: IanJayBronola
 * @Date:   2018-10-10 13:53:38
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-10 14:07:35
 */
?>
<script>
	$(function(){
		$('#approve-req-form').ajaxForm({
			beforeSubmit: function(){
				$('#approve-req-form').find("button:submit").attr('disabled','disabled');
			},
			success: function(){
				$.gritter.add({
  								title: "Request Approved!",
  								class_name: "bg-green",
  								sticky:false,
  								time:3000
  							});
				req_tbl.ajax.reload();
				$('.modal').modal('hide');
			}
		})
	})
	function approve_request(id) {
		$('#approve-req-form input[name=eur_id]').val(id);
		$('#approve-req-modal').modal('show');
	}
</script>