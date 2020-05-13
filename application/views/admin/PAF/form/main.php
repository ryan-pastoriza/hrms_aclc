<style type="text/css">
	.paf_table, .paf_other_table {
		width: 100%;
		border-collapse: collapse;
	}
	.paf_table td, .paf_other_table td {
		border: 1px solid #CCC;
		padding: 3px;
	}
	.paf_other_table td{
		border-top: 0px;
	}
	textarea {
		width: 100%;
		resize: none;
	}
	input[type=text], input[type=date], input[type=number] {
		width: 100%;
	}
	.printable_show {
		display: none;
	}
	#header {
		width: 100%;
		border: 1px solid #CCC;
		border-bottom: 0px;
	}
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12">
			<table class="text-center printable_show" id="header">
				<tr>
					<td>
						<h4><b>ACLC COLLEGE OF BUTUAN</b></h4>
						<p>Franchised and Operated by Butuan Information Technology Services Inc.</p>
						<p>HDS Bldg., 999 J.C. Aquino Avenue, Butuan City 8600</p>
					</td>
				</tr>
			</table>
	<?= form_open(base_url('index.php/admin/personnel_action_form/add_paf'), 'id=form'); ?>
			<input type="text" name="act_be_taken" hidden>
			<input type="text" name="emp_rate" hidden>
			<table class="paf_table">
				<tr>
					<td colspan="4"><h4 class="text-center"><b>PERSONNEL ACTION FORM</b></h4></td>
				</tr>
				<tr>
					<td>DATE</td>
					<td ><input type="date" class="form-control" name="date_filed" value="<?= isset($date_filed) ? $date_filed : ''; ?>" required></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>NAME</td>
					<td>
						<input type="text" id="searchEmp" value="<?= isset($name) ? $name : ''; ?>">
						<input type="hidden" name="employee_id">
					</td>
					<td>POSITION</td>
					<td><input type="text" class="form-control" name="position" style="border: 0px;" value="<?= isset($position) ? $position : ''; ?>" readonly></td>
				</tr>
				<tr>
					<td>DEPARTMENT</td>
					<td><input type="text" class="form-control"  name="department" style="border: 0px;" value="<?= isset($department) ? $department : ''; ?>" readonly></td>
					<td>DATE HIRED</td>
					<td><input type="text" class="form-control" name="date_hired" style="border: 0px;" value="<?= isset($hired_date) ? $hired_date : ''; ?>" readonly></td>
				</tr>
			</table>
			<table class="paf_other_table">
				<tr>
					<td colspan="4">EMPLOYMENT</td>
				</tr>
				<tr>
					<td style="width: 33%; text-indent: 10px;"><input type="radio" name="employment" value="Probationary" readonly <?= isset($employment) ? $employment === "Probationary" ? 'checked' : '' : ''; ?> > Probationary</td>
					<td style="width: 33%; text-indent: 10px;"><input type="radio" name="employment" value="Regular" readonly <?= isset($employment) ? $employment === "Regular" ? 'checked' : '' : ''; ?> > Regular</td>
					<td style="width: 33%; text-indent: 10px;"><input type="radio" name="employment" value="Contractual" readonly <?= isset($employment) ? $employment === "Contractual" ? 'checked' : '' : ''; ?> > Contractual</td>
				</tr>
				<tr>
					<td colspan="3"><h4><b>ACTION TO BE TAKEN</b></h4></td>
				</tr>
			</table>
			<table class="paf_other_table">
				
				<tr>
					<td style="width: 50%; text-indent: 10px;"><input id="regular" type="checkbox" name="action" value="Regularization" required <?= isset($action) ? $action === "Regularization" ? 'checked' : '' : ''; ?> > Regularization</td>
					<td style="width: 50%; text-indent: 10px;"><input type="checkbox" name="action" value="Salary Increase" <?= isset($action) ? $action === "Salary Increase" ? 'checked' : '' : ''; ?>> Salary Increase</td>
				</tr>
				<tr>
					<td style="width: 50%; text-indent: 10px;"><input type="checkbox" name="action" value="Promotion" <?= isset($action) ? $action === "Promotion" ? 'checked' : '' : ''; ?>> Promotion</td>
					<td style="width: 50%; text-indent: 10px;"><input type="checkbox" name="action" others-checkbox value="Others" <?= isset($action) ? $action !== "Regularization" && $action !== "Salary Increase" && $action !== "Promotion" && $action !== "Transfer" ? 'checked' : '' : ''; ?> > 
							Others
						<span id="others">
							, Specify: <input type="text" style="width: 50%;" name="others" value="<?= isset($action) ? $action !== "Regularization" && $action !== "Salary Increase" && $action !== "Promotion" && $action !== "Transfer" ? $action : '' : ''; ?>">
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-indent: 10px;"><input type="checkbox" name="action" value="Transfer" <?= isset($action) ? $action === "Transfer" ? 'checked' : '' : ''; ?>> Transfer</td>
				</tr>
			</table>
			<table class="paf_other_table">
				<tr>
					<td>Effectivity Date</td>
					<td colspan="4">
						<div class="row">
							<div class="col-sm-6">
								<input type="date" class="form-control" name="effectivity_date" value="<?= isset($effectivity_date) ? $effectivity_date : ''; ?>" required>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="text-center">FROM / CURRENT</td>
					<td class="text-center" >TO</td>
					<td></td>
				</tr>
				<tbody class="table-body" id="actions-taken">
					<tr id="default_row" class="printable_hide">
						<td>
							<select class="form-control" style="width: 100%;" id="select_action" name="select_action">
								<option value="0">-- SELECT --</option>
								<option value="1">EMPLOYMENT STATUS</option>
								<option value="2">DEPARTMENT</option>
								<!-- <option value="4">COMPANY</option> -->
								<!-- <option value="5">BRANCH/WORK AREA</option> -->
								<option value="6">BASIC SALARY</option>
								<option value="7">TRANSPORTATION</option>
								<option value="8">MEAL ALLOWANCE</option>
								<option value="9">OTHERS - COLA</option>
							</select>
						</td>
						<td><input type="text" id="from" name="from" class="form-control"></td>
						<td>
							<select class="form-control" style="width: 100%;" name="toDept" select="selected" id="dropDept">
							<?php foreach($allDept as $key => $value): ?>
								<option value="<?= $value->department_id ?>"><?= ucwords($value->department_name) ?></option>
							<?php endforeach; ?>
							</select>
							<select id="to-emp-stat" class="form-control hidden" name="toEmpStat">
								<option>Probationary</option>
								<option>Contractual</option>
								<option>Regular</option>
							</select>

							<input type="text" id="to" name="to" class="form-control">
						</td>
						<td>
							<button type="button" id='add-action-btn' class="btn btn-primary"> <i class="fa fa-plus"></i> </button>
						</td>
						<!-- <td class="text-center printable_hide"><a onclick="add_row(this)"><span class="fa fa-plus"></span></a></td> -->
					</tr>
					<tr class="printable_show">
						<td style="width: 33%;">EMPLOYMENT STATUS</td>
						<td style="width: 33%;"><?= isset($empl_stat_from) ? $empl_stat_from : ''; ?></td>
						<td style="width: 33%;"><?= isset($empl_stat_to) ? $empl_stat_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td style="width: 33%;">BASIC SALARY</td>
						<td style="width: 33%;"><?= isset($basic_sal_from) ? $basic_sal_from : ''; ?></td>
						<td style="width: 33%;"><?= isset($basic_sal_to) ? $basic_sal_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>DEPARTMENT</td>
						<td><?= isset($dep_from) ? $dep_from : ''; ?></td>
						<td><?= isset($dep_to) ? $dep_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>DIVISION</td>
						<td><?= isset($div_from) ? $div_from : ''; ?></td>
						<td><?= isset($div_to) ? $div_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>COMPANY</td>
						<td><?= isset($comp_from) ? $comp_from : ''; ?></td>
						<td><?= isset($comp_to) ? $comp_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>BRANCH/WORK AREA</td>
						<td><?= isset($branch_from) ? $branch_from : ''; ?></td>
						<td><?= isset($branch_to) ? $branch_to : ''; ?></td>
					</tr>
				</tbody>
			</table>
		<!-- 	<table class="paf_other_table">
				<tr>
					<td colspan="4"><h4><b>PAYROLL PURPOSES</b></h4></td>
				</tr>
				<tr>
					<td></td>
					<td class="text-center">FROM / CURRENT</td>
					<td class="text-center" colspan="2">TO</td> 
				</tr>
				<tbody class="table-body">
					<tr id="default_row_purpose" class="printable_hide">
						<td>
							<select class="form-control" style="width: 100%;" id="select_purpose" name="select_purpose">
								<option value="0">-- SELECT --</option>
								<option value="1">BASIC SALARY</option>
								<option value="2">TRANSPORTATION</option>
								<option value="3">MEAL ALLOWANCE</option>
								<option value="4">OTHERS - COLA</option>
							</select>
						</td>
						<td><input type="text" class="form-control" id="from_purpose" name="from_purpose"></td>
						<td><input type="text" class="form-control" id="to_purpose" name="to_purpose"></td>
						<td class="text-center printable_hide"><a onclick="add_row_purpose(this)"><span class="fa fa-plus"></span></a></td> 
					</tr>
					<tr class="printable_show">
						<td style="width: 33%;">BASIC SALARY</td>
						<td style="width: 33%;"><?= isset($basic_sal_from) ? $basic_sal_from : ''; ?></td>
						<td style="width: 33%;"><?= isset($basic_sal_to) ? $basic_sal_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>TRANSPORTATION</td>
						<td><?= isset($trans_from) ? $trans_from : ''; ?></td>
						<td><?= isset($trans_to) ? $trans_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>MEAL ALLOWANCE</td>
						<td><?= isset($meal_from) ? $meal_from : ''; ?></td>
						<td><?= isset($meal_to) ? $meal_to : ''; ?></td>
					</tr>
					<tr class="printable_show">
						<td>OTHERS - COLA</td>
						<td><?= isset($others_from) ? $others_from : ''; ?></td>
						<td><?= isset($others_to) ? $others_to : ''; ?></td>
					</tr>
				</tbody>
			</table> -->
			<table class="paf_other_table">
				<tr>
					<td class="text-right">SSS NO.</td>
					<td><input type="text" class='form-control' name="sss" value="<?= isset($sss_no) ? $sss_no : '' ?>"></td>
					<td class="text-right">TIN NO.</td>
					<td><input type="text" class='form-control' name="tin" value="<?= isset($tin_no) ? $tin_no : '' ?> "></td>
				</tr>
				<tr>
					<td class="text-right">PAG-IBIG NO.</td>
					<td><input type="text" class='form-control' name="pagibig" value="<?= isset($pagibig_no) ? $pagibig_no : '' ?> "></td>
					<td class="text-right">PHIC NO.</td>
					<td><input type="text" class='form-control' name="phic" value="<?= isset($phic_no) ? $phic_no : '' ?> "></td>
				</tr>
				<tr>
					<td class="text-right">TAX EXEMPTION</td>
					<td><input type="text" class='form-control' name="tax_exemption" value="<?= isset($tax) ? $tax : '' ?> "></td>
					<td class="text-right">ATM ACCOUNT NO.</td>
					<td><input type="text" class='form-control' name="atm_acct_no"  value="<?= isset($atm_no) ? $atm_no : ''?>" ></td>
				</tr>
				<tr>
					<td colspan="4"><h4><b>JUSTIFICATION / REMARKS</b></h4></td>
				</tr>
			</table>
			<table class="paf_other_table">
				<tr>
					<td>
						<textarea rows="3" maxlength="255" name="justification"><?= isset($justification) ? $justification : ''; ?></textarea>
					</td>
				</tr>
			</table>
			<table class="paf_other_table text-center printable_show">
				<tr>
					<td>Requested by</td>
					<td>Reviewed by</td>
					<td colspan="2">Approved by</td>
				</tr>
				<tr>
					<td style="height: 70px;"></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td style="width: 25%;">Immediate Head</td>
					<td style="width: 25%;">Human Resources</td>
					<td style="width: 25%;">School Director</td>
					<td style="width: 25%;">Management Consultant</td>
				</tr>
			</table>
		</div>
	</div>
	<br>
	<button class="btn btn-primary pull-right printable_hide" id="btnSave"><span class="fa fa-save"></span> Save</button>
	</form>
</div>

<?php 
	if(!isset($name)) {
		$this->load->view("admin/PAF/form/jscript"); 
	}
?>