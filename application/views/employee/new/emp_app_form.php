<div id="printable">
	<div class="table-responsive">
	<?= 
		form_open( base_url('index.php/admin/employees/save_employment_application_form'), 'id="emp-app-form"');
	?>
	<input type="hidden" id="emp-app-emp-id" name="employee_id">
	<table class="table" style="font-size:11px !important;">
		<tr>
			<td colspan="3" style="border:1px solid #CCC;">
				<center>
	              	<h4 style="line-height: 10px"><b>ACLC COLLEGE OF BUTUAN</b></h4>
	              	<p>
	                	Franchised and Operated by Butuan Information Technology Services, Inc.<br />
	                	HDS Bldg., 999 J.C. Aquino Avenue, Butuan City 8600
	              	</p>
	            </center>
			</td>
			<td rowspan="2" width="150px" style="border:1px solid #CCC;">
				<center>
					<div style="width:2in;height:2in;">
						<img class="img-prev" src="<?= base_url('images/no-image.fw.png') ?>" style="width:100%;height: 100%">
					</div>
				</center>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<span style="float:right;"><b>Form No.</b> BITSI-HRD-EAP</span>
				<h3>EMPLOYMENT APPLICATION FORM</h3>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<h5>
					<i><b>EMPLOYEE INFORMATION</b></i>
					<i style="padding-left:60px;"><b>(note: please do not leave blank spaces. Write N/A for not applicable)</b></i>
				</h5>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td width="18%" style="border:1px solid #CCC;">
				POSITION APPLIED FOR:
				<input type="text" style="width:100%;" name="eaf_position_applied" value="<?= isset($eaf->eaf_position_applied) ? $eaf->eaf_position_applied : 'No data' ?>" />
			</td>
			<td width="120px" style="border:1px solid #CCC;">
				EMPLOYMENT DESIRED
				<input type="text" style="width:100%;" name="eaf_employment_desired" value="<?= isset($eaf->eaf_employment_desired) ? $eaf->eaf_employment_desired : 'No data' ?>"/>
			</td>
			<td colspan="2" style="border:1px solid #CCC;">
				<!-- <div class="checkbox"> -->
				   <!--  <label style="padding-right:10px;">
				      <input type="radio" value="full-time" name="eaf_employment_desired"> FULL-TIME
				    </label>
				    <label style="padding-right:10px;">
				      <input type="radio" value="part-time" name="eaf_employment_desired"> PART-TIME ONLY
				    </label>
				    <label>
				      <input type="radio" value="full-or-part-time" name="eaf_employment_desired" > FULL-TIME OR PART-TIME
				    </label> -->
				<!-- </div> -->
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td width="200px">FAMILY NAME
				<input type="text" style="width:100%;" name="eaf_lname" value="<?= isset($eaf->eaf_lname) ? $eaf->eaf_lname : 'No data' ?>" />
			</td>
			<td width="200px">FIRST NAME 
				<input type="text" style="width:100%;" name="eaf_fname" value="<?= isset($eaf->eaf_fname) ? $eaf->eaf_fname : 'No data' ?>" />
			</td>
			<td width="200px">MIDDLE NAME
				<input type="text" style="width:100%;" name="eaf_mname" value="<?= isset($eaf->eaf_mname) ? $eaf->eaf_mname : 'No data' ?>" />
			</td>
			<td width="200px" style="border:1px solid #CCC;">NICK NAME
				<input type="text" style="width:100%;" name="eaf_nickname" value="<?= isset($eaf->eaf_nickname) ? $eaf->eaf_nickname : 'No data' ?>" />
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="2" style="border:1px solid #CCC;">PRESENT ADDRESS
				<input type="text" style="width:100%;" name="eaf_pre_addr" value="<?= isset($eaf->eaf_pre_addr) ? $eaf->eaf_pre_addr : 'No data' ?>" />
			</td>
			<td style="border:1px solid #CCC;">LANDLINE
				<input type="text" style="width:100%;" name="eaf_pal_num" value="<?= isset($eaf->eaf_pal_num) ? $eaf->eaf_pal_num : 'No data' ?>" />
			</td>
			<td style="border:1px solid #CCC;">CELLPHONE
				<input type="text" style="width:100%;" name="eaf_pam_num" value="<?= isset($eaf->eaf_pam_num) ? $eaf->eaf_pam_num : 'No data' ?>" />
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="2" style="border:1px solid #CCC;">PERMANENT ADDRESS
				<input type="text" style="width:100%;" name="eaf_peram_addr" value="<?= isset($eaf->eaf_peram_addr) ? $eaf->eaf_peram_addr : 'No data' ?>" />
			</td>
			<td style="border:1px solid #CCC;">LANDLINE				        			<!-- ~~~~~~~~~~~~~~~~~~ -->		
				<input type="text" style="width:100%;" name="eaf_peral_num" value="<?= isset($eaf->eaf_peral_num) ? $eaf->eaf_peral_num : 'No data' ?>"/>
			</td style="border:1px solid #CCC;">
			<td>CELLPHONE
				<input type="text" style="width:100%;" name="eaf_peram_num" value="<?= isset($eaf->eaf_peram_num) ? $eaf->eaf_peram_num : 'No data' ?>"/>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td style="border:1px solid #CCC;">DATE OF BIRTH
				<input type="date" style="width:100%;height:23px;" name="eaf_birthdate" value="<?= isset($eaf->eaf_birthdate) ? $eaf->eaf_birthdate : 'No data' ?>"/>
			</td>
			<td style="border:1px solid #CCC;">PLACE OF BIRTH
				<input type="text" style="width:100%;" name="eaf_birthplace" value="<?= isset($eaf->eaf_birthplace) ? $eaf->eaf_birthplace : 'No data' ?>"/>
			</td>
			<td style="border:1px solid #CCC;">CITIZENSHIP
				<input type="text" style="width:100%;" name="eaf_citizenship" value="<?= isset($eaf->eaf_citizenship) ? $eaf->eaf_citizenship : 'No data' ?>"/>
			</td>
			<td style="border:1px solid #CCC;">
				<table>
					<tr>
						<td>BLOOD TYPE
							<input type="text" style="width:99%;" name="eaf_blood_type" value="<?= isset($eaf->eaf_blood_type) ? $eaf->eaf_blood_type : 'No data' ?>"/>
						</td>
						<td>GENDER
							<input type="text" style="width:99%;" name="eaf_gender" value="<?= isset($eaf->eaf_gender) ? $eaf->eaf_gender : 'No data' ?>"/>
							<!-- <select select="select" style="height:23px;width: 100%;" name="eaf_gender">
								<option>-SELECT-</option>
								<option value="Male">MALE</option>
								<option value="Female">FEMALE</option>
							</select> -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td style="border:1px solid #CCC;">RELIGION
				<input type="text" style="width:100%;" name="eaf_religion" value="<?= isset($eaf->eaf_religion) ? $eaf->eaf_religion : 'No data' ?>"/>
			</td>
			<td style="border:1px solid #CCC;">
				<table>
					<tr>
						<td>CIVIL STATUS
							<input type="text" style="" name="eaf_civil_status" value="<?= isset($eaf->eaf_civil_status) ? $eaf->eaf_civil_status : 'No data' ?>"/>
							<!-- <select select="select" style="height:23px;" name="eaf_civil_status">
								<option>-SELECT-</option>
								<option>SINGLE</option>
								<option>MARRIED</option>
								<option>WIDOW</option>
								<option>COMPLICATED</option>
							</select> -->
						</td>
						<td>DATE OF MARRIAGE
							<input type="text" style="width:100%;height:23px;" name="eaf_marriage_date" value="<?= isset($eaf->eaf_marriage_date) ? $eaf->eaf_marriage_date : 'No data' ?>"/>
						</td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">HEIGHT
				<input type="text" style="width:100%;" name="eaf_height" value="<?= isset($eaf->eaf_height) ? $eaf->eaf_height : 'No data' ?>"/>
			</td>
			<td style="border:1px solid #CCC;">WEIGHT
				<input type="text" style="width:100%;" name="eaf_weight" value="<?= isset($eaf->eaf_weight) ? $eaf->eaf_weight : 'No data' ?>"/>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td style="border:1px solid #CCC;">PHILHEALTH #
				<input type="text" style="width:100%;" name="eaf_philhealth" value="<?= isset($eaf->eaf_philhealth) ? $eaf->eaf_philhealth : 'No data' ?>" />
			</td>
			<td style="border:1px solid #CCC;">PAG-IBIG #
				<input type="text" style="width:100%;" name="eaf_pagibig" value="<?= isset($eaf->eaf_pagibig) ? $eaf->eaf_pagibig : 'No data' ?>" />
			</td>
			<td style="border:1px solid #CCC;">TIN #
				<input type="text" style="width:100%;" name="eaf_TIN" value="<?= isset($eaf->eaf_TIN) ? $eaf->eaf_TIN : 'No data' ?>" />
			</td>
			<td style="border:1px solid #CCC;">SSS #
				<input type="text" style="width:100%;" name="eaf_SSS" value="<?= isset($eaf->eaf_SSS) ? $eaf->eaf_SSS : 'No data' ?>"  />
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
				<table style="width:100%;">
					<tr>
						<td >FATHER'S NAME
	    					<input type="text" style="width:99%;" name="eaf_father_name" value="<?= isset($eaf->eaf_father_name) ? $eaf->eaf_father_name : 'No data' ?>" />
	    				</td>
	    				<td>MOTHER'S MAIDEN NAME
	    					<input type="text" style="width:100%;" name="eaf_mother_name" value="<?= isset($eaf->eaf_mother_name) ? $eaf->eaf_mother_name : 'No data' ?>" />
	    				</td>
					</tr>
				</table>
			</td>
		</tr>
	<!-- 	<tr >
			<td colspan="4" style="border:1px solid #CCC;">
				
			</td>
		</tr> -->
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
			<div id="e_spouse">
						
			</div>
				<table style="width:100%;" id="parentSpouse">
					<tr>
						<td>NAME OF SPOUSE</td>
						<td>DATE OF BIRTH (SPOUSE)</td>
						<td>OCCUPATION (SPOUSE)</td>
						<td>TELEPHONE #</td>
					</tr>
					<?php
						foreach ($eaf_spouse as $key => $value) {

					?>

						<tr>
							<td>
								<input type="text" style="width:99%;" name="eaf_spouse_name[]" value="<?= isset($value->eaf_spouse_name) ? $value->eaf_spouse_name : 'No data' ?>" />
							</td>
							<td>
								<input type="text" style="width:99%;height:23px;" name="eaf_spouse_dob[]" value="<?= isset($value->eaf_spouse_dob) ? $value->eaf_spouse_dob : 'No data' ?>" />
							</td>
							<td>
								<input type="text" style="width:99%;" name="eaf_spouse_occupation[]" value="<?= isset($value->eaf_spouse_occupation) ? $value->eaf_spouse_occupation : 'No data' ?>" />
							</td>
							<td>
								<input type="text" style="width:99%;" name="eaf_spouse_contact_num[]" value="<?= isset($value->eaf_spouse_contact_num) ? $value->eaf_spouse_contact_num : 'No data' ?>" />
							</td>
							<td><br />
							</td>
						</tr>
					<?php
						}
					?>
				</table>
			</td>
		</tr>

		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
				<table style="width:100%;" id="parentChildren">
					<tr>
						<td>NAME OF CHILDREN</td>
						<td>DATE OF BIRTH</td>
					</tr>
					<?php 
						foreach ($eaf_children as $key => $value) {
					?>
					<tr>
						<td>
							<input type="text" style="width:99%;" name="eaf_child_name[]" value="<?= isset($value->eaf_child_name) ? $value->eaf_child_name : 'No data' ?>" />
						</td>
						<td>
							<input type="text" style="width:100%;height:23px;" name="eaf_child_dob[]" value="<?= isset($value->eaf_child_dob) ? $value->eaf_child_dob : 'No data' ?>" />
						</td>
						<td><br />
						</td>
					</tr>
					<?php
						}
					?>
				</table>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">	
				<table style="width:100%;">
					<tr>
						<td>
							PERSON TO CONTACT IN CASE OF EMERGENCY:
						</td>
						<td>NAME
							<input type="text" style="width:99%;" name="eaf_contact_person" value="<?= isset($eaf->eaf_contact_person) ? $eaf->eaf_contact_person : 'No data' ?>"  />
						</td>
						<td>ADDRESS
							<input type="text" style="width:99%;" name="eaf_cp_address" value="<?= isset($eaf->eaf_cp_address) ? $eaf->eaf_cp_address : 'No data' ?>"/>
						</td>
						<td>TELEPHONE #
							<input type="text" style="width:99%;" name="eaf_cp_num" value="<?= isset($eaf->eaf_cp_num) ? $eaf->eaf_cp_num : 'No data' ?>"/>
						</td>
						<td>RELATIONSHIP
							<input type="text" style="width:99%;" name="eaf_cp_relationship" value="<?= isset($eaf->eaf_cp_relationship) ? $eaf->eaf_cp_relationship : 'No data' ?>"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
				<table style="width:100%;">
					<tr>
						<td>PREVIOUS <br>HOSPITALIZATION</td>
						<td>
							<textarea name="eaf_ph_in" id="hospital" class="form-control prev-hosp" rows="3" placeholder="IF YES, NATURE OF ILLNESS" style="resize:none;width: 80%;height: 50px;border:none;"><?= isset($eaf->eaf_ph_in) ? $eaf->eaf_ph_in : 'No data' ?></textarea>
						</td>
						<td>PREVIOUS <br>OPERATION</td>
						<td>
							<textarea name="eaf_po_in" class="form-control" rows="3" placeholder="IF YES, NATURE OF ILLNESS" style="resize:none;width: 80%;height: 50px;border:none;"><?= isset($eaf->eaf_po_in) ? $eaf->eaf_po_in : 'No data' ?></textarea>
						</td>
					</tr>
				</table>
			</td>		
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
				<table style="width:100%;">
					<tr>
						<td>CURRENTLY UNDERGOING TREATMENT?</td>
						<td>
							<textarea name="eaf_cut_explain" class="form-control" rows="3" placeholder="IF YES, NATURE OF ILLNESS" style="resize:none;width: 80%;height: 50px;border:none;"><?= isset($eaf->eaf_cut_explain) ? $eaf->eaf_cut_explain : 'No data' ?></textarea>
						</td>
						<td width="15%">HAVE YOU EVER BEEN CONVICTED OF A CRIME?</td>
						<td>
							<textarea name="eaf_crime_explain" class="form-control" rows="3" placeholder="IF YES, SPECIFY OFFENSE" style="resize:none;width: 80%;height: 50px;border:none;"><?= isset($eaf->eaf_crime_explain) ? $eaf->eaf_crime_explain : 'No data' ?></textarea>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
				<table style="width: 100%;">
					<tr>
						<td width="30%">HAVE YOU BEEN DISMISSED, RESIGNED FROM, OR LEFT EMPLOYMENT DUE TO ALLEGATION OF MISCONDUCT?</td>
						<td>
							<textarea name="eaf_misconduct_explain" class="form-control" rows="3" placeholder="IF YES, SPECIFY OFFENSE" style="resize:none;width: 99%;height: 50px;border:none;"><?= isset($eaf->eaf_misconduct_explain) ? $eaf->eaf_misconduct_explain : 'No data' ?></textarea>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="border:1px solid #CCC;">
			<td colspan="4" style="border:1px solid #CCC;">
				<table style="width:100%;">
					<tr>
						<td width="30%">DO YOU HAVE ANY PENDING ADMINISTRATIVE OR CRIMINAL CASE?</td>
						<td>
							<textarea name="eaf_criminal_explain" class="form-control" rows="3" placeholder="IF YES, SPECIFY OFFENSE" style="resize:none;width: 99%;height: 50px;border:none;"><?= isset($eaf->eaf_criminal_explain) ? $eaf->eaf_criminal_explain : 'No data' ?></textarea>
						</td>
					</tr>
				</table>
			</td>
		</tr>
			<td colspan="6" style="border:1px solid #CCC;">
				<table style="width: 100%" id="parentRelative">
					<tr>
						<td width="40%">RELATIVES OR FAMILY MEMBERS WORKING FOR ACLC</td>	
					</tr>
					<tr><td> &nbsp;</td></tr>
					<tr>
						<td>NAME OF RELATIVE</td>
						<td>RELATIONSHIP</td>
						<td>POSITION &amp; DEPARTMENT</td>
					</tr>
					<?php
						foreach ($emp_app_form_relative as $key => $value) {
							# code...
					?>
					<tr>
						<td>
							<input type="text" style="width: 99%" name="eaf_relative_name[]" value="<?= isset($value->eaf_relative_name) ? $value->eaf_relative_name : 'No data' ?>"> 
						</td>
						<td>
							<input type="text" style="width: 99%" name="eaf_relative_relationship[]"  value="<?= isset($value->eaf_relative_relationship) ? $value->eaf_relative_relationship : 'No data' ?>"> 
						</td>
						<td>
							<input type="text" style="width: 99%" name="eaf_relative_position[]"  value="<?= isset($value->eaf_relative_position) ? $value->eaf_relative_position : 'No data' ?>"> 
						</td>

						<td><br />
						</td>
					</tr>
					<?php
						}
					?>
				</table>
			</td>
		</tr>
	</table>

	<i><b>EDUCATION</b></i>	<tr>
	<table class="table" style="font-size:11px !important;">
		<thead>
			<tr style="border:1px solid #CCC;">
				<td style="text-align: center;border:1px solid #CCC;">TYPE OF SCHOOL</td>
				<td style="text-align: center;border:1px solid #CCC;">NAME OF SCHOOL</td>
				<td style="text-align: center;border:1px solid #CCC;">DEGREE EARNED</td>
				<td style="text-align: center;border:1px solid #CCC;">INCLUSIVE DATES</td>
				<td style="text-align: center;border:1px solid #CCC;">HONORS RECEIVED</td></center>
			</tr>
		</thead>
		<tbody id="parentEducational">

			<?php
				foreach ($emp_app_form_education as $key => $value) {
					

			?>

			<tr>
				<td width="15%" style="border:1px solid #CCC;">
					<input type="text" style="width: 100%;text-align:center;" name="eaf_educ_school_type[]"  value="<?= isset($value->eaf_educ_school_type) ? $value->eaf_educ_school_type : 'No data' ?>">
				</td>
				<td width="20%" style="border:1px solid #CCC;">
					<input type="text" style="width: 100%;text-align:center;" name="eaf_educ_school_name[]" value="<?= isset($value->eaf_educ_school_name) ? $value->eaf_educ_school_name : 'No data' ?>">
				</td>
				<td width="10%" style="border:1px solid #CCC;">
					<input type="text" style="width: 100%;text-align:center;" name="eaf_educ_degree[]" value="<?= isset($value->eaf_educ_degree) ? $value->eaf_educ_degree : 'No data' ?>">
				</td>
				<td width="40%" style="border:1px solid #CCC;">
					<center>
						<input type="text" style="height: 23px;text-align:center;" name="eaf_educ_from[]" value="<?= isset($value->eaf_educ_from) ? $value->eaf_educ_from : 'No data' ?>"> - <input name="eaf_educ_to[]" type="text" style="height: 23px;text-align:center;" value="<?= isset($value->eaf_educ_to) ? $value->eaf_educ_to : 'No data' ?>">
					</center>
				</td>
				<td width="10%" style="border:1px solid #CCC;">
						<input type="text" style="width:80%;text-align:center;" name="eaf_educ_honors[]" value="<?= isset($value->eaf_educ_honors) ? $value->eaf_educ_honors : 'No data' ?>">
				</td>
			</tr>
			
			<?php
				}
			?>

			<tr>
				<td colspan="6" style="border:1px solid #CCC;">
					<table style="width:100%;">
						<tr>
							<td width="20%"><br>MASTER THESIS</td>
							<td>TITLE
								<input type="text" style="width: 99%" name="eaf_mthesis_title" value="<?= isset($eaf->eaf_mthesis_title) ? $eaf->eaf_mthesis_title : 'No data' ?>" > 
							</td>
							<td width="30%">DATE
								<input type="text" style="width: 99%;height: 23px;" name="eaf_mthesis_date" value="<?= isset($eaf->eaf_mthesis_date) ? $eaf->eaf_mthesis_date : 'No data' ?>"> 
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="6" style="border:1px solid #CCC;">
					<table style="width:100%;">
						<tr>
							<td width="20%"><br>DOCTOR DISSERTATION</td>
							<td>TITLE
								<input type="text" style="width: 99%" name="eaf_dd_title" value="<?= isset($eaf->eaf_dd_title) ? $eaf->eaf_dd_title : 'No data' ?>"> 
							</td>
							<td width="30%">DATE
								<input type="text" style="width: 99%;height: 23px;" name="eaf_dd_date" value="<?= isset($eaf->eaf_dd_date) ? $eaf->eaf_dd_date : 'No data' ?>"> 
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="6" style="border:1px solid #CCC;">
					<table style="width:100%;">
						<tr>
							<td width="20%">PROFESSIONAL LICENSE<br>(e.g, CPA, RN, etc.)</td>
							<td>TITLE
								<input type="text" style="width: 99%" name="eaf_pl_title" value="<?= isset($eaf->eaf_pl_title) ? $eaf->eaf_pl_title : 'No data' ?>"> 
							</td>
							<td width="30%">DATE
								<input type="text" style="width: 99%;height: 23px;" name="eaf_pl_date" value="<?= isset($eaf->eaf_pl_date) ? $eaf->eaf_pl_date : 'No data' ?>"> 
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="6" style="border:1px solid #CCC;">
					<table style="width:100%;">
						<tr>
							<td width="30%">SPECIAL SKILLS (PLEASE SPECIFY,<br> eg., computer, driving, etc.)</td>
							<td>
								<input type="text" class="col-sm-12" name="eaf_ss_title"  value="<?= isset($eaf->eaf_ss_title) ? $eaf->eaf_ss_title : 'No data' ?>"> 
							</td>
							<td width="30%">
								<!-- <input type="text" style="width: 99%;height: 23px;" name="eaf_ss_date"  value="<?= isset($eaf->eaf_ss_date) ? $eaf->eaf_ss_date : 'No data' ?>">  -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

	<i><b>EMPLOYMENT (Start with the most recent or present employer)</b></i>
	<div class="e_employment" >
		
	</div>
	<div id="bodyEmployment">

		<div>
			 
		</div>
	</div>

	<i><b>FOR TEACHING POSITION ONLY</b></i>
	<table style="font-size: 11px;" class="table">
			<tr>
				<td style="border:1px solid #CCC;text-align: center"><b>INCLUSIVE DATES</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>SCHOOL</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>GRADE OR SUBJECT TAUGHT</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>SUPERIOR &amp; CONTACT #</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>SALARY</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>REASON FOR LEAVING</b></td>
				<td>&nbsp;</td>
			</tr>
			<?php
				foreach ($eaf_teaching_pos as $key => $value) {

			?>
			<tr>
				<td style="border:1px solid #CCC;"><center><input type="text" style="text-align:center" value="<?= isset($value->eaf_tp_date_from) ? $value->eaf_tp_date_from : 'No data' ?>"> <br>-<br> <input style="text-align:center" type="text" value="<?= isset($value->eaf_tp_date_to) ? $value->eaf_tp_date_to : 'No data' ?>"></center></td>
				<td style="border:1px solid #CCC;text-align: center"><input style="text-align:center" type="text" value="<?= isset($value->eaf_tp_school) ? $value->eaf_tp_school : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input style="text-align:center" type="text" value="<?= isset($value->eaf_tp_subject) ? $value->eaf_tp_subject : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input style="text-align:center" type="text" value="<?= isset($value->eaf_tp_superior_cont) ? $value->eaf_tp_superior_cont : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input style="text-align:center" type="text" value="<?= isset($value->eaf_tp_salary) ? $value->eaf_tp_salary : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input style="text-align:center" type="text" value="<?= isset($value->eaf_tp_rfl) ? $value->eaf_tp_rfl : 'No data' ?>"></td>
			</tr>
			<?php
				}
			?>
	</table>

	<i><b>EMPLOYMENT RECORD AT ACLC OR OTHER AMA GROUP OF COMPANIES</b></i>
	<table style="width: 100%;font-size: 11px;" class="table">
		
		<thead>
		<tr>
			<td style="border:1px solid #CCC;text-align: center"><b>INCLUSIVE DATES</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>POSITION &amp; DEPARTMENT</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>SUPERIOR &amp; CONTACT #</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>SALARY</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>REASON FOR LEAVING</b></td>
			<td>&nbsp;</td>
		</tr>
		</thead>
		<tbody id="bodyCompanies">
			<?php
				foreach ($eaf_emprec as $key => $value) {

			?>
			<tr>
				<td style="border:1px solid #CCC;text-align: center">
				<input type="text" style="text-align:center;" value="<?= isset($value->eaf_erc_date_from) ? $value->eaf_erc_date_from : 'No data' ?>"> <br> - <input type="text" style="text-align:center;" value="<?= isset($value->eaf_erc_date_to) ? $value->eaf_erc_date_to : 'No data' ?>">
				</td>
				<td style="border:1px solid #CCC;text-align: center"><input name="eaf_prev_position[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_prev_position) ? $value->eaf_prev_position : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_superior_cont[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_erc_superior_cont) ? $value->eaf_erc_superior_cont : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_salary[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_erc_salary) ? $value->eaf_erc_salary : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_rfl[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_erc_rfl) ? $value->eaf_erc_rfl : 'No data' ?>"></td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>

	<i><b>TRAININGS AND SEMINARS</b></i>

	<table style="width: 100%;font-size: 11px;" class="table">
		<thead>
			<tr>
				<td style="border:1px solid #CCC;text-align: center"><b>TITLE</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>NAME &amp; LOCATION OF TRAINING PROVIDER</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>INCLUSIVE DATES</b></td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody id="bodyTrainingSeminar">
			<?php
				foreach ($eaf_training as $key => $value) {
			?>
			<tr>
				<td style="border:1px solid #CCC;"><input name="eaf_tas_title[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_tas_title) ? $value->eaf_tas_title : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;"><input name="eaf_tas_name_loc[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_tas_name_loc) ? $value->eaf_tas_name_loc : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;">
						<input type="text" style="text-align:center;" value="<?= isset($value->eaf_tas_date_from) ? $value->eaf_tas_date_from : 'No data' ?>"> - <input type="text" style="text-align:center;" value="<?= isset($value->eaf_tas_date_to) ? $value->eaf_tas_date_to : 'No data' ?>">
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>

	<i><b>MEMBERSHIP IN ORGANIZATIONS AND CLUBS</b></i>
	<table style="width: 100%;font-size: 11px;" class="table">
		<thead>
			<tr>
				<td style="border:1px solid #CCC;text-align: center"><b>ORGANIZATION/CLUB</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>POSITION</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>INCLUSIVE DATE OF MEMBERSHIP</b></td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody id="bodyOrganization">
			<?php
				foreach ($eaf_orgs as $key => $value) {
			?>
			<tr>
				<td style="border:1px solid #CCC;"><input name="eaf_org_name[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_org_name) ? $value->eaf_org_name : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;"><input name="eaf_org_position[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_org_position) ? $value->eaf_org_position : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;text-align:center;">
					<input type="text" style="text-align:center;" value="<?= isset($value->eaf_org_date_from) ? $value->eaf_org_date_from : 'No data' ?>"> - <input type="text" style="text-align:center;" value="<?= isset($value->eaf_org_date_to) ? $value->eaf_org_date_to : 'No data' ?>">
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>

	<i><b>REFERENCES (Exclude relatives)</b></i>
	<table style="width: 100%;font-size: 11px;" class="table">
		<thead>
			<tr>
				<td style="border:1px solid #CCC;text-align: center"><b>NAME</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>COMPANY NAME &amp; ADDRESS</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>POSITION</b></td>
				<td style="border:1px solid #CCC;text-align: center"><b>CONTACT #</b></td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody id="bodyReference">
				<?php
					foreach ($eaf_ref as $key => $value) {
				?>
			<tr>
				<td style="border:1px solid #CCC;"><input name="eaf_ref_name[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_ref_name) ? $value->eaf_ref_name : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;"><input name="eaf_ref_comp_name[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_ref_comp_name) ? $value->eaf_ref_comp_name : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;"><input name="eaf_ref_position[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_ref_position) ? $value->eaf_ref_position : 'No data' ?>"></td>
				<td style="border:1px solid #CCC;"><input name="eaf_ref_contact[]" type="text" style="width: 99%;text-align:center;" value="<?= isset($value->eaf_ref_contact) ? $value->eaf_ref_contact : 'No data' ?>"></td>
			</tr>
				<?php
					}
				?>
		</tbody>
	</table>

	</form>
	</div>
</div>

<div class="pull-right">
	<a href='#' class="btn btn-success" id="printThis" ><i class="fa fa-print"></i> Print</a>
</div>



<style>
	input {
		background-color:white;
		border:none;
		font-weight: bold;
	}
	textarea:not(#eur_request_content)  {
		background-color:white;
		border-color:transparent;
		font-weight: bold;
		pointer-events:none;
	}
</style>

<script>
		$(document).on('click','#printThis',function(e){
			$('#printable').print();
			e.preventDefault();
		});
</script>