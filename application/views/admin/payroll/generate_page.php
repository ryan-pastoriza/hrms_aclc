<style type="text/css">
	.payroll-div{
		display: inline-block;
		padding: 5px;
		background: #00C0EF;
		color: #fff;
	}
	h3{
		color:#222;
	}
	.buttons ul li>a{
		color: #fff;
		text-decoration: none;
		background: #0088CC;
		text-align: center;
		padding: 5px 10px;
	}
	.buttons ul li>a[disabled]{
		background: #ccc;
	}
	.buttons ul li>a[disabled]:hover{
		background: #bbb;
	}
	.buttons ul li>a:hover{
		background: #0077AA;
	}
	.buttons ul li{
		list-style: none;
		display: inline-block;
	}
	.load-div{
		display: none;
		min-height: 100%;
		min-width: 100%;
		background: rgba(0,0,0,0.8);
		position: fixed;
		top: 0;
		left: 0;
		color: #fff;
	}
	.load-div h1{
		color:#fff;
		text-align: center;
		width: 30%;
		margin-left: 35%;
		margin-top: 10%;
	}
	.load-div h1 a{
		background: #DD4B39;
		color:#fff;
		padding:5px 10px;
		text-align: right;
		font-size: .5em;
		text-decoration: none;
	}
	.load-div h1 a:hover{
		background: #DD2B28;
	}
	.load-div h1 small{
		color:#3C8DBC;
		font-weight: lighter;	
		font-size: .8em;
	}
	.notification-div{
		background:#ccc;
		position: fixed;
		right: 10px;
		top: 10px;
	}
	.notification{
		display: block;
		padding:10px;
		border-radius: 3px;
		box-shadow: 0px 0px 10px #ccc;
		font-family: verdana;
		color: #fff;
	}
	.notification.error{
		background: #DD4B39;
	}
	.notification.success{
		background: #00A65A;

	}
	.notification button{
		color: #fff;
		text-decoration: none;
		background: #0088CC;
		text-align: center;
		padding: 5px 10px;
		border: none;
	}
	.notification button:hover{
		background: #0077AA;
		cursor: pointer;
	}
</style>
<script type="text/javascript" src="<?= asset_url('plugins/jQuery/jquery-1.11.3.min.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('plugins/jquery.form.min.js') ?>"></script>
<script type="text/javascript">
	$(function(){
		calculate_proll(1);
	})
	var calculate_proll = function(n){
		var div = ".calc-this:nth-child("+n+")";
		if ($(div).length > 0) {
			var empId = $(div).attr('employee-id');

			$adjustmentSerialize = "";
			// $(div + " [adj]").each(function(k,v){
			// 	console.log($(v).serialize());
			// 	})
			// $.each(, function(k,v){
			// })

			var serializedAdjustments = $(div + " [adj]").serialize();

			$(div).css({background: '#eee', color: '#444'}).append("<br> <small>Calculating Payroll . . .</small>");
			$.post("<?= base_url('index.php/admin/payroll/generate_emp_proll') ?>","employee_id="+empId+"&cut_off_start=<?= $this->input->post('cut_off_start') ?>&cut_off_end=<?= $this->input->post('cut_off_end') ?>&proll_date=<?= $this->input->post('payroll')['year'].'-'.$this->input->post('payroll')['month'] ?>-<?= $this->input->post('payroll')['day'] == '15th' ? '15': date('t') ?>&sss=<?= $this->input->post('sss') ?>&philhealth=<?= $this->input->post('philhealth') ?>&pagibig=<?= $this->input->post('pagibig')?>&"+serializedAdjustments, function(r){
					$(div).html(r).css({padding:'0px'}).removeClass('calc-this');
					n = n + 1;
					calculate_proll(n);
						$("html, body").animate({ scrollTop: $(document).height() }, 100);
				})
		}
		else{
			alert('Payroll Complete!');
			$('[save-btn]').removeAttr('disabled');
		}
	}
	var printPayroll 	= function(){
		$('.buttons').hide();
			window.print();
		$('.buttons').show();
	}
	var check_existence = function(){
		$('.load-div').show();
		$.post("<?= base_url('index.php/admin/payroll/payroll_calculated') ?>/<?= $this->input->post('payroll')['year'].'-'.$this->input->post('payroll')['month'] ?>-<?= $this->input->post('payroll')['month'] == '15th' ? '15': date('t') ?>/<?= $this->input->post('cut_off_start') ?>/<?= $this->input->post('cut_off_end') ?>","",
					function(r){
						$('.load-div').hide();
						if (r.success == false) {
							add_notification('error',r.txt);
						}else{
							save_payroll();
							add_notification('success',"Payroll Saved!");
						}
					},
					'json'
				)
	}
	var save_payroll 	= function(){
		$('.load-div').show();
				$('.payroll-form').ajaxForm({
				beforeSubmit: function(){
				},
				success: function(r){
					console.log(r);
					$('.notification.error').fadeOut();
					add_notification('success','Payroll Overwritten!');
					$('.load-div').hide();
				}
				}).trigger('submit');
	}
	var add_notification = function(div_class, msg){
		$('.notification-div').append("<div class='notification "+div_class+"'>\
										"+msg+"\
										</div>");
		setTimeout(function(){
			$('.notification.success').fadeOut();
		},2000);
	}
</script>

<?php if (count($employees) < 1): ?>
	<h3>No Employee Selected.</h3>
<?php else: ?>
	<?= form_open(base_url('index.php/admin/payroll/save_payroll'), 'class="payroll-form"') ?>
	<?php foreach ($employees as $key => $value): ?>
		<div class="payroll-div calc-this" employee-id="<?= $value->employee_id ?>">
			<?= $value->fullName('l, f m.') ?>

		<?php if (isset($value->adjustments)): ?>
			<?php foreach ($value->adjustments as $key2 => $value2): ?>
				<input type="hidden" name="adjustments[amount][]" adj value="<?= $value2['amount'] ?>">
				<input type="hidden" name="adjustments[name][]" 	adj value="<?= $value2['name'] ?>">
			<?php endforeach ?>
		<?php endif ?>			
		</div>

	<?php endforeach ?>
	<input type="hidden" name="pr_date" value="<?= $this->input->post('payroll')['year'].'-'.$this->input->post('payroll')['month'] ?>-<?= $this->input->post('payroll')['day'] == '15th' ? '15': date('t') ?>">
	<input type="hidden" name="pr_cut_off_from" value="<?= $this->input->post('cut_off_start')  ?>">
	<input type="hidden" name="pr_cut_off_to"   value="<?= $this->input->post('cut_off_end')  ?>">
	<?= form_close(); ?>
<?php endif ?>
<div class="buttons">
	<ul>
		<li> <a href="#" onclick="printPayroll()">Print</a> </li>
		<li> <a href="#" disabled = 'disabled' save-btn onclick="check_existence()">Save</a> </li>
		<!-- <li> <a href="#"></a> </li> -->
	</ul>
</div>
<div class="notification-div"></div>
<div class="load-div">
	<h1>
		<em>Saving . . . <hr>
			<small>Do not turn your computer off or close this page while saving is in progress.</small>
		</em>
		<br>
		<br>
		<br>
		<br>
		<a href="#">Cancel</a>
	</h1>
</div>