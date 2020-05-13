<?php
/**
 * @Author: gian
 * @Date:   2016-03-30 13:51:53
 * @Last Modified by:   Gian
 * @Last Modified time: 2019-09-18 10:04:56
 */

?>

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
			<input type="text" style="width:100%;" name="eaf_position_applied"/>
		</td>
		<td width="120px" style="border:1px solid #CCC;"><br />
			EMPLOYMENT DESIRED
		</td>
		<td colspan="2" style="border:1px solid #CCC;">
			<div >
			    <label style="padding-right:10px;">
			      <input type="radio" value="full-time" name="eaf_employment_desired"> FULL-TIME
			    </label>
			    <label style="padding-right:10px;">
			      <input type="radio" value="part-time" name="eaf_employment_desired"> PART-TIME ONLY
			    </label>
			    <label>
			      <input type="radio" value="full-or-part-time" name="eaf_employment_desired" > FULL-TIME OR PART-TIME
			    </label>
			</div>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td width="200px">FAMILY NAME
			<input type="text" style="width:100%;" name="eaf_lname" value="<?= isset($empInfo) ? $empInfo->employee_lname : ''  ?>" />
		</td>
		<td width="200px">FIRST NAME 
			<input type="text" style="width:100%;" name="eaf_fname"/>
		</td>
		<td width="200px">MIDDLE NAME
			<input type="text" style="width:100%;" name="eaf_mname"/>
		</td>
		<td width="200px" style="border:1px solid #CCC;">NICK NAME
			<input type="text" style="width:100%;" name="eaf_nickname"/>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td colspan="2" style="border:1px solid #CCC;">PRESENT ADDRESS
			<input type="text" style="width:100%;" name="eaf_pre_addr"/>
		</td>
		<td style="border:1px solid #CCC;">LANDLINE
			<input type="text" style="width:100%;" name="eaf_pal_num"/>
		</td>
		<td style="border:1px solid #CCC;">CELLPHONE
			<input type="text" style="width:100%;" name="eaf_pam_num"/>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td colspan="2" style="border:1px solid #CCC;">PERMANENT ADDRESS
			<input type="text" style="width:100%;" name="eaf_peram_addr" />
		</td>
		<td style="border:1px solid #CCC;">LANDLINE				        					
			<input type="text" style="width:100%;" name="eaf_peral_num"/>
		</td style="border:1px solid #CCC;">
		<td>CELLPHONE
			<input type="text" style="width:100%;" name="eaf_peram_num"/>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td style="border:1px solid #CCC;">DATE OF BIRTH
			<input type="date" style="width:100%;height:23px;" name="eaf_birthdate"/>
		</td>
		<td style="border:1px solid #CCC;">PLACE OF BIRTH
			<input type="text" style="width:100%;" name="eaf_birthplace"/>
		</td>
		<td style="border:1px solid #CCC;">CITIZENSHIP
			<input type="text" style="width:100%;" name="eaf_citizenship"/>
		</td>
		<td style="border:1px solid #CCC;">
			<table>
				<tr>
					<td>BLOOD TYPE
						<input type="text" style="width:99%;" name="eaf_blood_type"/>
					</td>
					<td>GENDER
						<select select="select" style="height:23px;width: 100%;" name="eaf_gender">
							<option>-SELECT-</option>
							<option value="Male">MALE</option>
							<option value="Female">FEMALE</option>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td style="border:1px solid #CCC;">RELIGION
			<input type="text" style="width:100%;" name="eaf_religion"/>
		</td>
		<td style="border:1px solid #CCC;">
			<table>
				<tr>
					<td>CIVIL STATUS
						<select select="select" style="height:23px;" name="eaf_civil_status">
							<option>-SELECT-</option>
							<option>SINGLE</option>
							<option>MARRIED</option>
							<option>WIDOW</option>
							<option>COMPLICATED</option>
						</select>
					</td>
					<td>DATE OF MARRIAGE
						<input type="date" style="width:100%;height:23px;" name="eaf_marriage_date"/>
					</td>
				</tr>
			</table>
		</td>
		<td style="border:1px solid #CCC;">HEIGHT
			<input type="text" style="width:100%;" name="eaf_height"/>
		</td>
		<td style="border:1px solid #CCC;">WEIGHT
			<input type="text" style="width:100%;" name="eaf_weight"/>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td style="border:1px solid #CCC;">PHILHEALTH #
			<input type="text" style="width:100%;" name="eaf_philhealth" />
		</td>
		<td style="border:1px solid #CCC;">PAG-IBIG #
			<input type="text" style="width:100%;" name="eaf_pagibig"/>
		</td>
		<td style="border:1px solid #CCC;">TIN #
			<input type="text" style="width:100%;" name="eaf_TIN"/>
		</td>
		<td style="border:1px solid #CCC;">SSS #
			<input type="text" style="width:100%;" name="eaf_SSS"/>
		</td>
	</tr>
	<tr style="border:1px solid #CCC;">
		<td colspan="4" style="border:1px solid #CCC;">
			<table style="width:100%;">
				<tr>
					<td >FATHER'S NAME
    					<input type="text" style="width:99%;" name="eaf_father_name" />
    				</td>
    				<td>MOTHER'S MAIDEN NAME
    					<input type="text" style="width:100%;" name="eaf_mother_name"/>
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
					<td>NAME OF SPOUSE
						<input type="text" style="width:99%;" name="eaf_spouse_name[]"/>
					</td>
					<td>DATE OF BIRTH (SPOUSE)
						<input type="date" style="width:99%;height:23px;" name="eaf_spouse_dob[]" />
					</td>
					<td>OCCUPATION (SPOUSE)
						<input type="text" style="width:99%;" name="eaf_spouse_occupation[]" />
					</td>
					<td>TELEPHONE #
						<input type="text" style="width:99%;" name="eaf_spouse_contact_num[]" />
					</td>
					<td><br />
						<a href="#" id="addSpouse"><span class="glyphicon glyphicon-plus"></span></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr style="border:1px solid #CCC;">
		<td colspan="4" style="border:1px solid #CCC;">
			<table style="width:100%;" id="parentChildren">
				<tr>
					<div id="e_children">
					
					</div>
					<td>NAME OF CHILDREN
						<input type="text" style="width:99%;" name="eaf_child_name[]"/>
					</td>
					<td>DATE OF BIRTH
						<input type="date" style="width:100%;height:23px;" name="eaf_child_dob[]" />
					</td>
					<td><br />
						&nbsp;<a href="#" id="addChildren"><span class="glyphicon glyphicon-plus"></span></a>
					</td>
				</tr>
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
						<input type="text" style="width:99%;" name="eaf_contact_person"/>
					</td>
					<td>ADDRESS
						<input type="text" style="width:99%;" name="eaf_cp_address" />
					</td>
					<td>TELEPHONE #
						<input type="text" style="width:99%;" name="eaf_cp_num" />
					</td>
					<td>RELATIONSHIP
						<input type="text" style="width:99%;" name="eaf_cp_relationship" />
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
						<textarea name="eaf_ph_in" id="hospital" class="form-control prev-hosp" rows="3" placeholder="IF YES, NATURE OF ILLNESS" style="resize:none;width: 80%;height: 50px"></textarea>
					</td>
					<td>PREVIOUS <br>OPERATION</td>
					<td>
						<textarea name="eaf_po_in" class="form-control" rows="3" placeholder="IF YES, NATURE OF ILLNESS" style="resize:none;width: 80%;height: 50px"></textarea>
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
						<textarea name="eaf_cut_explain" class="form-control" rows="3" placeholder="IF YES, NATURE OF ILLNESS" style="resize:none;width: 80%;height: 50px"></textarea>
					</td>
					<td width="15%">HAVE YOU EVER BEEN CONVICTED OF A CRIME?</td>
					<td>
						<textarea name="eaf_crime_explain" class="form-control" rows="3" placeholder="IF YES, SPECIFY OFFENSE" style="resize:none;width: 80%;height: 50px"></textarea>
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
						<textarea name="eaf_misconduct_explain" class="form-control" rows="3" placeholder="IF YES, SPECIFY OFFENSE" style="resize:none;width: 99%;height: 50px"></textarea>
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
						<textarea name="eaf_criminal_explain" class="form-control" rows="3" placeholder="IF YES, SPECIFY OFFENSE" style="resize:none;width: 99%;height: 50px"></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
		<td colspan="6" style="border:1px solid #CCC;">
			<table style="width: 100%" id="parentRelative">
				<tr>
					<div id="e_relative">
								
					</div>
					<td width="30%">DO YOU HAVE RELATIVES OR FAMILY MEMBERS WORKING FOR ACLC?</td>	
					<td>
						NAME OF RELATIVE
						<input type="text" style="width: 99%" name="eaf_relative_name[]"> 
					</td>
					<td>
						RELATIONSHIP
						<input type="text" style="width: 99%" name="eaf_relative_relationship[]"> 
					</td>
					<td>
						POSITION &amp; DEPARTMENT
						<input type="text" style="width: 99%" name="eaf_relative_position[]"> 
					</td>
					<td><br />
						<a href="#" id="addRelative"><span class="glyphicon glyphicon-plus"></span></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<i><b>EDUCATION</b></i>	<tr>
