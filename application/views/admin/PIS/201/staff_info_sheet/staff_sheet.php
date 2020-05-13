<?php
/**
 * @Author: gian
 * @Date:   2016-04-04 09:29:25
 * @Last Modified by:   Gian
 * @Last Modified time: 2019-07-30 09:11:10
 */

?>
	<?= form_open(base_url('index.php/admin/employees/save_staff_info_sheet'), 'id=sis_form'); ?>
<div class='printable'>
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
				<h3><b>STAFF INFORMATION SHEETss</b></h3>
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
									<input type="hidden" name="employee_id">
									<input type="hidden" name="biometric_id">
									<input type="text" style="width: 100%;" name="employee_lname" value="<?= isset($employee_lname) ? $employee_lname : ''; ?>">
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 100%;">
							<tr>
								<td>First Name:</td>
								<td>
									<input type="text" style="width: 100%;" name="employee_fname" value="<?= isset($employee_fname) ? $employee_fname : ''; ?>">
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 100%;">
							<tr>
								<td>Middle Name:</td>
								<td>
									<input type="text" style="width: 100%;" name="employee_mname" value="<?= isset($employee_mname) ? $employee_mname : ''; ?>">
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
									<input type="text" style="width: 99%;" name="employee_blood_type" value="<?= isset($employee_blood_type) ? $employee_blood_type : ''; ?>">
								</td>

								<td width="12%"> Civil Status:</td>
								<td width="38%">
									<input type="text" style="width: 99%;" name="employee_status" value="<?= isset($employee_status) ? $employee_status : ''; ?>">
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
									<input type="date" style="width: 99%;height: 26px;" name="employee_bday" value="<?= isset($employee_bday) ? $employee_bday : ''; ?>">
								</td>
								<td width="12%"> Gender:</td>
								<td width="38%">
									<select style="width: 99%;height: 26px;" name="employee_gender">
										<option value="Male" <?= isset($employee_gender) ?  $employee_gender === 'Male' ? 'selected' : '' : ''; ?>>Male</option>
										<option value="Female" <?= isset($employee_gender) ?  $employee_gender === 'Female' ? 'selected' : '' : ''; ?>>Female</option>
									</select>
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
									<input type="text" style="width: 99%;" name="employee_father" value="<?= isset($employee_father) ? $employee_father : ''; ?>">
								</td>
								<td width="15%">Mother's Maiden Name:</td>
								<td width="35%">
									<input type="text" style="width: 99%;" name="employee_mother" value="<?= isset($employee_father) ? $employee_father : ''; ?>">
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
								<td><input type="text" style="width: 99%;" name="employee_telephone" value="<?= isset($employee_telephone) ? $employee_telephone : ''; ?>"></td>
								<td>Mobile No.:</td>
								<td><input type="text" style="width: 99%;" name="employee_mobile" value="<?= isset($employee_mobile) ? $employee_mobile : ''; ?>"></td>
								<td>Religion:</td>
								<td><input type="text" style="width: 99%;" name="employee_religion" value="<?= isset($employee_religion) ? $employee_religion : ''; ?>"></td>
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
									<input type="text" style="width: 100%;" name="employee_current_address" value="<?= isset($employee_current_address) ? $employee_current_address : ''; ?>">
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
									<input type="text" style="width: 100%;" name="employee_permanent_address" value="<?= isset($employee_permanent_address) ? $employee_permanent_address : ''; ?>">
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
				<?php
					if(isset($spouse)) {
						echo '<table class="printable_table">
									<thead>
										<tr>
											<th>Name of Spouse</th>
											<th>Date of Birth</th>
											<th>Age</th>
											<th>Date of Marriage</th>
											<th>Occupation</th>
											<th>Employer</th>
											<th>Employer\'s Address</th>
										</tr>
									</thead>
									<tbody>';
										if(empty($spouse)) {
											echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
										}
										foreach ($spouse as $key => $value) {
											$age = '';
											if($value->spouse_birth_date !== '0000-00-00') {
												$bday = new DateTime($value->spouse_birth_date);
												$cur_date = new DateTime();
												$bday = $bday->diff($cur_date);
												$age = $bday->y;
											}
											echo '<tr>
												<td>'.$value->spouse_name.'</td>
												<td>'.date("m/d/Y", strtotime($value->spouse_birth_date)).'</td>
												<td>'.$age.'</td>
												<td>'.date("m/d/Y", strtotime($value->spouse_date_of_marriage)).'</td>
												<td>'.$value->spouse_occupation.'</td>
												<td>'.$value->spouse_employer.'</td>
												<td>'.$value->spouse_employer_address.'</td>
											</tr>';
										}	
								echo '</tbody>
								</table>';
					}
				?>
			</div>
			<div id="spouse_div" class="printable_hide">
				<div id="spouse_content">
					<div id="bodySpouse"></div>
					<table class="table" width="100%">
						<tr>
							<td colspan="3">
								<table style="width: 100%;">
									<tr>
										<td width="15%">Name of Spouse:</td>
										<td>
											<input type="text" style="width: 100%;" name="spouse_name[]">
										</td>
										<td  width="8%" style="padding-left:5px;">Age:</td>
										<td>
											<input type="text" style="width: 100%;" id="spouse_age" readonly>
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
											<input type="date" style="width: 100%;" id="spouse_birth_date" name="spouse_birth_date[]">
										</td>
										<td style="padding-left: 5px;" width="15%">Date of Marriage:</td>
										<td>
											<input type="date" style="width: 100%;height: 26px;" name="spouse_date_of_marriage[]">
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
											<input type="text" style="width: 100%;" name="spouse_occupation[]">
										</td>
										<td style="padding-left:5px;" width="15%">Employer:</td>
										<td>
											<input type="text" style="width: 100%;" name="spouse_employer[]">
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
											<input type="text" style="width: 100%;" name="spouse_employer_address[]">
										</td>
									</tr>
								</table>
							</td>
							<td>
								<a href="#" id="addSpouse"><span class="glyphicon glyphicon-plus"></span></a>		
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div style="border:1px solid black;margin-top:2px;">
			<span style="font-weight: bold;padding-left: 3px">
				<b>DEPENDENTS</b>
			</span>
			<div id="dep_list">
				<?php
					if(isset($dependent)) {
						echo '<table class="printable_table">
									<thead>
										<tr>
											<th>Name of Dependents</th>
											<th>Date of Birth</th>
											<th>Age</th>
											<th>Relationship</th>
											<th>Dependent</th>
										</tr>
									</thead>
									<tbody>';
										if(empty($dependent)) {
											echo '<tr><td></td><td></td><td></td><td></td><td></td></tr>';
										}
										foreach ($dependent as $key => $value) {
											$age = '';
											if($value->emp_dependent_birthdate !== '0000-00-00') {
												$bday = new DateTime($value->emp_dependent_birthdate);
												$cur_date = new DateTime();
												$bday = $bday->diff($cur_date);
												$age = $bday->y;
											}
											$dep = '';
											if($value->emp_dependent_dependency == 1) {
												$dep = 'Yes';
											} else {
												$dep = 'No';
											}
											echo '<tr>
												<td>'.$value->emp_dependent_name.'</td>
												<td>'.date("m/d/Y", strtotime($value->emp_dependent_birthdate)).'</td>
												<td>'.$age.'</td>
												<td>'.$value->emp_dependent_relationship.'</td>
												<td>'.$dep.'</td>
											</tr>';
										}	
								echo '</tbody>
								</table>';
					}
				?>
			</div>
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
										<tr>
											<td width="40%">
												<input type="text" style="width: 99%;" name="emp_dependent_name[]">
											</td>
											<td width="20%">
												<input type="date" style="width: 99%;" id="dependent_birthdate" name="emp_dependent_birthdate[]">
											</td>
											<td width="10%">
												<input type="text" style="width: 99%;" id="dependent_age" readonly>
											</td>
											<td width="20%">
												<input type="text" style="width: 99%;" name="emp_dependent_relationship[]">
											</td>
											<td width="10%">
												<input type="checkbox" style="width: 99%" class="dependency">
												<input type="hidden" value="true" class="dependent_dependency" name="emp_dependent_dependency[]">
											</td>
											<td>
												<a href="#" id="addDependents"><span class="glyphicon glyphicon-plus"></span></a>
											</td>
										</tr>
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
						<div id="educ1_list">
							<?php
								if(isset($education1)) {
									echo '<table class="printable_table">
												<thead>
													<tr>
														<th>Attainment</th>
														<th>Name of School</th>
														<th>Year Graduated</th>
													</tr>
												</thead>
												<tbody>';
													if(empty($education1)) {
														echo '<tr><td></td><td></td><td></td></tr>';
													}
													foreach ($education1 as $key => $value) {
														echo '<tr>
															<td>'.$value->ee_attainment.'</td>
															<td>'.$value->ee_school_name.'</td>
															<td>'.$value->ee_year_graduated.'</td>														</tr>';
													}	
											echo '</tbody>
											</table>';
								}
							?>
						</div>
							<div id="educ1_div" class="printable_hide">
								<div id="educ1_content">

									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="19%" style="text-align: center;">ATTAINMENT</td>
												<td width="60%" style="text-align: center;">NAME OF SCHOOL</td>
												<td width="19%" style="text-align: center;">YEAR GRADUATED</td>
												<td>&nbsp;</td>
											</tr>
										</thead>
										<tbody id="bodyEducationalBackground">
											<tr>
												<td>
													<select style="width: 99%;height: 26px;" name="ee_attainment[]">
														<option>Elementary</option>
														<option>High School</option>
													</select>
												</td>
												<td>
													<input type="text" style="width: 99%;" name="ee_school_name[]">
													<input type="hidden" name="ee_course_taken[]">
													<input type="hidden" name="ee_units_earned[]">
													<input type="hidden" name="ee_ongoing_units[]">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;" name="ee_year_graduated[]">
												</td> 
												<td>
													<a href="#" id="addEducationalBackground"><span class="glyphicon glyphicon-plus"></span></a>
												</td>
											</tr>
										</tbody>
									</table>

								</div>
							</div>
						</div>

					</td>
				</tr>
				<tr>
					<td>

						<div id="educ2_list">
							<?php
								if(isset($education2)) {
									echo '<table class="printable_table">
												<thead>
													<tr>
														<th>Attainment</th>
														<th>Course Taken</th>
														<th>Name of School</th>
														<th>Units Earned</th>
														<th>Ongoing No. of Units Taken</th>
														<th>Year Graduated</th>
													</tr>
												</thead>
												<tbody>';
													if(empty($education2)) {
														echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
													}
													foreach ($education2 as $key => $value) {
														echo '<tr>
															<td>'.$value->ee_attainment.'</td>
															<td>'.$value->ee_course_taken.'</td>
															<td>'.$value->ee_school_name.'</td>
															<td>'.$value->ee_units_earned.'</td>
															<td>'.$value->ee_ongoing_units.'</td>
															<td>'.$value->ee_year_graduated.'</td>														</tr>';
													}	
											echo '</tbody>
											</table>';
								}
							?>
						</div>
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
											<tr>
												<td>
													<select style="width: 99%;height: 26px;" name="ee_attainment[]">
														<option>Undergrad</option>
														<option>Graduate</option>
														<option>Post Grad</option>
														<option>TechVoc</option>
													</select>
												</td>
												<td>
													<input type="text" style="width: 99%;" name="ee_course_taken[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="ee_school_name[]">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;" name="ee_units_earned[]">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;" name="ee_ongoing_units[]">
												</td>
												<td>
													<input type="number" min="0" style="width: 99%;" name="ee_year_graduated[]">
												</td>
												<td>
													<a href="#" id="addEducationalBackground1"><span class="glyphicon glyphicon-plus"></span></a>
												</td>
											</tr>
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
							<?php
								if(isset($eligibility)) {
									echo '<table class="printable_table">
												<thead>
													<tr>
														<th>Program / Module</th>
														<th>Certificate Level</th>
														<th>Status</th>
														<th>Certificate Expiration Date</th>
													</tr>
												</thead>
												<tbody>';
													if(empty($eligibility)) {
														echo '<tr><td></td><td></td><td></td><td></td></tr>';
													}
													foreach ($eligibility as $key => $value) {
														echo '<tr>
															<td>'.$value->emp_el_program.'</td>
															<td>'.$value->emp_el_certificate_level.'</td>
															<td>'.$value->emp_el_status.'</td>
															<td>'.date("m/d/Y", strtotime($value->emp_el_certificate_exp)).'</td>											</tr>';
													}	
											echo '</tbody>
											</table>';
								}
							?>
						</div>
							<div id="eli_div" class="printable_hide">
								<div id="eli_content">

									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="50%">
													<center>
														<b>Program / Module</b>
													</center>
												</td>
												<td width="16%">
													<center>
														<b>Certificate Level</b>
													</center>
												</td>
												<td width="16%">
													<center>
														<b>Status</b>
													</center>
												</td>
												<td width="16%">
													<center>
														<b>Certificate Expiration Date</b>
													</center>
												</td>
												<td width="2%"></td>
											</tr>
										</thead>

										<tbody id="bodyEligibility">
											<tr>
												<td>
													<input type="text" style="width: 99%;" name="emp_el_program[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="emp_el_certificate_level[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="emp_el_status[]">
												</td>
												<td>
													<input type="date" style="width: 99%;height: 26px;" name="emp_el_certificate_exp[]">
												</td>
												<td>
													<a href="#" id="addEligibility"><span class="glyphicon glyphicon-plus"></span></a>
												</td>
											</tr>
										</tbody>

									</table>

								</div>
							</div>
						</div>

					</td>
				</tr>

				<tr>
					<td>PROFESSIONAL AFFILATION/S
						<div id="aff_list">
							<?php
								if(isset($affilation)) {
									echo '<table class="printable_table">
												<thead>
													<tr>
														<th>Club/Organization\'s Name</th>
														<th>Membership Type</th>
														<th>Status</th>
														<th>Membership Expiration Date</th>
													</tr>
												</thead>
												<tbody>';
													if(empty($affilation)) {
														echo '<tr><td></td><td></td><td></td><td></td></tr>';
													}
													foreach ($affilation as $key => $value) {
														echo '<tr>
															<td>'.$value->emp_aff_org_name.'</td>
															<td>'.$value->emp_aff_membership_type.'</td>
															<td>'.$value->emp_aff_status.'</td>
															<td>'.date("m/d/Y", strtotime($value->emp_aff_membership_exp)).'</td>											</tr>';
													}
											echo '</tbody>
											</table>';
								}

							?>
						</div>
							<div id="aff_div" class="printable_hide">
								<div id="aff_content">
									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="50%">
													<center>
														<b>Club/Organization's Name</b>
													</center>
												</td>
												<td width="16%">
													<center>
														<b>Membership Type</b>
													</center>
												</td>
												<td width="16%">
													<center>
														<b>Status</b>
													</center>
												</td>
												<td width="16%">
													<center>
														<b>Membership Expiration Date</b>
													</center>
												</td>
												<td width="2%"></td>
											</tr>
										</thead>

										<tbody id="bodyProfessionalAffilation">
											<tr>
												<td>
													<input type="text" style="width: 99%;" name="emp_aff_org_name[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="emp_aff_membership_type[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="emp_aff_status[]">
												</td>
												<td>
													<input type="date" style="width: 99%;height: 26px;" name="emp_aff_membership_exp[]">
												</td>
												<td>
													<a href="#" id="addProfessionalAffilation"><span class="glyphicon glyphicon-plus"></span></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</td>
				</tr>

				<tr>
					<td>SEMINARS / TRAININGS ATTENDED
						<div id="ets_list">
							<?php
								if(isset($training_seminar)) {
									echo '<table class="printable_table">
												<thead>
													<tr>
														<th>Name/Title of Training/Seminar</th>
														<th>Inclusive Dates</th>
														<th>Venue</th>
														<th>Training Provider</th>
													</tr>
												</thead>
												<tbody>';
													if(empty($training_seminar)) {
														echo '<tr><td></td><td></td><td></td><td></td></tr>';
													}
													foreach ($training_seminar as $key => $value) {
														echo '<tr>
															<td>'.$value->ets_title.'</td>
															<td>'.date("m/d/Y", strtotime($value->ets_date)).'</td>
															<td>'.$value->ets_venue.'</td>
															<td>'.$value->ets_provider.'</td>											</tr>';
													}	
											echo '</tbody>
											</table>';
								}
							?>
						</div>
							<div id="ets_div" class="printable_hide">
								<div id="ets_content">
									<table style="width:100%;" class="table">
										<thead>
											<tr>
												<td width="30%">
													<center>
														<b>Name/Title of Training/ Seminar</b>
													</center>
												</td>
												<td width="19%">
													<center>
														<b>Inclusive Dates</b>
													</center>
												</td>
												<td width="30%">
													<center>
														<b>Venue</b>
													</center>
												</td>
												<td width="19%">
													<center>
														<b>Training Provider</b>
													</center>
												</td>
												<td width="2%"></td>
											</tr>
										</thead>

										<tbody id="bodySeminarTraining">
											<tr>
												<td>
													<input type="text" style="width: 99%;" name="ets_title[]">
												</td>
												<td>
													<input type="date" style="width: 99%;height: 26px;" name="ets_date[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="ets_venue[]">
												</td>
												<td>
													<input type="text" style="width: 99%;" name="ets_provider[]">
												</td>
												<td>
													<a href="#" id="addSeminarTraining"><span class="glyphicon glyphicon-plus"></span></a>
												</td>
											</tr>
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
						<input type="text" style="width: 99%;" name="employee_contact_person_name" value="<?= isset($employee_contact_person_name) ? $employee_contact_person_name : ''; ?>">
					</td>
					<td>Telephone No.:</td>
					<td>
						<input type="text" style="width: 99%;" name="employee_contact_person_telephone" value="<?= isset($employee_contact_person_telephone) ? $employee_contact_person_telephone : ''; ?>">
					</td>
				</tr>
				<tr>
					<td>Address:</td>
					<td>
						<input type="text" style="width: 99%;" name="employee_contact_person_address" value="<?= isset($employee_contact_person_address) ? $employee_contact_person_address : ''; ?>">
					</td>
					<td>Mobile No.:</td>
					<td>
						<input type="text" style="width: 99%;" name="employee_contact_person_mobile" value="<?= isset($employee_contact_person_mobile) ? $employee_contact_person_mobile : ''; ?>">
					</td>
				</tr>
			</table>
		</div>
</div>
		<br>
			<div class="pull-right printable_hide ss_buttons">
				<button class="btn btn-primary" id="addBtn"><span class="fa fa-save"></span> Save</button>
				<button type="button" id="btnPrint" class="btn btn-primary"><span class="fa fa-print"></span> Print</button>
			</div>
	</form>

	<?= form_open(base_url('index.php/admin/employees/print_sis'), array('id' => 'form_print', 'target' => '_blank')); ?>
		<input type="hidden" name="emp_id">
	</form>