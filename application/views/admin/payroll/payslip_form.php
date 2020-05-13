<?php
/**
 * @Author: gian
 * @Date:   2016-01-11 10:41:12
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-22 09:03:21
 */
	
	$otherDeductions = 0;
	$totalPay 		= 0;
	$totalCa 		= 0;


?>

	<div style="width:380px;background-color:#FFFFFF;border:1px solid black;display:inline-block;margin-right:0px;margin-bottom:0px;">
	<?php if ($employee->employment_rate == ""): ?>
		<center><h3><?= $employee->fullName() ?>'s rate was not set.</h3></center>
	<?php else: ?>
		<table style=" font-size:.8em !important">
		  <tbody>
		    <tr>
		      <td colspan="6"><p style="text-align: center; ">PAYSLIP</p></td>
		    </tr>
		    <tr>
		      <td width="62">Name :</td>
		      <td colspan="4"> <?= $employee->fullName('f m. l') ?> </td> <!---->
		      <td width="58">&nbsp;</td>
		    </tr>
		    <tr>
		      <td>Payroll :</td>
		      <td colspan="4"> <?= $payroll_date ?>  </td>
		      <td>&nbsp;</td>
		    </tr>
		    <tr>
		      <td>Cut-Off</td>
		      <td colspan="4"><?= $cut_off ?></td>
		      <td>&nbsp;</td>
		    </tr>
		    <tr>
		      <td>Mo. Basic</td>
		      <td width="55"><span style="display:block;width:100%;border-bottom:1px solid black;"> <?= number_format($employee->employment_rate,2) ?> </span></td>
		      <td colspan="2">every payroll</td>
	          <td width="51">&nbsp;</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($employee->employment_rate / 2,2) ?> </span></td>
		    </tr>
	  		<?php 
		    	$otPay =  $employee->ot_rate * $overtime;
		    	$totalPay += $otPay;
		     ?>

		    <tr>
		      <td>O-time/O</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($employee->ot_rate, 2) ?></span> </td>
		      <td>per hr. x</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= $overtime ?></span></td>
		      <td> hrs</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format( $otPay ,2) ?></span></td>
		    </tr>

		    <?php if ($adjustments): ?>
		    	<?php foreach ($adjustments['name'] as $key => $value): ?>
			    	<?php if ($adjustments['amount'][$key] > 0): 
			    	$totalPay += $adjustments['amount'][$key] ?>
			    		 <tr>
					      <td><?= $value ?></td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($adjustments['amount'][$key],2) ?></span></td>
					    </tr>
			    	<?php endif ?>
				    
		    	<?php endforeach ?>
		    <?php endif ?>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>Total</td>
		      <td>&nbsp;</td>
		      <td> <?= number_format($totalPay += $employee->employment_rate / 2,2) ?> </td>
		    </tr>
		    
		    <tr>
		      <td>Less</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		    </tr>
		    <tr>
		      <td>U-time</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($employee->hourly_rate,2) ?></span></td>
		      <td>per hr. x</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($ut,2) ?></span></td>
		      <td> hrs</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $utPayment = $ut * $employee->hourly_rate; echo number_format($utPayment,2); ?></span></td>
		    </tr>
		    <tr>
		      <td>Lates</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($employee->minute_rate,2) ?></span> </td>
		      <td>per min. x</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"> <?php echo $lateTotal; ?> </span> </td>
		      <td>min</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"> <?php $latePayment = $lateTotal * $employee->minute_rate; echo number_format($latePayment,2) ?> </span></td>
		    </tr>
		    <tr>
		      <td>Absences</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;">0.00</span> </td>
		      <td>per hr. x</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;">0</span> </td>
		      <td>hrs</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;">0.00</span></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= $employee->daily_rate; ?></span> </td>
		      <td>per day. x</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= $absentDays ?> </span></td>
		      <td>days</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format( $absent_deduct = $employee->daily_rate * $absentDays,2) ?></span></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
	          <td>&nbsp;</td>
		      <td colspan="2">Total Lates &amp; Absences</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($totalLess = ($employee->daily_rate * $absentDays) + $latePayment + $utPayment,2) ?></span></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td colspan="2"><strong>Gross Pay</strong></td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"> <?= number_format($grossPay = $totalPay - $totalLess,2) ?> </span></td>
		    </tr>
		    <tr>
		      <td>Less</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		    </tr>
	    	 <tr>
		      <td>W/Tax</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <?php $wtax_deduct = $employee->tax_bracket('semi-monthly')->wtax_amount ?>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= $employee->tax_bracket('semi-monthly')->wtax_amount ?></span></td>
		    </tr>
	    	<?php $otherDeductions += $wtax_deduct; ?>
		   
		    <?php if ($sss): ?>
			    <tr>
			      <td>SSS</td>
			      <td>&nbsp;</td>
			      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($sss_deduct = $employee->sss_share()['employer'],2); ?></span></td>
			      <td>&nbsp;</td>
			      <td><span style="display:block;width:100%;border-bottom:1px solid black;">
			      <?php $otherDeductions +=  $employee->sss_share()['employee'] ?>
			      <?= number_format( $employee->sss_share()['employee'] ,2); ?></span></td>
			      <td>&nbsp;</td>
			    </tr>
		    <?php endif ?>
			<?php if ($philhealth): ?>
			    <tr>
			      <td>Philhealth</td>
			      <td>&nbsp;</td>
			      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($employee->philhealth_share()['employer'],2) ?></span></td>
			      <td>&nbsp;</td>
			      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $otherDeductions += $employee->philhealth_share()['employee']; echo 	number_format($philhealth_deduct = $employee->philhealth_share()['employee'],2) ?></span></td>
			      <td>&nbsp;</td>
			    </tr>
			<?php endif ?>
			<?php if ($pagibig): ?>
			    <tr>
			      <td>HDMF</td>
			      <td>&nbsp;</td>
			      <td><span style="display:block;width:100%;border-bottom:1px solid black;">100.00</span></td>
			      <td>&nbsp;</td>
			      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $otherDeductions += $employee->pagibig_share(); echo number_format( $hdmf_deduct = $employee->pagibig_share(),2) ?></span></td>
			      <td>&nbsp;</td>
			    </tr>
			<?php endif ?>
			<?php if ($cas = $employee->cash_advance()): ?>
		    	 
				<?php foreach ($cas as $key => $value): ?>
					<?php if ($value->emp_ca_repayment_term == 'Semi-monthly' || ($value->emp_ca_repayment_term == 'Monthly' && date('d', strtotime($payroll_date)) == 15 )): ?>
					<?php if($value->emp_ca_deduct_start != "" && date('Y-m-d', strtotime($payroll_date)) >= date('Y-m-d', strtotime($value->emp_ca_deduct_start))){ ?>
					<tr>
				      <td>Cash Advance</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?php echo $ca = $value->ca_balance != "" && $value->ca_balance <= $value->emp_ca_repayment_amt ? $value->ca_balance : $value->emp_ca_repayment_amt; $otherDeductions += $ca; ?></span></td>
				    </tr>
				    <?php } ?>
					<?php endif ?>
				<?php endforeach ?>
		    <?php endif ?>
		    <?php if ($loans = $employee->loans()): ?>
		    	<?php foreach ($loans as $key => $value): ?>
		    		<?php if ($value->emp_loan_term == 'Semi-monthly' || ($value->emp_loan_term == 'Monthly' && date('d', strtotime($payroll_date)) == 15 )): ?>
			    		<tr>
					      <td><?= $value->emp_loan_type ?></td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $loan = $value->loan_balance != "" && $value->loan_balance <= $value->emp_loan_deduct ? $value->loan_balance : $value->emp_loan_deduct; $otherDeductions += $loan; echo number_format($loan,2); ?></span></td>
					    </tr>
		    		<?php endif ?>
		    	<?php endforeach ?>
		    <?php endif ?>

			<?php if ($otherDeds = $employee->other_deductions()): ?>
				<?php foreach ($otherDeds as $key => $value): 
					$other_ded_info = $value->belongs_to('Other_Deduction');
				?>
					<?php if ($other_ded_info->other_ded_term == 'Semi-monthly' || ($other_ded_info->other_ded_term == 'Monthly' && date('d', strtotime($payroll_date) == 15))): ?>
						<?php 
							$oDd = $value->balance() != "" && $value->balance() < $value->eod_term_deduction_amt ? $value->balance() : $value->eod_term_deduction_amt;
							$otherDeductions += $oDd;
						 ?>
						<tr>
					      <td><?= $other_ded_info->other_ded_name ?></td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($oDd, 2); ?></span></td>
					    </tr>
					<?php endif ?>
				<?php endforeach ?>
			<?php endif ?>
			  <?php if ($adjustments): ?>
		    	<?php foreach ($adjustments['name'] as $key => $value): ?>
			    	<?php if ($adjustments['amount'][$key] < 0): 
			    	$otherDeductions += abs($adjustments['amount'][$key]) ?>
			    		 <tr>
					      <td><?= $value ?></td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format(abs($adjustments['amount'][$key]),2) ?></span></td>
					    </tr>
			    	<?php endif ?>
				    
		    	<?php endforeach ?>
		    <?php endif ?>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td colspan="2">Total Deduction</td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($otherDeductions,2) ?></span></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td colspan="2"><strong>NET PAY</strong></td>
		      <td><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($grossPay - $otherDeductions,2) ?></span></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="2">(Signature/Date Received)</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		    </tr>
		  </tbody>
		</table>

		<!-- hidden for saving -->
			<?php if ($isForm): ?>

				<input type="hidden" name="emp_proll_late_mins[<?= $employee->employee_id ?>]" value="<?= $lateTotal ?>">
				<input type="hidden" name="emp_proll_late_ded[<?= $employee->employee_id ?>]" value="<?= $latePayment ?>">
				<input type="hidden" name="emp_proll_ut_mins[<?= $employee->employee_id ?>]" value="<?= $ut ?>">
				<input type="hidden" name="emp_proll_ut_ded[<?= $employee->employee_id ?>]" value="<?= $ut ?>">

				<input type="hidden" name="emp_proll_absent_days[<?= $employee->employee_id ?>]" value="<?= $absentDays ?>">
				<input type="hidden" name="employment_id[<?= $employee->employee_id ?>]" 	value="<?= $employee->employment_id ?>">
				<!-- <input type="hidden" name="emp_proll_late[<?= $employee->employee_id ?>]" 		value="<?= $lateTotal ?>"> -->
				<input type="hidden" name="emp_proll_absent[<?= $employee->employee_id ?>]" 	value="<?= $absent_deduct ?>">
				<input type="hidden" name="emp_proll_ot_hrs[<?= $employee->employee_id ?>]" value="<?= $overtime ?>" >
				<input type="hidden" name="emp_proll_ot_pay[<?= $employee->employee_id ?>]" value="<?= $otPay ?>">

				<?php if (isset($wtax_deduct)): ?>
					<input type="hidden" name="emp_proll_wtax[<?= $employee->employee_id ?>]" 		value="<?= $wtax_deduct ?>">
				<?php endif ?>
				<input type="hidden" name="emp_proll_sss[<?= $employee->employee_id ?>]" 		value="<?= $sss ? $sss_deduct : '0' ?>">
				<input type="hidden" name="emp_proll_philhealth[<?= $employee->employee_id ?>]" value="<?= $philhealth ? $philhealth_deduct : '0'  ?>">
				<input type="hidden" name="emp_proll_hdmf[<?= $employee->employee_id ?>]" 		value="<?= $pagibig ? $hdmf_deduct : '0'  ?>">
				<input type="hidden" name="emp_proll_pay[<?= $employee->employee_id?>]" value="<?= $employee->employment_rate ?>">


				<?php if ($adjustments): ?>
					<?php foreach ($adjustments['amount'] as $key => $value): ?>
						<input type="hidden" name="adjustments[<?= $employee->employee_id ?>][amount][]" value="<?= $value ?>">
						<input type="hidden" name="adjustments[<?= $employee->employee_id ?>][name][]" value="<?= $adjustments['name'][$key] ?>">
					<?php endforeach ?>
				<?php endif ?>
				<?php if ($otherDeds): ?>
					<?php foreach ($otherDeds as $key => $value): 
						$other_ded_info = $value->belongs_to('Other_Deduction');
					?>
						<?php if ($other_ded_info->other_ded_term == 'Semi-monthly' || ($other_ded_info->other_ded_term == 'Monthly' && date('d', strtotime($payroll_date) == 15))): 
						$oDd = $value->balance() < $value->eod_term_deduction_amt ? $value->balance() : $value->eod_term_deduction_amt;
						?>
							<input type="hidden" name="other_deductions[<?= $employee->employee_id ?>][<?= $value->eod_id ?>]" value="<?= $oDd ?>">
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
				<?php if ($loans = $employee->loans()): ?>
					<?php foreach ($loans as $key => $value): ?>
						<?php if ($value->emp_loan_term == 'Semi-monthly' || ($value->emp_loan_term == 'Monthly' && date('d', strtotime($payroll_date)) != 30 )): ?>
						<input type="hidden" name="loans[<?= $employee->employee_id ?>][<?= $key ?>]" value = "<?=  $value->loan_balance != "" && $value->loan_balance <= $value->emp_loan_deduct ? $value->loan_balance : $value->emp_loan_deduct; ?>" >
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
				<?php if ($cas = $employee->cash_advance()): ?>
					<?php foreach ($cas as $key => $value): ?>
						<?php if ($value->emp_ca_repayment_term == 'Semi-monthly' || ($value->emp_ca_repayment_term == 'Monthly' && date('d', strtotime($payroll_date)) != 30 )): ?>
							<input type="hidden" name="cash_advances[<?= $employee->employee_id ?>][<?= $key ?>]" value="<?= $value->ca_balance != "" && $value->ca_balance <= $value->emp_ca_repayment_amt ? $value->ca_balance : $value->emp_ca_repayment_amt; ?>">					
						<?php endif ?>
					<?php endforeach ?>
			    <?php endif ?>
			<?php endif ?>
		<!-- end -->
	<?php endif ?>

	</div>