<div class="educ_table">
	
</div>
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
		<tr>
			<td width="15%" style="border:1px solid #CCC;">
				<select select="selected" style="height:23px;width: 100%" name="eaf_educ_school_type[]">
					<option>-SELECT-</option>
					<option value="elementary">ELEMENTARY</option>
					<option value="hs">HIGH SCHOOL</option>
					<option value="vs">VOCATIONAL SCHOOL</option>
					<option value="college">COLLEGE</option>
					<option value="gsm">GRADUATE SCHOOL (MASTER)</option>
					<option value="gsd">GRADUATE SCHOOL (DOCTORATE)</option>
				</select>
			</td>
			<td width="20%" style="border:1px solid #CCC;">
				<input type="text" style="width: 100%;" name="eaf_educ_school_name[]">
			</td>
			<td width="10%" style="border:1px solid #CCC;">
				<input type="text" style="width: 100%;" name="eaf_educ_degree[]">
			</td>
			<td width="20%" style="border:1px solid #CCC;">
				<center><input type="date" style="height: 23px" name="eaf_educ_from[]"> - <input name="eaf_educ_to[]" type="date" style="height: 23px"></center>
			</td>
			<td width="10%" style="border:1px solid #CCC;">
				<input type="text" style="width:80%;" name="eaf_educ_honors[]">
				<a href="#" id="addEducationalBackground"><span class="glyphicon glyphicon-plus"></span></a>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="border:1px solid #CCC;">
				<table style="width:100%;">
					<tr>
						<td width="20%"><br>MASTER THESIS</td>
						<td>TITLE
							<input type="text" style="width: 99%" name="eaf_mthesis_title"> 
						</td>
						<td width="30%">DATE
							<input type="date" style="width: 99%;height: 23px;" name="eaf_mthesis_date"> 
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
							<input type="text" style="width: 99%" name="eaf_dd_title"> 
						</td>
						<td width="30%">DATE
							<input type="date" style="width: 99%;height: 23px;" name="eaf_dd_date"> 
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
							<input type="text" style="width: 99%" name="eaf_pl_title"> 
						</td>
						<td width="30%">DATE
							<input type="date" style="width: 99%;height: 23px;" name="eaf_pl_date"> 
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="border:1px solid #CCC;">
				<table style="width:100%;">
					<tr>
						<td style="width:30%">SPECIAL SKILLS (PLEASE SPECIFY,<br> eg., computer, driving, etc.)</td>
						<td>
							<input type="text" class="col-sm-12" name="eaf_ss_title"> 
						</td>
						<!-- <td width="30%">DATE
							<input type="date" style="width: 99%;height: 23px;" name="eaf_ss_date"> 
						</td> -->
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
	<a href="#" id="addEmploymentRecord"style="float:right;"><b>Add Employment Record</b> <span class="glyphicon glyphicon-plus" title="Add Employment Record"></span></a>
	<table class="table" style="font-size:11px;border:1px solid #CCC;">
		<tr style="border:1px solid #CCC;">
			<td width="20%" style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><b>COMPANY NAME:</b></td>
					</tr>
					<tr>
						<td><input type="text" style="width: 99%" name="eaf_er_comp_name[]"></td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><b>IMMEDIATE SUPERIOR</b></td>
					</tr>
					<tr>
						<td><i>NAME</i>:</td>
						<td><input type="text" style="width: 99%" name="eaf_er_superior[]"></td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><b>EMPLOYMENT DATES</b></td>
					</tr>
					<tr>
						<td><i>FROM:</i></td>
						<td width="50%"><input type="date" style="width: 99%;height:23px;" name="eaf_er_date_from[]"></td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><b>SALARY</b></td>
					</tr>
					<tr>
						<td><i>START</i>:</td>
						<td><input type="text" style="width: 99%;" name="eaf_er_salary_start[]"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="20%"style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><b>ADDRESS:</b></td>
						<td><input type="text" style="width: 99%;" name="eaf_er_comp_address[]"></td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><i>CONTACT #</i>:</td>
						<td width="49%"><input type="text" style="width: 99%;" name="eaf_er_superior_num[]"></td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><i>TO</i>:</td>
						<td width="50%"><input type="date" style="width: 99%;height:23px;"  name="eaf_er_date_to[]"></td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #CCC;">
				<table width="100%">
					<tr>
						<td><i>FINAL</i>:</td>
						<td><input type="text" style="width: 99%;" name="eaf_er_salary_final[]"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td rowspan="2" style="border:1px solid #CCC;">
				<b>TELEPHONE #: </b>
				<input type="text" style="width: 99%;" name="eaf_er_comp_num[]">
			</td>
			<td style="border:1px solid #CCC;">
				<b>POSITION</b> <input type="text" style="width: 99%;" name="eaf_er_position[]">
			</td>
			<td colspan="2" style="border:1px solid #CCC;">
				<b>REASON FOR LEAVING</b>
				<input type="text" style="width: 99%;" name="eaf_er_rfl[]">
			</td>
		</tr>
		<tr>
			<td colspan="3" style="border:1px solid #CCC;">
				<b>DUTIES &amp; RESPONSIBILITIES</b>
				<input type="text" style="width: 99%;" name="eaf_er_duties[]">
			</td>
		</tr>
	</table>
	</div>
