<script type="text/javascript">
	
	var data_selected = [];
	var data_selected_purpose = [];
	var selected_emp;

	$(function() {
		$('#from').attr('readonly',true);
				$("#others").hide();
		// $('#to').attr('disabled',true);

		// $('#select_purpose').attr('disabled',true);
		$('#from_purpose').attr('readonly',"readonly");
		// $('#to_purpose').attr('disabled',true);
		$('#dropDept').addClass("hidden")

		var autocomp;
		var tautocomplete = {
            columns: ['Name','Age','Department','Status'],
            norecord: "No Records Found",
            placeholder:"Select Employee",
            theme: "white",
            regex: "^[a-zA-Z0-9\b \, \s]+$",
            onchange: function(){
            	$('[name=action]').removeAttr('disabled');

            	// $('#regular').prop('checked',true);
            	$('#regular').filter('[value=Regularization]').prop('checked', true).trigger('click');
				$('[name=department]').val(tautocomplete.data()[0].department.charAt(0).toUpperCase()+ tautocomplete.data()[0].department.slice(1));
				$('[name=position]').val(tautocomplete.data()[0].position);
				var d = new Date(tautocomplete.data()[0].hired_date);
				var m = d.getMonth();
				var da = d.getDate();
				var y = d.getFullYear();
				var month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
				var date_hired = month[m] + " "+ da +", "+y
				selected_emp = tautocomplete.data()[0];
				$('[name=date_hired]').val(date_hired)
				$('[name=pagibig').val(tautocomplete.data()[0].pagibig)
				$('[name=phic').val(tautocomplete.data()[0].philhealth)
				$('[name=tin').val(tautocomplete.data()[0].tin)
				$('[name=sss').val(tautocomplete.data()[0].sss)
				$('[name=tax_exemption').val(tautocomplete.data()[0].tax)
				$('[name=atm_acct_no').val(tautocomplete.data()[0].atm)
				$('[name=act_be_taken]').val(tautocomplete.data()[0].employment_type)
				$('[name=emp_rate]').val(tautocomplete.data()[0].employment_rate)
				$('[name=employee_id]').val(autocomp.id())
				$('[name=employment]').each(function() {
					$(this).prop('checked', false);
				});
				// console.log(tautocomplete.data()[0].employment_type)
				$('[name=employment]').filter('[value='+tautocomplete.data()[0].employment_type+']').prop('checked', true);
            	$('#regular').trigger('click');
            },
            data: function () {
                var data = <?= $allEmp ?>;
                var filterData = [];
                var searchData = eval("/" + autocomp.searchdata() + "/gi");
                $.each(data, function (i, v) {
                    if (v.fullName.search(new RegExp(searchData)) != -1) {
                        filterData.push(v);
                    }
                });
                return filterData;
              }
          };
		autocomp = $('#searchEmp').tautocomplete(tautocomplete);

		if($('#searchEmp').val() == ""){
			$('[name=action]').attr('disabled','true');
		}

		$(document).on('click', '#add-action-btn', function(event) {
			if(typeof(selected_emp) !== "undefined"){
				var selectedAction = $('#select_action').val();

				if( selectedAction != 0){

				var toVal = "";
				var disabled = "";
				var preVal = ""

				if(selectedAction == 2){
					toVal = $('#dropDept option:selected').text();
				}
				else if(selectedAction == 1){
					toVal = $('#to-emp-stat').val();
				}
				else{
					toVal = $('#to').val();
				}
				if(parseFloat(selectedAction) < 7){
					disabled = "readonly='readonly'";
					// toVal = $('#to').val();
					// switch(select_action){
					// 	case '1':
					// 		preVal = selected_emp.employment_type;
					// 	break;

					// }
				}
				else{
					disabled = "";
				}

				$('#actions-taken').prepend("<tr>\
												<td>\
													<input type='text' class='form-control' parent-val='"+$('#select_action').val()+"' name='action[]' value='"+$('#select_action option:selected').text()+"'> \
												</td>\
												<td>\
													<input type='text' class='form-control' "+disabled+" name='current[]' value='"+$('#from').val()+"'> \
												</td>\
												<td>\
													<input type='text' class='form-control' name='tos[]' value='"+toVal+"'> \
												</td>\
												<td>\
													<button type='button' class='btn btn-danger' remove-act-btn><i class='fa fa-minus'></i></button>\
												</td>\
											</tr>");
				$('#to').val('');
				$('#from').val('');
				$('#select_action option:selected').attr('disabled','disabled');
				$('#select_action').val(0);
				}
			}
		});

		$(document).on('change','#select_action',function(){
			var selectedVal = $('#select_action').val();
			switch(selectedVal){
				case '1':
					$('#from').val(selected_emp.employment_type);
					$('#from').attr('readonly',true);

				break;
				case '6':
					$('#from').val(selected_emp.emp_rate).attr('disabled','disabled');
					$('#from').attr('readonly',true);
				break;
				default:
					$('#from').removeAttr('readonly');
				break;
			}

			if(selectedVal == 2){
				$('#from').attr('readonly',true);
				$('[name=from]').val($('[name=department]').val())
				$('#to').addClass('hidden');
				$('#dropDept').removeClass("hidden");
				$('#to-emp-stat').addClass('hidden');
			}
			else if(selectedVal == 1){
				$('#dropDept').addClass('hidden');
				$('#to').addClass('hidden');
				$('#to-emp-stat').removeClass('hidden');
			}
			else if(selectedVal == 6){
				$('#from').attr('readonly',true);
				$("#from").val($('[name=emp_rate]').val())
			}
			else{
				$('#to').removeClass('hidden')
				$('#dropDept').addClass("hidden")
					$('#from').removeAttr('readonly');
				$('#to-emp-stat').addClass('hidden');
			}
		});


		$(document).on('change','[others-checkbox]', function(){
			if($(this).prop('checked')){
				$("#others").show();
				return false;
			}
			$("#others").hide();
		})

		$('textarea').on('keypress', function(e) {
			if(e.keyCode == 13) {
				return false;
			}
		});

		var form_options = {
			resetForm: true,
			beforeSubmit: function() {
				if($('[name=employee_id]').val() === '') {
					return false;
				}
				$('#btnSave').attr('disabled', true);
			},
			success: function(data) {
				console.log(data);
				$('#notifications').append(data.msg);
				$("#others").hide();
				$("[name=others]").attr('required', false);
				$("#contractual").hide();
				$('.added_row').remove();
				$('#btnSave').attr('disabled', false);
				$('#select_action option').show().attr('disabled', false);
				$('#select_purpose option').show().attr('disabled', false);
				data_selected = [];
				data_selected_purpose = [];
				$('#default_row').show();
				$('#default_row_purpose').show();
				oTable.api().ajax.reload();
			}
		};
		$('#form').ajaxForm(form_options,{data:"JSON"});
	});


	$(document).on('click','[remove-act-btn]',function(){
		var selectorVal = $(this).closest('tr').find('[parent-val]');
		selectorVal = $(selectorVal).attr('parent-val');
		$(this).closest('tr').remove();
		$('#select_action option[value='+selectorVal+']').removeAttr('disabled');
	})
	
	var remove_row = function(e){
		var a = $(e).attr('name');
		data_selected.splice(data_selected.indexOf(a), 1);
		$('#select_action option').filter('option[value='+a+']').show().attr('disabled', false);
		$('#default_row').show();
		$(e).parent().parent().remove();
	}
	var remove_row_purpose = function(e){
		var a = $(e).attr('name');
		data_selected_purpose.splice(data_selected_purpose.indexOf(a), 1);
		$('#select_purpose option').filter('option[value='+a+']').show().attr('disabled', false);
		$('#default_row_purpose').show();
		$(e).parent().parent().remove();
	}
	var add_row = function(e){	
		if($('#select_action').val() != 0 && $('#from').val() !== '' && $('#to').val() !== '') {
			if($('#select_action option:enabled').length == 2) {
				$('#default_row').hide();
			}
			data_selected.push($('#select_action').val());
			for(var x=0; x< data_selected.length; x++) {
				$('#select_action option').filter('option[value='+data_selected[x]+']').hide().attr('disabled', true);
			}
		} else {
			return false;
		}
		$(e).closest('.table-body').prepend("<tr class='added_row'>\
							<td><input style='border: 0px;' type='text' name='select_action[]' value='"+$('#select_action option:selected').text()+"' readonly></td>\
							<td><input style='border: 0px;' type='text' name='from[]' value='"+$('#from').val()+"' readonly></td>\
							<td><input style='border: 0px;' type='text' name='to[]' value='"+$('#to').val()+"' readonly></td>\
							<td class='text-center'><a onclick='remove_row(this)' name='"+$('#select_action option:selected').val()+"' class='text-danger'><i class='fa fa-minus'></i></a></td>\
						</tr>");

		$('#select_action').val("0");
		$('#from').val("");
		$('#to').val("");
		return false;
	}

	var add_row_purpose = function(e){
		if($('#select_purpose').val() != 0 && $('#from_purpose').val() !== '' && $('#to_purpose').val() !== '') {
			if($('#select_purpose option:enabled').length == 2) {
				$('#default_row_purpose').hide();
			}
			data_selected_purpose.push($('#select_purpose').val());
			for(var x=0; x< data_selected_purpose.length; x++) {
				$('#select_purpose option').filter('option[value='+data_selected_purpose[x]+']').hide().attr('disabled', true);
			}
		} else {
			return false;
		}
		$(e).closest('.table-body').prepend("<tr class='added_row'>\
						<td><input style='border: 0px;' type='text' name='select_purpose[]' value='"+$('#select_purpose option:selected').text()+"' readonly></td>\
						<td><input style='border: 0px;' type='text' name='from_purpose[]' value='"+$('#from_purpose').val()+"' readonly></td>\
						<td><input style='border: 0px;' type='text' name='to_purpose[]' value='"+$('#to_purpose').val()+"' readonly></td>\
						<td class='text-center'><a onclick='remove_row_purpose(this)' name='"+$('#select_purpose option:selected').val()+"' class='text-danger'><i class='fa fa-minus'></i></a></td>\
					</tr>");
		$('#select_purpose').val("0");
		$('#from_purpose').val("");
		$('#to_purpose').val("");
		return false;
	}
</script>