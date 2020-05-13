<script type="text/javascript">
	
	$(function() {
		var tableOptions = {
								ajax : "<?= base_url('index.php/admin/personnel_action_form/paf_json') ?>",
							};

		oTable = $('#table').dataTable(tableOptions);

	});

	function print_this(e) {
		$('[name=emp_paf_id]').val($(e).attr('name'));
		$('#form_print').submit();
	}

</script>

