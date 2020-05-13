<script type="text/javascript">
	$(function(){
//@Author: ARIEL
		$(document).on('click','#addDependents',function(e){
			$('#bodyDependent').prepend('\
							<tr>\
								<td width="40%"><input type="text" style="width: 99%;" name="emp_dependent_name[]"></td>\
								<td width="20%"><input type="date" style="width: 99%;" class="added_dependent_birthdate" name="emp_dependent_birthdate[]"></td>\
								<td width="10%"><input type="text" style="width: 99%;" class="added_dependent_age" readonly></td>\
								<td width="20%"><input type="text" style="width: 99%;" name="emp_dependent_relationship[]"></td>\
								<td width="10%"><input type="checkbox" style="width: 99%" class="dependency"><input type="hidden" class="dependent_dependency" value="true" name="emp_dependent_dependency[]"></td>\
								<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
							</tr>\
						<script>\
							$(".dependency").bootstrapSwitch({\
								state: "true",\
								size: "mini",\
								onText: "Yes",\
								offText: "No",\
								offColor: "danger"\
							});\
						<\/script>');
			e.preventDefault();
		});

		$(document).on('click','#addEducationalBackground',function(e){
			$('#bodyEducationalBackground').prepend('<tr>\
														<td>\
															<select style="width: 99%;height: 26px;" name="ee_attainment[]">\
																<option>Elementary</option>\
																<option>High School</option>\
															</select>\
														</td>\
														<td>\
															<input type="text" style="width: 99%;" name="ee_school_name[]">\
															<input type="hidden" name="ee_course_taken[]">\
															<input type="hidden" name="ee_units_earned[]">\
															<input type="hidden" name="ee_ongoing_units[]">\
														</td>\
														<td><input type="number" min="0" style="width: 99%;" name="ee_year_graduated[]"></td>\
														<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
													</tr>');
		});

		$(document).on('click','#addEducationalBackground1',function(e){
			$('#bodyEducationalBackground1').prepend('<tr>\
									<td>\
										<select style="width: 99%;height: 26px;" name="ee_attainment[]">\
											<option>Undergrad</option>\
											<option>Graduate</option>\
											<option>Post Grad</option>\
											<option>TechVoc</option>\
										</select>\
									</td>\
									<td><input type="text" style="width: 99%;" name="ee_course_taken[]"></td>\
									<td><input type="text" style="width: 99%;" name="ee_school_name[]"></td>\
									<td><input type="number" min="0" style="width: 99%;" name="ee_units_earned[]"></td>\
									<td><input type="number" min="0" style="width: 99%;" name="ee_ongoing_units[]"></td>\
									<td><input type="number" min="0" style="width: 99%;" name="ee_year_graduated[]"></td>\
									<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
								</tr>');
			e.preventDefault();
		});

		$(document).on('click','#addEligibility',function(e){
			$('#bodyEligibility').prepend('<tr>\
									<td><input type="text" style="width: 99%;" name="emp_el_program[]"></td>\
									<td><input type="text" style="width: 99%;" name="emp_el_certificate_level[]"></td>\
									<td><input type="text" style="width: 99%;" name="emp_el_status[]"></td>\
									<td><input type="date" style="width: 99%;height: 26px;" name="emp_el_certificate_exp[]"></td>\
									<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
								</tr>');
			e.preventDefault();
		});

		$(document).on('click','#addProfessionalAffilation',function(e){
			$('#bodyProfessionalAffilation').prepend('<tr>\
									<td><input type="text" style="width: 99%;" name="emp_aff_org_name[]"></td>\
									<td><input type="text" style="width: 99%;" name="emp_aff_membership_type[]"></td>\
									<td><input type="text" style="width: 99%;" name="emp_aff_status[]"></td>\
									<td><input type="date" style="width: 99%;height: 26px;" name="emp_aff_membership_exp[]"></td>\
									<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
								</tr>');
			e.preventDefault();
		});

		$(document).on('click','#addSeminarTraining',function(e){
			$('#bodySeminarTraining').prepend('<tr>\
									<td><input type="text" style="width: 99%;" name="ets_title[]"></td>\
									<td><input type="date" style="width: 99%;height: 26px;" name="ets_date[]"></td>\
									<td><input type="text" style="width: 99%;" name="ets_venue[]"></td>\
									<td><input type="text" style="width: 99%;" name="ets_provider[]"></td>\
									<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
								</tr>');
			e.preventDefault();
		});

		$(document).on('click','#addSpouse',function(e){
			$('#bodySpouse').prepend('<div class="addedSpouse">\
									<table class="table">\
										<tr>\
											<td colspan="3">\
												<table style="width: 100%;">\
													<tr>\
														<td width="15%">Name of Spouse:</td>\
														<td><input type="text" style="width: 100%;" name="spouse_name[]"></td>\
														<td width="8%" style="padding-left:5px;">Age:</td>\
														<td><input type="text" style="width: 100%;" class="added_spouse_age" readonly></td>\
													</tr>\
												</table>\
											</td>\
										</tr>\
										<tr>\
											<td colspan="3">\
												<table style="width: 100%;">\
													<tr>\
														<td width="15%;">Date of Birth:</td>\
														<td><input type="date" style="width: 100%;" class="added_spouse_birth_date" name="spouse_birth_date[]"></td>\
														<td style="padding-left: 5px;" width="15%">Date of Marriage</td>\
														<td><input type="date" style="width: 100%;height: 26px;" name="spouse_date_of_marriage[]"></td>\
													</tr>\
												</table>\
											</td>\
										</tr>\
										<tr>\
											<td colspan="3">\
												<table style="width:100%;">\
													<tr>\
														<td width="15%">Occupation:</td>\
														<td><input type="text" style="width: 100%;" name="spouse_occupation[]"></td>\
														<td style="padding-left:5px;" width="15%">Employer:</td>\
														<td><input type="text" style="width: 100%;" name="spouse_employer[]"></td>\
													</tr>\
												</table>\
											</td>\
										</tr>\
										<tr>\
											<td colspan="3">\
												<table style="width: 100%;">\
													<tr>\
														<td width="15%">Employer\'s Address:</td>\
														<td colspan="2"><input type="text" style="width: 100%;" name="spouse_employer_address[]"></td>\
													</tr>\
												</table>\
											</td>\
											<td><a href="#" id="removeSpouse"><span class="glyphicon glyphicon-minus"></span></a></td>\
										</tr>\
										<tr><td colspan="3">&nbsp;</td></tr>\
									</table>\
								</div>');
			e.preventDefault();
		});

		$(document).on('click','#removeSpouse',function(e){
			$(this).closest('.addedSpouse').remove();
			e.preventDefault();
		});

		$(document).on('change', '#spouse_birth_date', function(e) {
			if($(this).val() !== '') {
				var age = moment().diff(moment($(this).val(), 'YYYY-MM-DD'), 'years');
			}
			$('#spouse_age').val(age);
		});

		$(document).on('change', '.added_spouse_birth_date', function(e) {
			if($(this).val() !== '') {
				var age = moment().diff(moment($(this).val(), 'YYYY-MM-DD'), 'years');
			}
			$(this).closest('.addedSpouse').find('.added_spouse_age').val(age);
		});

		$(document).on('change', '#dependent_birthdate', function(e) {
			if($(this).val() !== '') {
				var age = moment().diff(moment($(this).val(), 'YYYY-MM-DD'), 'years');
			}
			$('#dependent_age').val(age);
		});

		$(document).on('change', '.added_dependent_birthdate', function(e) {
			if($(this).val() !== '') {
				var age = moment().diff(moment($(this).val(), 'YYYY-MM-DD'), 'years');
			}
			$(this).closest('tr').find('.added_dependent_age').val(age);
		});

		var form_options = {
			beforeSubmit: function() {
				$('#addBtn').attr('disabled', true);
				if($('[name=employee_id]').val() !== '') {
					// tbl.ajax.reload();
					dep_oTable.api().ajax.reload();
					spouse_oTable.api().ajax.reload();
					educ1_oTable.api().ajax.reload();
					educ2_oTable.api().ajax.reload();
					eli_oTable.api().ajax.reload();
					aff_oTable.api().ajax.reload();
					ets_oTable.api().ajax.reload();
				}
			},
			success: function(data) {
				$('#addBtn').attr('disabled', false);
				clear_all();
				$('#dep_list').html(dep_tbl);
				dep_oTable = $('#dep_table').dataTable(dep_tableOptions);
				$('#spouse_list').html(spouse_tbl);
				spouse_oTable = $('#spouse_table').dataTable(spouse_tableOptions);
				$('#educ1_list').html(educ1_tbl);
				educ1_oTable = $('#educ1_table').dataTable(educ1_tableOptions);
				$('#educ2_list').html(educ2_tbl);
				educ2_oTable = $('#educ2_table').dataTable(educ2_tableOptions);
				$('#eli_list').html(eli_tbl);
				eli_oTable = $('#eli_table').dataTable(eli_tableOptions);
				$('#aff_list').html(aff_tbl);
				aff_oTable = $('#aff_table').dataTable(aff_tableOptions);
				$('#ets_list').html(ets_tbl);
				ets_oTable = $('#ets_table').dataTable(ets_tableOptions);
			}
		};
		$('#sis_form').ajaxForm(form_options);

		$('.dependency').bootstrapSwitch({
			state: 'true',
			size: 'mini',
			onText: 'Yes',
			offText: 'No',
			offColor: 'danger'
		});

		$(document).on('switchChange.bootstrapSwitch' ,'.dependency' , function(event, state) {
			$(this).closest('tr').find('.dependent_dependency').val(state);
		});

		$('#btnPrint').on('click', function() {
			$('[name=emp_id]').val($('[name=employee_id]').val());
			if($('[name=emp_id]').val() !== '') {
				$('#form_print').submit();
			}
		});
//END

		$(document).on('click','#removeChild',function(e){
			removeParent($(this));
			e.preventDefault();
		});

		var removeParent = function(elem){
			$(elem).closest('tr').remove();
			return false;
		}

	});

</script>