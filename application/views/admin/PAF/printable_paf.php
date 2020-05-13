

<head>

	<title>Personnel Action Form</title>
	<link rel="stylesheet" href="<?= asset_url('bootstrap/css/bootstrap.min.css') ?>">
	<script src="<?= asset_url('plugins/jQuery/jQuery-2.2.0.min.js') ?>"></script>
	<script>
		$(function(){
			$('body').css("font-size", "12px");
			$('td').css("font-size", "12px");
			$('h4').css("font-size", "16px");
			$('p').css("line-height", "5px");
			$('.printable_show').show();
			$('.printable_hide').hide();
			$('input[type=text]').attr("readonly", true).css("border", "0px");
			$('input[type=date]').attr("readonly", true).css("border", "0px");
			$('input[type=number]').attr("readonly", true).css("border", "0px");
			$('textarea').attr("readonly", true).css("border", "0px").css('outline', 'none');
			$('input[type=radio]').attr("disabled", true);
			$('.paf_table td').css("border", "1px solid black");
			$('.paf_other_table td').css("border", "1px solid black").css("border-top", "0px");
			$('#header').css("border", "1px solid black").css("border-bottom", "0px");
			$()
			window.print();
			
		});
	</script>
</head>
<?php $this->load->view('admin/PAF/form/main'); ?> 