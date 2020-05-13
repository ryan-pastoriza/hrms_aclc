<?php 
	
	$emp_proll_recs 	= $record->emp_proll(); 
	$deductions 		= [];
	$loans 				= [];
	$other_deductions 	= [];

	$grossBasic 		= 0;
	$grossAdjustments 	= 0;
	$gross_gross 		= 0;
	$gross_cap 			= 0;
	$gross_take_home 	= 0;
	$gross_absences 	= 0;
	$gross_late 		= 0;
	$gross_ut 			= 0;
	$gross_sss			= 0;
	$gross_philhealth	= 0;
	$gross_hdmf 		= 0;
	$gross_wtax			= 0;

	$plus_adjustments = [];
	$minus_adjustments = [];



	foreach ($emp_proll_recs as $key => $value) {

		// additional adjustments
		$value->adjustments = $value->adjustments();
		$value->total_adjustment = 0;
		foreach ($value->adjustments as $key2 => $value2) {
			if ($value2->proll_adj_amt >= 0) {
				if (!isset($plus_adjustments[$value2->proll_adj_name])) {
					$plus_adjustments[$value2->proll_adj_name] = 0;
				}
			}
			else{
				if (!isset($minus_adjustments[$value2->proll_adj_name])) {
					$minus_adjustments[$value2->proll_adj_name] = 0;
				}
			}
		}


		// cash advance deductions
		if (!in_array( "Cash Advance",$deductions)) {
			if (count($value->cash_advance_payments()) > 0) {
				$deductions[] = "Cash Advance";
			}
		}
		// loans deductions
		if ($value->loan_payments()) {
			foreach ($value->loan_payments() as $key2 => $value2) {
				if (!in_array( $value2->emp_loan_type, $loans)) {
					$loans[] = $value2->emp_loan_type;
	 				${"gross{$value2->emp_loan_type}"} = 0;
				}
			}
			
		}
		if ($value->other_deduction_payments()) {

			foreach ($value->other_deduction_payments() as $key2 => $value2) {
				if (!in_array($value2->other_ded_name, $other_deductions)) {
					$other_deductions[] = $value2->other_ded_name;
					${"gross{$value2->other_ded_name}"} = 0;
				}
			}
			
		}



	}


 ?>
 <div class="col-sm-12">
 	<center>
	 	<img src="<?= base_url('images/ama.fw.png')  ?>" height="50px" width="50px">
 		<h4>A C L C &nbsp;&nbsp; C O L L E G E &nbsp;&nbsp; O F &nbsp;&nbsp; B U T U A N &nbsp;&nbsp; C I T Y</h4>
 		<h5>Butuan Information Technology Services Incorporated</h5>
 		<h5>PAYROLL MASTERLIST</h5>
 	</center>
 	<div class="col-sm-6">Payroll Date: <?= date('F d, Y', strtotime($record->pr_date)) ?></div>
 	<div class="col-sm-6">
 		<div class="pull-right">
 			Cut-off Period: <?= date('F d ', strtotime($record->pr_cut_off_from)) ?> - <?= date('F d, Y ', strtotime($record->pr_cut_off_to)) ?>
 		</div>
 	</div>
 	<table class="table table-bordered table-condensed">
 		<thead>
 			<tr>
 				<td>Name			</td>
 				<td>Status			</td>
 				<td>Basic Pay		</td>
 				<td>P. Time			</td>
 				<?php foreach ($plus_adjustments as $key => $value): ?>
 					<td><?= $key ?></td>
 				<?php endforeach ?>
 				<td>GROSS			</td>
 				<td>less:			</td>
 				<td>Absences:		</td>
 				<td>late</td>
 				<td>undertime</td>
 				<?php foreach ($deductions as $key => $value): ?>
 					<td><?= $value ?></td>
 				<?php endforeach ?>
 				<?php foreach ($loans as $key => $value): ?>
 					<td><?= $value ?></td>
 				<?php endforeach ?>
 				<?php foreach ($other_deductions as $key => $value): ?>
 					<td><?= $value ?></td>
 				<?php endforeach ?>

 				<td>SSS</td>
 				<td>Philhealth</td>
 				<td>HDMF</td>
 				<td>Wtax</td>
 				<?php foreach ($minus_adjustments as $key => $value): ?>
 					<td><?= $key ?></td>
 				<?php endforeach ?>
 				<td>Take Home Pay</td>
 			</tr>
 		</thead>
 		<tbody>
 			<?php 
 				foreach ($emp_proll_recs as $key => $value): 
 				$gross 	= 0;
 				$rate 	= $value->empInfo()->get_rates()->semi_monthly_rate;
 				$gross 	+= $rate;
 				$net 	= $gross;
 				$emp_adjustments = $value->adjustments();

 				$grossBasic += $rate;

 			?>
 				<tr>
 					<td> <?= $value->fullName('l, f m.') ?></td>
 					<td> <?= $value->employee_status ?></td>
 					<td> <?= number_format($rate,2); ?></td>
 					<td> </td>
 					<?php foreach ($emp_adjustments as $key2 => $value2): ?>
 						<?php if (isset($plus_adjustments[$value2->proll_adj_name])  && $value2->proll_adj_amt > 0 ): 
 							$plus_adjustments[$value2->proll_adj_name] += $value2->proll_adj_amt;
	 						$gross += isset($plus_adjustments[$value2->proll_adj_name]) ? number_format($value2->proll_adj_amt,2) : 0;
 						?>
							<td><?=  number_format($value2->proll_adj_amt,2)  ?></td>
 						<?php endif ?>
 					<?php endforeach ?>
 					<?php 
 						// $gross 			+= $value2;
 						$net 			= $gross;
 						$gross_gross 	+= $gross;
 					?>
 					<td><?= number_format($gross,2) ?></td>
 					<td></td>

 					<!-- late -->
 					<td>  <?= number_format($value->emp_proll_absent,2) ?> </td>
 					<?php 
 						$gross_absences += $value->emp_proll_absent;
 						$net -= $value->emp_proll_absent;
 					 ?>
					<td> <?= number_format($value->emp_proll_late_ded,2) ?> </td>
					<?php 
						$gross_late += $value->emp_proll_late_ded; 
						$net -= $value->emp_proll_late_ded;
					?>
					<!-- end late -->
					<!-- undertime -->
					<td> <?= number_format($value->emp_proll_ut_ded,2) ?> </td>
					<?php 
						$gross_ut += $value->emp_proll_ut_ded; 
						$net -= $value->emp_proll_ut_ded;
					?>
					<!-- end undertime -->


 					<?php if ($cap = $value->cash_advance_payments()): ?>
 						<?php foreach ($cap as $key2 => $value2): 
 							$net 	 	-= $value2->ca_payment_amt;
 							$gross_cap 	+= $value2->ca_payment_amt;
 						?>
 							<td><?= number_format($value2->ca_payment_amt,2) ?></td>
 						<?php endforeach ?>
 					<?php elseif(in_array( "Cash Advance",$deductions)): ?>
						<td>0.00</td>
 					<?php endif ?>
 					<?php foreach ($loans as $key2 => $value2): 
	 					$hasVal = false;
 					?>
 						<?php if ($lp = $value->loan_payments()): ?>
	 						<?php foreach ($lp as $key3 => $value3): 
	 							$net -= $value3->el_payment_amount;
								${"gross{$value3->emp_loan_type}"}  += $value3->el_payment_amount;

	 						?>
	 						<?php if ($value2 == $value3->emp_loan_type): 
	 							$hasVal = true;
	 						?>
	 							<td><?= number_format($value3->el_payment_amount,2) ?></td>
	 						<?php endif ?>
	 						<?php endforeach ?>
	 						<?php if (!$hasVal): ?>
	 							<td>0.00</td>
	 						<?php endif ?>
	 					<?php else: ?>
	 						<td>0.00</td>
	 					<?php endif ?>
 					<?php endforeach ?>

 					<?php foreach ($other_deductions as $key2 => $value2): 
	 					$hasVal = false;
 					?>
 						<?php if ($odp = $value->other_deduction_payments()): ?>
	 						<?php foreach ($odp as $key3 => $value3): 
	 							$net -= $value3->eod_payment_amount;
	 						?>
	 							<?php if ($value2 == $value3->other_ded_name ): 
	 								$hasVal = true;
	 								${"gross{$value3->other_ded_name}"} += $value3->eod_payment_amount;
	 							?>
		 							<td><?= number_format($value3->eod_payment_amount,2) ?></td>
	 							<?php endif ?>
	 						<?php endforeach ?>
	 						<?php if (!$hasVal): ?>
	 							<td>0.00</td>
	 						<?php endif ?>
	 					<?php else: ?>
	 						<td>0.00</td>
	 					<?php endif ?>
 					<?php endforeach ?>
	
					<!-- sss -->
					<td><?= number_format($value->emp_proll_sss,2) ?></td>
						<?php 
							$gross_sss += $value->emp_proll_sss;
							$net -= $value->emp_proll_sss;
					 	?>
					<!-- end sss -->
					<!-- philhealth -->
					<td>
						<?= number_format($value->emp_proll_philhealth,2) ?>
						<?php 
							$gross_philhealth += $value->emp_proll_philhealth;
							$net -= $value->emp_proll_philhealth;
						 ?>
					</td>
					<!-- end philhealth -->
					<!-- hdmf -->
					<td>
						<?= number_format($value->emp_proll_hdmf,2) ?>
						<?php 
							$gross_hdmf += $value->emp_proll_hdmf;
							$net -= $value->emp_proll_hdmf;
						 ?>
					</td>
					<!-- end hdmf -->
					<!-- wtax -->
					<td>
						<?= number_format($value->emp_proll_wtax,2) ?>
						<?php 
							$gross_wtax += $value->emp_proll_wtax;
							$net -= $value->emp_proll_wtax;
						 ?>
					</td>
					<!-- end wtax -->
					<?php foreach ($emp_adjustments as $key2 => $value2): ?>
 						<?php if (isset($minus_adjustments[$value2->proll_adj_name])  && $value2->proll_adj_amt < 0 ): 
 							$minus_adjustments[$value2->proll_adj_name] += $value2->proll_adj_amt;
	 						// $gross += isset($minus_adjustments[$value2->proll_adj_name]) ? number_format($value2->proll_adj_amt,2) : 0;
 						?>
							<td><?=  number_format(abs($value2->proll_adj_amt),2)  ?></td>
							<?php 
								$net += $value2->proll_adj_amt;
							 ?>							

 						<?php endif ?>
 					<?php endforeach ?>

 					<?php 
 						$gross_take_home += $net;
 					 ?>
 					
 					<td><?= number_format($net,2); ?></td>
 				</tr>
 			<?php endforeach ?>
 			<tr style="border:2px solid #000">
 				<td> <b>TOTAL</b> </td>
 				<td>  </td>
 				<td><b><?= number_format($grossBasic,2) ?></b></td>
 				<td></td>
 				<?php foreach ($plus_adjustments as $key => $value): ?>
	 				<td> <b><?= number_format($value,2) ?></b> </td>
 				<?php endforeach ?>
 				<td> <b><?= number_format($gross_gross,2) ?></b> </td>
 				<td></td>
 				<td><b><?= number_format($gross_absences,2) ?></b></td>
 				<td><b><?= number_format($gross_late,2) ?></b></td>
 				<td><b><?= number_format($gross_ut,2) ?></b></td>
 				<?php if ($cap): ?>
					<td> <b><?= number_format($gross_cap,2) ?></b></td>
 				<?php endif ?>
 				<?php foreach ($loans as $key => $value): ?>
 					<?php if ($lp): ?>
 						<?php foreach ($lp as $key3 => $value3): ?>
 						<?php if ($value == $value3->emp_loan_type): ?>
 							<td> <b><?= number_format(${"gross{$value3->emp_loan_type}"},2) ?></b> </td>
 						<?php endif ?>
 						<?php endforeach ?>
 					<?php endif ?>
 				<?php endforeach ?>
 				<?php foreach ($other_deductions as $key => $value): ?>
 					<td> <b> <?= number_format(${"gross{$value}"},2) ?> </b> </td>
 				<?php endforeach ?>
 				<td>
 					<?= number_format($gross_sss,2) ?>
 				</td>
 				<td>
 					<?= number_format($gross_philhealth,2) ?>
 				</td>
 				<td>
 					<?= number_format($gross_hdmf,2) ?>
 				</td>
 				<td>
 					<?= number_format($gross_wtax,2) ?>
 				</td>
 				<?php foreach ($minus_adjustments as $key => $value): ?>
	 				<td> <b><?= number_format(abs($value),2) ?></b> </td>
 				<?php endforeach ?>
 				<td> <b><?= number_format($gross_take_home,2) ?></b> </td>
 			</tr>
 		</tbody>
 	</table>
 </div>