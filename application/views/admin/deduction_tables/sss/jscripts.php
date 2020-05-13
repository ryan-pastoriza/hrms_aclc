<script type="text/javascript">
	var add_sss = function(elem){
		var r_from = $(elem).parent().parent().find("[range-from]").val();
		var r_to = $(elem).parent().parent().find("[range-to]").val();
		var ee_cont = $(elem).parent().parent().find("[ee-cont]").val();
		var er_cont = $(elem).parent().parent().find("[er-cont]").val();

		if (r_from != "" && r_to != "" & ee_cont != "" && er_cont != "") {
			$(elem).find('i').removeClass('fa-add').addClass('fa-spinner').addClass('animate-spin');

			$.post("<?= base_url('index.php/admin/deduction_tables/add_sss') ?>","sss_range_from="+ r_from +"&sss_range_to="+r_to+"&sss_er_cont="+er_cont+"&sss_ee_cont="+ee_cont, function(){
				sss_table.ajax.reload();
			})
		}
	}

	$(document).on('click','.remove-row-btn',function(){
		$(this).parent().parent().css({opacity:"0.5"});
		$(this).parent().parent().find('i').removeClass('fa-minus').addClass('fa-spinner').addClass('animate-spin');
		var sss_id = $(this).attr('sss-id');
		$.post("<?= base_url('index.php/admin/deduction_tables/delete_sss') ?>","sss_id="+sss_id,function(){
			sss_table.ajax.reload();
		})
	})
	$(document).on('change','[ee-cont],[er-cont]',function(){
		var total = parseFloat($('[ee-cont]').val()) + parseFloat($('[er-cont]').val());
		$('[total-cont]').html(total);
	})

</script>