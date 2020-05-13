<?= form_open(base_url('index.php/employee/payroll/search_payslip'), 'id="search-payslip-form"'); ?>
	<div class="row">
		<div class="<?= col_grid(12,12,12,4) ?>">
			<label>Month</label>
			<select name="proll_month" onchange="view_payslip()">
				<option value="">Select Month</option>
				<?php 
					for ($i=1; $i < 13; $i++) { 
						echo "<option value='{$i}' >". date('F',strtotime("21-".$i."-1990")) ."</option>";
					}
				 ?>
			</select>
		</div>
		<div class="<?= col_grid(12,12,4) ?>">
			<label>Payroll Date</label>
			<select name="proll_date" onchange="view_payslip()">
				<option value="">dd</option>
				<option>15th</option>
                <option>End of Month</option>
			</select>
		</div>
		<div class="<?= col_grid(12,12,4) ?>">
			<label>Payroll Year</label>
			<select name="proll_year" onchange="view_payslip()">
				<option value="">YYYY</option>
			<?php 
				for ($i=2015; $i <= date('Y'); $i++) { 
					echo "<option>{$i}</option>";
				}
			 ?>
			</select>
		</div>
	</div>
<?= form_close(); ?>
<div class="row">
	<div class="<?= col_grid(12) ?>" id="payslip-view">
		<?php 
			$this->load->view('employee/payslip/payslip');
		 ?>
	</div>
</div>