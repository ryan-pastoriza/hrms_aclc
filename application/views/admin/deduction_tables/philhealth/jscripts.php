<script>
	var addPhilHealth = function(elem){

		var row = $(elem).parent().parent();

		var psrf = row.find('[name=phic_salary_range_from]').val();
		var psrt = row.find('[name=phic_salary_range_to]').val();
		var pmp = row.find('[name=phic_monthly_premium]').val();
		// var  pee = row.find('[name=phic_ee_share]').val();
		// var per = row.find('[name=phic_er_share]').val();

		if (psrf != "" && psrt != "" && pmp != "" ) {
			$(elem).find('i').css({opacity: '0.5'}).removeClass('fa-plus').addClass('disabled').addClass('fa-spinner').addClass('fa-spin');

			$.post("<?= base_url('index.php/admin/deduction_tables/add_philhealth') ?>","phic_salary_range_from="+psrf+"&phic_salary_range_to="+psrt+"&phic_monthly_premium="+pmp,function(){
				phic_table.ajax.reload();
			})
		}
		return false;
	}
	var deletePhilhealth = function(elem){
		var phic_id = $(elem).attr('phic_id');
		$(elem).parent().parent().parent().find('button span').removeClass('fa-trash').addClass("fa-spinner").addClass('fa-spin').parent().addClass('disabled');
		$.post("<?= base_url('index.php/admin/deduction_tables/delete_phic') ?>","phic_id="+phic_id,function(){
			phic_table.ajax.reload();
		} )
		return false;
	}
</script>