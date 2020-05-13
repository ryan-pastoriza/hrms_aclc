
<?php
/**
 * @Author: Gian
 * @Date:   2017-06-09 13:49:00
 * @Last Modified by:   Gian
 * @Last Modified time: 2017-06-17 13:56:46
 */
$forTheMonthOf = "";
foreach($monthOf as  $key){
	$forTheMonthOf = $key;
}

?>
<style>
	#printBTN:hover{
		cursor: pointer;
	}
	#closeBTN:hover{
		cursor: pointer;
	}
	@media print{
		#printBTN{
			display: none;
		}
		#closeBTN{
			display: none;
		}
	}
</style>
<script src="<?= asset_url('plugins/jQuery/jQuery-2.2.0.min.js') ?>"></script>
<script>
	$(function(){
		$(document).on('click','#printBTN',function(e){
			window.print()
			e.preventDefault()
		})
		$(document).on('click','#closeBTN',function(e){
			window.close()
			e.preventDefault()
		})
	});
</script>
<?php if(strtolower($loan_type) == "sss"):?>
<style>

	#sss_print_form{
		margin-left:20px;
		margin-top:15px;
		
	}

	#header_print > p{
		font-size:18.5px;
		font-family: "Times New Romans";
		font-weight: bold;
	}
	#payment_header > p{
		margin-left:85px;
		font-family: "Arial";
		font-size:15.5px;
		font-weight: bold;
	}

	#person_payment{
		font-family: "Arial";
		margin-left:150px;
	}

	#printFooter{
		margin-top:100px;
	}




	/* pagibig print form*/
</style>

<div id="sss_print_form">
	
	<div id="header_print">
		<p>BUTUAN INFORMATION TECHNOLOGY SERVICES INC.
			<br>999 HDS BLDG. J.C AQUINO AVENUE
			<br>BUTAN CITY
		</p>
	</div>

		<div id="payment_header">
			<p>
				PAYMENT OF SSS LOAN FOR THE MONTH OF <?= strtoupper(date("F Y")) ?>
			</p>
		</div>

		<div id="person_payment">
			<table>
				<?php $totalPayment = "";?>
				<?php foreach($loans as $key => $value):
					$totalPayment += $value->el_payment_amount;
				?>
				<tr>
					<td style="font-size:13px;"><?= ucwords($value->employee_fname) . " ". ucwords($value->employee_lname); ?></td>
					<td style="width:50px;"></td>
					<td style="font-size:13px;">&#8369; <?= number_format($value->el_payment_amount,2) ?></td>
				</tr>
				<?php endforeach;?>
				<tr>
					<td style="text-align: right;font-size:13px;"><b>Total<b></td>
					<td></td>
					<td style="font-size:13px;"><b>&#8369; <?= number_format($totalPayment,2); ?></b></td>
				</tr>
				<tr>
					<td colspan="3">
						<table style="width:100%;">
							<tr>
								<td style="width:50px;"></td>
								<td style="border:1.2px solid black;border-left:none;border-right:none;"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</div>
		<div id="printFooter">
			<div id="preparedBy" style="font-size:13px;">
				Prepared by :
			</div>

			<table style="margin-top:20px;font-size:13px;">
				<tr>
					<td style="width:200px">Michelle E. Yamit</td>
					<td style="width:250px; text-align: center;">Noted by :</td>
					<td style="text-align: center;">Approved by :</td>
				</tr>
				<tr>
					<td>HR Staff</td>
					<td style="text-align: center;"><u>JOSE ROBERTO S. LASTIMOSO</u></td>
					<td style="text-align: center;"><u>ALAN L. ATEGA</u></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: center;">SCHOOL ADMINISTRATOR</td>
					<td style="text-align: center;">SCHOOL DIRECTOR</td>
				</tr>
			</table>
		</div>

</div>
<?php endif; ?>
<?php if(strtolower($loan_type) == "pagibig"):?>
<style>

	#pagibig_header > table{
		font-size:11px;
		font-weight: bold;
	}
	#pagibig_header > table > tr td{

	}
	#pagibig_payments > #payment_table{
		border:1px solid black;
	}
	#pagibig_payments > #payment_table > thead > tr > th{
		font-size:11px;
		text-align: center;
		border-right:none;
		border-left:none;
	}
	#pagibig_payments > #payment_table > tbody > tr > td{
		border-top:none;
		font-size:11px;
		padding-left:2px;
	}