</div>

<i><b>FOR TEACHING POSITION ONLY</b></i>
<div class="e_teaching" >

</div>
<table style="width: 100%;font-size: 11px;" class="table">
	<thead>
		<tr>
			<td style="border:1px solid #CCC;text-align: center"><b>INCLUSIVE DATES</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>SCHOOL</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>GRADE OR SUBJECT TAUGHT</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>SUPERIOR &amp; CONTACT #</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>SALARY</b></td>
			<td style="border:1px solid #CCC;text-align: center"><b>REASON FOR LEAVING</b></td>
			<td>&nbsp;</td>
		</tr>
	</thead>
	<tbody id="bodyTeaching">

		<tr>
			<td style="border:1px solid #CCC;text-align: center">
				<button type="button" class="btn btn-default date-picka" id="daterange-btna1" data-id="1">
						<i class="fa fa-calendar"></i> <span></span>
						<i class="fa fa-caret-down"></i>
				</button>
					<input type="hidden" id="starta" name="eaf_tp_date_from[]">
					<input type="hidden" id="enda" name="eaf_tp_date_to[]">				
			</td>
			<td style="border:1px solid #CCC;text-align: center"><input type="text" style="width: 99%;" name="eaf_tp_school[]"></td>
			<td style="border:1px solid #CCC;text-align: center"><input type="text" style="width: 99%;" name="eaf_tp_subject[]"></td>
			<td style="border:1px solid #CCC;text-align: center"><input type="text" style="width: 99%;" name="eaf_tp_superior_cont[]"></td>
			<td style="border:1px solid #CCC;text-align: center"><input type="text" style="width: 99%;" name="eaf_tp_salary[]"></td>
			<td style="border:1px solid #CCC;text-align: center"><input type="text" style="width: 99%;" name="eaf_tp_rfl[]"></td>
			<td><a href="#"><span class="glyphicon glyphicon-plus" id="addTeaching"></span></a></td>
		</tr>
	</tbody>
