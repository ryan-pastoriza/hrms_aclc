<?php 
	$totalPay = 0;
	$lateTotal = 0;
	$absentDays = 0;
	$otherDeductions = 0;


 ?>
<div style="width:357px;background-color:#eee;border:1px solid black;display:inline-block;margin-right:0px;margin-bottom:0px; padding:5px;margin-top:20px">
		<table>
		  <tbody>
		    <tr>
		      <td colspan="6"><p style="text-align: center; font-size: 12px;">PAYSLIP</p></td>
		    </tr>
		    <tr>
		      <td width="62" style="font-size: 12px">Name :</td>
		      <td colspan="4" style="font-size: 12px"> <?= $this->userInfo->fullName('f m. l') ?> </td> <!---->
		      <td width="58" style="font-size: 12px">&nbsp;</td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">Payroll :</td>
		      <td colspan="4" style="font-size: 12px"> <?= isset($payroll_date) ? $payroll_date : "Select Date" ?>  </td>
		      <td style="font-size: 12px">&nbsp;</td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">Cut-Off</td>
		      <td colspan="4" style="font-size: 12px"><?= isset($cut_off) ? $cut_off : "Select Date" ?></td>
		      <td style="font-size: 12px">&nbsp;</td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">Mo. Basic</td>
		      <td width="55" style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"> <?= isset($payroll_date) ? number_format($epr->emp_proll_pay,2) : "0.00" ?> </span></td>
		      <td colspan="2" style="font-size: 12px">every payroll</td>
	          <td width="51" style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= isset($epr) ? number_format($epr->emp_proll_pay / 2,2) : "0.00" ?> </span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">O-time/O</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0.00</span> </td>
		      <td style="font-size: 12px">per hr. x</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0</span></td>
		      <td style="font-size: 12px"> hrs</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0.00</span></td>
		    </tr>
		    <?php if (isset($adjustment)): ?>
			    <?php if ($adjustment): ?>
			    	<?php foreach ($adjustment as $key => $value): 
			    	$totalPay += $value ?>
					     <tr>
					      <td style="font-size: 12px">Adjustment</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($value,2) ?></span></td>
					    </tr>
			    	<?php endforeach ?>
			    <?php endif ?>
		    <?php endif ?>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">Total</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px"> <?= isset($payroll_date) ?  number_format($totalPay += $this->userInfo->employment_rate / 2,2) : "0.00" ?> </td>
		    </tr>
		    
		    <tr>
		      <td style="font-size: 12px">Less</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">U-time</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0</span></td>
		      <td style="font-size: 12px">per hr. x</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0</span></td>
		      <td style="font-size: 12px"> hrs</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= isset($epr) ? number_format($epr->emp_proll_ot,2) : "0.00" ?></span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">Lates</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">1.00</span> </td>
		      <td style="font-size: 12px">per min. x</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"> <?= isset($epr) ? $totalLateMins = ($epr->emp_proll_late_hrs * 60) + $epr->emp_proll_late_mins : "0" ?> </span> </td>
		      <td style="font-size: 12px">min</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"> <?= isset($epr) ? number_format($epr->emp_proll_ot,2) : "0.00" ?> </span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">Absences</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0.00</span> </td>
		      <td style="font-size: 12px">per hr. x</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0</span> </td>
		      <td style="font-size: 12px">hrs</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">0.00</span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= $this->userInfo->daily_rate; ?></span> </td>
		      <td style="font-size: 12px">per day. x</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= isset($epr) ? $epr->emp_proll_absent_days: "&nbsp;0" ?> </span></td>
		      <td style="font-size: 12px">days</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= isset($epr) ? number_format( $absent_deduct = $this->userInfo->daily_rate * $epr->emp_proll_absent_days,2) : "0.00" ?></span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
	          <td style="font-size: 12px">&nbsp;</td>
		      <td colspan="2" style="font-size: 12px">Total Lates &amp; Absences</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= isset($epr) ? number_format($totalLess = ($this->userInfo->daily_rate * $epr->emp_proll_absent_days) + $totalLateMins,2) : "0.00" ?></span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td colspan="2" style="font-size: 12px"><strong>Gross Pay</strong></td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"> <?= isset($epr) ? number_format($grossPay = $totalPay - $totalLess,2) : "0.00" ?> </span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">Less</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		    </tr>
		    <?php if (isset($epr)): ?>
			    	 <tr>
				      <td style="font-size: 12px">W/Tax</td>
				      <td style="font-size: 12px">&nbsp;</td>
				      <td style="font-size: 12px">&nbsp;</td>
			          <td style="font-size: 12px">&nbsp;</td>
				      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= $wtax_deduct = $epr->emp_proll_wtax ?></span></td>
				      <td style="font-size: 12px">&nbsp;</td>
				    </tr>
			    	<?php $otherDeductions += $wtax_deduct; ?>
			    <tr>
			      <td style="font-size: 12px">SSS</td>
			      <td style="font-size: 12px">&nbsp;</td>
			      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($sss_deduct = $epr->emp_proll_sss,2); ?></span></td>
			      <td style="font-size: 12px">&nbsp;</td>
			      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format( $otherDeductions +=  $epr->emp_proll_sss,2); ?></span></td>
			      <td style="font-size: 12px">&nbsp;</td>
			    </tr>
			    <tr>
			      <td style="font-size: 12px">Philhealth</td>
			      <td style="font-size: 12px">&nbsp;</td>
			      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($epr->emp_proll_philhealth,2) ?></span></td>
			      <td style="font-size: 12px">&nbsp;</td>
			      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $otherDeductions += $epr->emp_proll_philhealth; echo 	number_format($philhealth_deduct = $epr->emp_proll_philhealth,2) ?></span></td>
			      <td style="font-size: 12px">&nbsp;</td>
			    </tr>
			    <tr>
			      <td style="font-size: 12px">HDMF</td>
			      <td style="font-size: 12px">&nbsp;</td>
			      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;">100.00</span></td>
			      <td style="font-size: 12px">&nbsp;</td>
			      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $otherDeductions += $epr->emp_proll_hdmf; echo number_format( $hdmf_deduct = $epr->emp_proll_hdmf,2) ?></span></td>
			      <td style="font-size: 12px">&nbsp;</td>
			    </tr>
				<?php if ($cas = $this->userInfo->cash_advance()): ?>
					<?php foreach ($cas as $key => $value): ?>
						<?php if ($value->emp_ca_repayment_term == 'Semi-monthly' || ($value->emp_ca_repayment_term == 'Monthly' && date('d', strtotime($payroll_date)) == 15 )): ?>
						<tr>
					      <td style="font-size: 12px">Cash Advance</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px">&nbsp;</td>
					      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?php echo $ca = $value->ca_balance != "" && $value->ca_balance <= $value->emp_ca_repayment_amt ? $value->ca_balance : $value->emp_ca_repayment_amt; $otherDeductions += $ca; ?></span></td>
					    </tr>
						<?php endif ?>
					<?php endforeach ?>
			    <?php endif ?>
			<?php endif ?>
		    <?php if (isset($payroll_date)): ?>
			    <?php if ($loans = $this->userInfo->loans()): ?>
			    	<?php foreach ($loans as $key => $value): ?>
			    		<?php if ($value->emp_loan_term == 'Semi-monthly' || ($value->emp_loan_term == 'Monthly' && date('d', strtotime($payroll_date)) == 15 )): ?>
				    		<tr>
						      <td style="font-size: 12px"><?= $value->emp_loan_type ?></td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?php $loan = $value->loan_balance != "" && $value->loan_balance <= $value->emp_loan_deduct ? $value->loan_balance : $value->emp_loan_deduct; $otherDeductions += $loan; echo number_format($loan,2); ?></span></td>
						    </tr>
			    		<?php endif ?>
			    	<?php endforeach ?>
			    <?php endif ?>
		    <?php endif ?>
		    <?php if (isset($payroll_date)): ?>
				<?php if ($otherDeds = $this->userInfo->other_deductions()): ?>
					<?php foreach ($otherDeds as $key => $value): ?>
						<?php if ($value->other_ded_term == 'Semi-monthly' || ($value->other_ded_term == 'Monthly' && date('d', strtotime($payroll_date) == 15))): ?>
							<?php 
								$oDd = $value->balance < $value->eod_term_deduction_amt ? $value->balance : $value->eod_term_deduction_amt;
								$otherDeductions += $oDd;
							 ?>
							<tr>
						      <td style="font-size: 12px"><?= $value->other_ded_name ?></td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px">&nbsp;</td>
						      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($oDd, 2); ?></span></td>
						    </tr>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
		    <?php endif ?>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td colspan="2" style="font-size: 12px">Total Deduction</td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= number_format($otherDeductions,2) ?></span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td colspan="2" style="font-size: 12px"><strong>NET PAY</strong></td>
		      <td style="font-size: 12px"><span style="display:block;width:100%;border-bottom:1px solid black;"><?= isset($epr) ? number_format($grossPay - $otherDeductions,2) : "0.00" ?></span></td>
		    </tr>
		    <tr>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td colspan="2" style="font-size: 12px">(Signature/Date Received)</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		      <td style="font-size: 12px">&nbsp;</td>
		    </tr>
		  </tbody>
		</table>
	</div>