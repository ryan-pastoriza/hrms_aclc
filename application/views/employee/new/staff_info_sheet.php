<?php
/**
 * @Author: gian
 * @Date:   2016-04-04 09:29:25
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-14 08:45:00
 */

?>
<div id="printable_sis">
		<div style="border:1px solid black;">
			<center>
              	<h4 style="line-height: 10px"><b>ACLC COLLEGE OF BUTUAN</b></h4>
              	<p>
                	Franchised and Operated by Butuan Information Technology Services, Inc.<br />
                	HDS Bldg., 999 J.C. Aquino Avenue, Butuan City 8600
              	</p>
            </center>
		</div>
		<div>
			<center>
				<h3><b>STAFF INFORMATION SHEET</b></h3>
			</center>
		</div>
		<div style="border: 1px solid black; padding:3px 3px 3px 3px;">
			This sheet is for employee's records &amp; updates purposes. Kindly fill-in all inforamtion needed and just put <b>N/A</b> to any field that is already irrelevant to you. Immediately submit to HRD after completion.
		</div>

		<div style="border:1px solid black;margin-top:2px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>PERSONAL INFORMATION</b>
			</span>
			<table class="table" width="100%">
				<tr>
					<td>
						<table style="width: 100%;">
							<tr>
								<td>Last Name:</td>
								<td>
									<input type="text" style="width: 100%;" name="employee_lname" value="<?= isset($sis_emp->employee_lname) ? $sis_emp->employee_lname : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 100%;">
							<tr>
								<td>First Name:</td>
								<td>
									<input type="text" style="width: 100%;" name="employee_fname" value="<?= isset($sis_emp->employee_fname) ? $sis_emp->employee_fname : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 100%;">
							<tr>
								<td>Middle Name:</td>
								<td>
									<input type="text" style="width: 100%;" name="employee_mname" value="<?= isset($sis_emp->employee_mname) ? $sis_emp->employee_mname : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td colspan="3">
						<table style="width: 100%">
							<tr>
								<td width="12%">Blood Type:</td>
								<td width="38%">
									<input type="text" style="width: 99%;" name="employee_blood_type" value="<?= isset($sis_emp->employee_blood_type) ? $sis_emp->employee_blood_type : 'No data' ?>">
								</td>

								<td width="12%"> Civil Status:</td>
								<td width="38%">
									<input type="text" style="width: 99%;" name="employee_status" value="<?= isset($sis_emp->employee_status) ? $sis_emp->employee_status : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
				</tr>


				<tr>
					<td colspan="3">
						<table style="width: 100%">
							<tr>
								<td width="12%"> Date of Birth:</td>
								<td width="38%">
									<input type="date" style="width: 99%;height: 26px;" name="employee_bday" value="<?= isset($sis_emp->employee_bday) ? $sis_emp->employee_bday : 'No data' ?>">
								</td>
								<td width="12%"> Gender:</td>
								<td width="38%">
									<input type="text" value="<?= isset($sis_emp->employee_gender) ? $sis_emp->employee_gender : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td colspan="3">
						<table style="width: 100%;">
							<tr>
								<td width="12%">Father's Name:</td>
								<td width="38%">
									<input type="text" style="width: 99%;" name="employee_father" value="<?= isset($sis_emp->employee_father) ? $sis_emp->employee_father : 'No data' ?>">
								</td>
								<td width="15%">Mother's Maiden Name:</td>
								<td width="35%">
									<input type="text" style="width: 99%;" name="employee_mother" value="<?= isset($sis_emp->employee_mother) ? $sis_emp->employee_mother : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td colspan="3">
						<table style="width:100%;">
							<tr>
								<td>Telephone No.:</td>
								<td><input type="text" style="width: 99%;" name="employee_telephone" value="<?= isset($sis_emp->employee_telephone) ? $sis_emp->employee_telephone : 'No data' ?>"></td>
								<td>Mobile No.:</td>
								<td><input type="text" style="width: 99%;" name="employee_mobile" value="<?= isset($sis_emp->employee_mobile) ? $sis_emp->employee_mobile : 'No data' ?>"></td>
								<td>Religion:</td>
								<td><input type="text" style="width: 99%;" name="employee_religion" value="<?= isset($sis_emp->employee_religion) ? $sis_emp->employee_religion : 'No data' ?>"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<table style="width: 100%;">
							<tr>
								<td width="15%">
									Current Address:
								</td>
								<td colspan="2">
									<input type="text" style="width: 100%;" name="employee_current_address" value="<?= isset($sis_emp->employee_current_address) ? $sis_emp->employee_current_address : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
					
				</tr>
				<tr>
					<td colspan="3">
						<table style="width:100%;">
							<tr>
								<td width="15%">
									Permanent Address:
								</td>
								<td colspan="2">
									<input type="text" style="width: 100%;" name="employee_permanent_address" value="<?= isset($sis_emp->employee_permanent_address) ? $sis_emp->employee_permanent_address : 'No data' ?>">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>


		<div style="border:1px solid black;margin-top:2px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>SPOUSE</b>
			</span>
			<div id="spouse_list">
		
			</div>
			<div id="spouse_div" class="printable_hide">
				<div id="spouse_content">
					<div id="bodySpouse"></div>
					<?php
						foreach ($sis_spouse as $key => $value) {
					?>
					<table class="table" width="100%">
						<tr>
							<td colspan="3">
								<table style="width: 100%;">
									<tr>
										<td width="15%">Name of Spouse:</td>
										<td>
											<input type="text" style="width: 100%;" name="spouse_name[]" value="<?= isset($value->spouse_name) ? $value->spouse_name : 'No data' ?>">
										</td>
										<td width="13%">Age:</td>
										<td>
											<input type="text" style="width: 100%;" id="spouse_age" value="<?= isset($value->spouse_age) ? $value->spouse_age : 'No data' ?>"> 
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<table style="width: 100%;">
									<tr>
										<td width="15%;">Date of Birth:</td>
										<td>
											<input type="text" style="width: 100%;" id="spouse_birth_date" name="spouse_birth_date[]" value="<?= isset($value->spouse_birth_date) ? $value->spouse_birth_date : 'No data' ?>">
										</td>
										<td style="padding-left: 5px;" width="15%">Date of Marriage:</td>
										<td>
											<input type="text" style="width: 100%;height: 26px;" name="spouse_date_of_marriage[]" value="<?= isset($value->spouse_date_of_marriage) ? $value->spouse_date_of_marriage : 'No data' ?>">
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<table style="width:100%;">
									<tr>
										<td width="15%">Occupation:</td>
										<td>
											<input type="text" style="width: 100%;" name="spouse_occupation[]" value="<?= isset($value->spouse_occupation) ? $value->spouse_occupation : 'No data' ?>">
										</td>
										<td style="padding-left:5px;" width="15%">Employer:</td>
										<td>
											<input type="text" style="width: 100%;" name="spouse_employer[]" value="<?= isset($value->spouse_employer) ? $value->spouse_employer : 'No data' ?>">
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<table style="width: 100%;">
									<tr>
										<td width="15%">Employer's Address:</td>
										<td colspan="2">
											<input type="text" style="width: 100%;" name="spouse_employer_address[]" value="<?= isset($value->spouse_employer_address) ? $value->spouse_employer_address : 'No data' ?>">
										</td>
									</tr>
								</table>
							</td>
							<td>
							</td>
						</tr>
					</table>

					<?php
						}
					?>
				</div>
			</div>
		</div>
		
		<div style="border:1px solid black;margin-top:2px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>DEPENDENTS</b>
			</span>

			<div id="dep_div" class="printable_hide">
				<div id="dep_content">
					<table class="table" width="100%">
						<tr>
							<td colspan="3">
								<table style="width:100%;" class="table">
									<thead>
										<tr>
											<td>Name of Dependents</td>
											<td>Date of Birth</td>
											<td>Age</td>
											<td>Relationship</td>
											<td>Dependent</td>
										</tr>
									</thead>
									<tbody id="bodyDependent">
										<?php
											foreach ($sis_dependents as $key => $value) {
										?>
										<tr>
											<td width="40%">
												<input type="text" style="width: 99%;" name="emp_dependent_name[]" value="<?= isset($value->emp_dependent_name) ? $value->emp_dependent_name : 'No data' ?>">
											</td>
											<td width="20%">
												<input type="text" style="width: 99%;" id="dependent_birthdate" name="emp_dependent_birthdate[]" value="<?= isset($value->emp_dependent_birthdate) ? $value->emp_dependent_birthdate : 'No data' ?>">
											</td>
											<td width="10%">
												<input type="text" style="width: 99%;" id="dependent_age" readonly value="<?= isset($value->dependent_age) ? $value->dependent_age : 'No data' ?>">
											</td>
											<td width="20%">
												<input type="text" style="width: 99%;" name="emp_dependent_relationship[]" value="<?= isset($value->emp_dependent_relationship) ? $value->emp_dependent_relationship : 'No data' ?>">
											</td>
											<td width="10%">
												<input type="text" style="width: 99%" class="dependency text-center" value="<?php if(isset($value->emp_dependent_dependency)){if($value->emp_dependent_dependency == 1 ){echo "Yes";}else{echo "No"; } } ?>">
											</td>
											<td>
											</td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div style="border:1px solid black;margin-top:3px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>EDUCATIONAL BACKGROUND</b>
			</span>
			<table class="table" width="100%">
				<tr>
					<td>
							<div id="educ1_div" class="printable_hide">
								<div id="educ1_content">

									<!-- <table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="19%" style="text-align: center;">ATTAINMENT</td>
												<td width="60%" style="text-align: center;">NAME OF SCHOOL</td>
												<td width="19%" style="text-align: center;">YEAR GRADUATED</td>
											</tr>
										</thead>
										<tbody id="bodyEducationalBackground">
										<?php
											foreach ($sis_education as $key => $value) {

										?>
											<tr>
												<td>
													<input type="text" style="text-align:center;" value="<?= isset($value->ee_attainment) ? $value->ee_attainment : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ee_school_name[]" value="<?= isset($value->ee_school_name) ? $value->ee_school_name : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ee_year_graduated[]" value="<?= isset($value->ee_year_graduated) ? $value->ee_year_graduated : 'No data' ?>">
												</td> 
											</tr>
										<?php
											}
										?>
										</tbody>
									</table> -->

								</div>
							</div>
						</div>

					</td>
				</tr>
				<tr>
					<td>
							<div id="educ2_div" class="printable_hide">
								<div id="educ2_content">

									<table style="width: 100%;" class="table">
										<thead>
											<tr>
												<td style="text-align: center;" width="12%">ATTAINMENT</td>
												<td style="text-align: center;" width="13%">COURSE TAKEN</td>
												<td style="text-align: center;">NAME OF SCHOOL</td>
												<td style="text-align: center;" width="10%">UNITS EARNED</td>
												<td style="text-align: center;" width="20%">ONGOING NO. OF UNITS TAKEN</td>
												<td style="text-align: center;" width="10%">YEAR GRADUATED</td>
												<td width="1%">&nbsp;</td>
											</tr>
										</thead>
										<tbody id="bodyEducationalBackground1">
											<?php
												foreach ($sis_education2 as $key => $value) {
											?>
											<tr>
												<td>
													<input type="text" style="text-align:center;" value="<?= isset($value->ee_attainment) ? $value->ee_attainment : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ee_course_taken[]"  value="<?= isset($value->ee_course_taken) ? $value->ee_course_taken : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ee_school_name[]"  value="<?= isset($value->ee_school_name) ? $value->ee_school_name : 'No data' ?>">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;text-align:center;" name="ee_units_earned[]"  value="<?= isset($value->ee_units_earned) ? $value->ee_units_earned : 'No data' ?>">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;text-align:center;" name="ee_ongoing_units[]"  value="<?= isset($value->ee_ongoing_units) ? $value->ee_ongoing_units : 'No data' ?>">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;text-align:center;" name="ee_year_graduated[]"  value="<?= isset($value->ee_year_graduated) ? $value->ee_year_graduated : 'No data' ?>">
												</td>
												<td>
												</td>
											</tr>
											<?php
												}
											?>
										</tbody>
									</table>

								</div>
							</div>
						</div>


					</td>
				</tr>
			</table>
		</div>

		<div style="border:1px solid black;margin-top:3px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>CAREER / PROFESSIONAL CREDENTIALS</b>
			</span>
			
			<table class="table" width="100%">
				<tr>
					<td>ELIGIBILITY (You may also indicate all your TESDA certificates here)
						<div id="eli_list">
							
						</div>
							<div id="eli_div" class="printable_hide">
								<div id="eli_content">

									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="50%">
													<center>
														Program / Module
													</center>
												</td>
												<td width="16%">
													<center>
														Certificate Level
													</center>
												</td>
												<td width="16%">
													<center>
														Status
													</center>
												</td>
												<td width="16%">
													<center>
														Certificate Expiration Date
													</center>
												</td>
												<td width="2%"></td>
											</tr>
										</thead>

										<tbody id="bodyEligibility">
											<?php
												foreach ($sis_eligibility as $key => $value) {

											?>	
											<tr>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="emp_el_program[]" value="<?= isset($value->emp_el_program) ? $value->emp_el_program : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="emp_el_certificate_level[]" value="<?= isset($value->emp_el_certificate_level) ? $value->emp_el_certificate_level : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="emp_el_status[]" value="<?= isset($value->emp_el_status) ? $value->emp_el_status : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;height: 26px;text-align:center;" name="emp_el_certificate_exp[]" value="<?= isset($value->emp_el_certificate_exp) ? $value->emp_el_certificate_exp : 'No data' ?>">
												</td>
												<td>
												</td>
											</tr>
											<?php
												}
											?>
										</tbody>

									</table>

								</div>
							</div>
						</div>

					</td>
				</tr>

				<tr>
					<td>PROFESSIONAL AFFILATION/S
							<div id="aff_div" class="printable_hide">
								<div id="aff_content">
									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="50%">
													<center>
														Club/Organization's Name
													</center>
												</td>
												<td width="16%">
													<center>
														Membership Type
													</center>
												</td>
												<td width="16%">
													<center>
														Status
													</center>
												</td>
												<td width="16%">
													<center>
														Membership Expiration Date
													</center>
												</td>
												<td width="2%"></td>
											</tr>
										</thead>

										<tbody id="bodyProfessionalAffilation">
											<?php
												foreach ($sis_affilation as $key => $value) {
											?>
											<tr>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="emp_aff_org_name[]" value="<?= isset($value->emp_aff_org_name) ? $value->emp_aff_org_name : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="emp_aff_membership_type[]" value="<?= isset($value->emp_aff_membership_type) ? $value->emp_aff_membership_type : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="emp_aff_status[]" value="<?= isset($value->emp_aff_status) ? $value->emp_aff_status : 'No data' ?>">
												</td>
												<td>
													<input type="date" style="width: 99%;height: 26px;text-align:center;" name="emp_aff_membership_exp[]" value="<?= isset($value->emp_aff_membership_exp) ? $value->emp_aff_membership_exp : 'No data' ?>">
												</td>
												<td>
												</td>
											</tr>
											<?php
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</td>
				</tr>

				<tr>
					<td>SEMINARS / TRAININGS ATTENDED
							<div id="ets_div" class="printable_hide">
								<div id="ets_content">
									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="30%">
													<center>
														Name/Title of Training/ Seminar
													</center>
												</td>
												<td width="19%">
													<center>
														Inclusive Dates
													</center>
												</td>
												<td width="30%">
													<center>
														Venue
													</center>
												</td>
												<td width="19%">
													<center>
														Training Provider
													</center>
												</td>
												<td width="2%"></td>
											</tr>
										</thead>

										<tbody id="bodySeminarTraining">
											<?php
												foreach ($sis_training as $key => $value) {
											?>
											<tr>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ets_title[]" value="<?= isset($value->ets_title) ? $value->ets_title : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;height: 26px;text-align:center;" name="ets_date[]" value="<?= isset($value->ets_date) ? $value->ets_date : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ets_venue[]" value="<?= isset($value->ets_venue) ? $value->ets_venue : 'No data' ?>">
												</td>
												<td>
													<input type="text" style="width: 99%;text-align:center;" name="ets_provider[]" value="<?= isset($value->ets_provider) ? $value->ets_provider : 'No data' ?>">
												</td>
												<td>
												</td>
											</tr>
											<?php
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div style="border:1px solid black;margin-top:3px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>CONTACT PERSON IN CASE OF EMERGENCY</b>
			</span>
			<table class="table" width="100%">
				<tr>
					<td width="10%">Name:</td>
					<td width="50%">
						<input type="text" style="width: 99%;" name="employee_contact_person_name" value="<?= isset($sis_emp->employee_contact_person_name) ? $sis_emp->employee_contact_person_name : 'No data' ?>">
					</td>
					<td>Telephone No.:</td>
					<td>
						<input type="text" style="width: 99%;" name="employee_contact_person_telephone" value="<?= isset($sis_emp->employee_contact_person_telephone) ? $sis_emp->employee_contact_person_telephone : 'No data' ?>">
					</td>
				</tr>
				<tr>
					<td>Address:</td>
					<td>
						<input type="text" style="width: 99%;" name="employee_contact_person_address" value="<?= isset($sis_emp->employee_contact_person_address) ? $sis_emp->employee_contact_person_address : 'No data' ?>">
					</td>
					<td>Mobile No.:</td>
					<td>
						<input type="text" style="width: 99%;" name="employee_contact_person_mobile" value="<?= isset($sis_emp->employee_contact_person_mobile) ? $sis_emp->employee_contact_person_mobile : 'No data' ?>">
					</td>
				</tr>
			</table>
		</div>
		<br>
	</form>
	</div>
	<div class="pull-right">
		<a href='#' class="btn btn-success" id="printThis_sis" ><i class="fa fa-print"></i> Print</a>
	</div>

	<script>
		$(document).on('click','#printThis_sis',function(e){
			$('#printable_sis').print();
			e.preventDefault();
		});
	</script>