</table>

<i><b>EMPLOYMENT RECORD AT ACLC OR OTHER AMA GROUP OF COMPANIES</b></i>
<div class="e_emprec" >
	
</div>
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
		<tr>
			<td style="border:1px solid #CCC;text-align: center">
			<button type="button" class="btn btn-default date-pick" id="daterange-btn1" data-id="1">
						<i class="fa fa-calendar"></i> <span></span>
						<i class="fa fa-caret-down"></i>
				</button>
					<input type="hidden" id="start" name="eaf_erc_date_from[]">
					<input type="hidden" id="end" name="eaf_erc_date_to[]">
			</td>
			<td style="border:1px solid #CCC;text-align: center"><input name="eaf_prev_position[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_superior_cont[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_salary[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_rfl[]" type="text" style="width: 99%;"></td>
			<td style="text-align: center"><a href="#"><span class="glyphicon glyphicon-plus" id="addCompanies"></span></a></td>
		</tr>
	</tbody>
</table>

<i><b>TRAININGS AND SEMINARS</b></i>
<div class="e_training" >
	
</div>
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
		<tr>
			<td style="border:1px solid #CCC;"><input name="eaf_tas_title[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;"><input name="eaf_tas_name_loc[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;">
				<center>
				<button type="button" class="btn btn-default date-pick1b" id="daterange-btn1b" data-id="1" style="width:90%;">
						<i class="fa fa-calendar"></i> <span></span>
						<i class="fa fa-caret-down"></i>
				</button>
					<input type="hidden" id="startb" name="eaf_tas_date_from[]">
					<input type="hidden" id="endb" name="eaf_tas_date_to[]">
				</center>
			</td>
			<td><a href="#" id="addTraining"><span class="glyphicon glyphicon-plus" ></span></a></td>
		</tr>
	</tbody>