</style>
<div id="pagibig_print_form" style="margin-left:7px;margin-top:7px;">
	<div id="pagibig_header">
		<table>
			<tr>
				<td>Employer ID : </td>
				<td>800166483971</td>
			</tr>
			<tr>
				<td>Employer Name : </td>
				<td>BUTUAN INFORMATION TECHNOLOGY SERVICES INC.</td>
			</tr>
			<tr>
				<td>Address : </td>
				<td>HDS BLDG. J.C AQUINO AVENUE BUTUAN CITY</td>
			</tr>
			<tr>
				<td>Coverage : </td>
				<td>FOR THE MONTH OF <?= strtoupper(date("F Y",strtotime($forTheMonthOf)))?></td>
			</tr>
		</table>
	</div>
	<div id="pagibig_payments">
		<table cellpadding="0" cellspacing="0" id="payment_table">
			<thead>
				<tr>
					<th style="border-right:1px solid black;width:120px;">Pag-IBIG ID / RTN</th>
					<th style="border-right:1px solid black;width:100px;">LAST NAME</th>
					<th style="border-right:1px solid black;width:100px;">FIRST NAME</th>
					<th style="border-right:1px solid black;width:100px;">NAME EXTENSION</th>
					<th style="border-right:1px solid black;width:100px;">MIDDLE NAME</th>
					<th style="border-right:1px solid black;width:65px;">PERCOV</th>
					<th style="border-right:1px solid black;width:80px;">MPL</th>
					<th style="border-right:1px solid black;width:80px;">CALAMITY</th>
					<th style="border-right:1px solid black;width:70px;">HOUSING</th>
					<th style="border-right:1px solid black;width:50px;">HL ID</th>
					<th style="width:80px;">REMARKS</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$totalMPL = "";
				foreach($loans as $key => $value):
						$totalMPL += $value->el_payment_amount;
				?>
					<tr>
						<td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"><?= $value->pagibig_no != "" ? $value->pagibig_no : $value->eaf_pagibig ?></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"><?= strtoupper($value->employee_lname); ?></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"><?= strtoupper($value->employee_fname); ?></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"><?= strtoupper($value->employee_ext); ?></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"><?= strtoupper($value->employee_mname); ?></td>
						<td style="text-align: center;border-right:1px solid black;border-top:1px solid black;"><b><?= date("Ym",strtotime($value->el_payment_date)) ?></b></td>
						<td style="text-align:right;padding-right:5px;border-right:1px solid black;border-top:1px solid black;"><?= number_format($value->el_payment_amount,2) ?></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"></td>
						<td style="border-right:1px solid black;border-top:1px solid black;"></td>
						<td style="border-top:1px solid black;"></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<table cellpadding="0" cellspacing="0" style="font-size:11px;margin-top:10px;">
			<thead>
				<tr>
					<th style="width:120px;text-align:left;">Total Remittance</th>
					<th style="width:100px;"></th>
					<th style="width:100px;"></th>
					<th style="width:100px;"></th>
					<th style="width:100px;"></th>
					<th style="width:65px;"></th>
					<th style="width:80px;text-align:right;"><?= number_format($totalMPL,2); ?></th>
					<th style="width:80px;"></th>
					<th style="width:70px;"></th>
					<th style="width:50px;"></th>
				</tr>
			</thead>
			<tbobdy>
					<th style="width:120px;text-align:left;"></th>
					<th style="width:100px;"></th>
					<th style="width:100px;"></th>
					<th style="width:100px;"></th>
					<th style="width:100px;"></th>
					<th style="width:65px;"></th>
					<th style="width:80px;text-align:right;"></th>
					<th style="width:80px;text-align:right;"> <?= number_format($totalMPL,2); ?></th>
					<th style="width:70px;"></th>
					<th style="width:50px;"></th>
			</tbobdy>
		</table>
	</div>

	<div id="pagibig_footer" style="margin-top:50px;">
		<table style="font-size:12px !important;">
			<tr>
				<td style="width:215px;">Prepared By :</td>
				<td style="width:300px;">Noted By :</td>
				<td style="width:300px;">Noted By :</td>
			</tr>
			<tr>
				<td colspan="3"><span> </span></td>
			</tr>
			<tr>

				<td>MICHELLE E. YAMIT</td>
				<td>JOSE ROBERTO S. LASTIMOSO</td>
				<td>ALAN L. ATEGA</td>
			</tr>
			<tr>
				<td>HR STAFF</td>
				<td>SCHOOL ADMINISTRATOR</td>
				<td>SCHOOL DIRECTOR</td>
			</tr>
		</table>
	</div>
</div>
<?php endif;?>
<button id="printBTN" style="background-color:blue;border:none;width:50px;height:30px;color:#FFF;" href="#">Print</button>
<button id="closeBTN" style="background-color:#CCC;border:none;width:50px;height:30px;color:#FFF;" href="#">Close</button>