</table>
<i><b>MEMBERSHIP IN ORGANIZATIONS AND CLUBS</b></i>
<div class="e_orgs" >
	
</div>
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
		<tr>
			<td style="border:1px solid #CCC;"><input name="eaf_org_name[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;"><input name="eaf_org_position[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;">
				<center>
				<button type="button" class="btn btn-default date-pick2b" id="daterange-btn2b" data-id="1" style="width:90%;">
						<i class="fa fa-calendar"></i> <span></span>
						<i class="fa fa-caret-down"></i>
				</button>
					<input type="hidden" id="startc" name="eaf_org_date_from[]">
					<input type="hidden" id="endc" name="eaf_org_date_to[]">
				</center>
			</td>
			<td><a href="#" id="addOrganization" ><span class="glyphicon glyphicon-plus" ></span></a></td>
		</tr>
	</tbody>
</table>
<i><b>REFERENCES (Exclude relatives)</b></i>
<div class="e_references" >
	
</div>
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
		<tr>
			<td style="border:1px solid #CCC;"><input name="eaf_ref_name[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;"><input name="eaf_ref_comp_name[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;"><input name="eaf_ref_position[]" type="text" style="width: 99%;"></td>
			<td style="border:1px solid #CCC;"><input name="eaf_ref_contact[]" type="text" style="width: 99%;"></td>
			<td><a href="#" id="addReference"><span class="glyphicon glyphicon-plus" ></span></a></td>
		</tr>
	</tbody>
</table>
<div class="pull-right">
	<a href='<?= base_url('index.php/admin/employees/employee_application_sheet?employee_id=btn-2012-0213') ?>' target="blank" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
	<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
</div>
</form>
</div>
