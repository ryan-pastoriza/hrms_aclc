<script type="text/javascript">

	var autocomp;

	$(function(){
	  var tautocomplete = {
	                        columns: ['Name','Age','Department','Status'],
	                        norecord: "No Records Found",
	                        placeholder:"Select Employee",
	                        theme: "white",
	                        regex: "^[a-zA-Z0-9\b \, \s]+$",
	                        onchange: function(){
	                          	empSelected = autocomp.id();
	                          	$('[name=emp_id]').val(autocomp.id());
	                        	$('[name=dept]').val(tautocomplete.department());
	                        	$('[name=pos]').val(tautocomplete.data()[0].position);
	                        	$('#hired_date').html(tautocomplete.data()[0].hired_date);
	                        	$('#vacLeaveEarned').html(tautocomplete.data()[0].earned);
	                        	$('#vacLeaveUsed').html(tautocomplete.data()[0].used);
	                        	$('#vacLeaveBalance').html(tautocomplete.data()[0].balance);
	                        	$('#SLEarned').html(tautocomplete.data()[0].sick_earned);
	                        	$('#SLUsed').html(tautocomplete.data()[0].sick_used);
	                        	$('#SLBalance').html(tautocomplete.data()[0].sick_balance);
	                        	$('#SILEarned').html(tautocomplete.data()[0].sil_earned);
								$('#SILUsed').html(tautocomplete.data()[0].sil_used);
								$('#SILBalance').html(tautocomplete.data()[0].sil_balance);
								$('#ml_earned').html(tautocomplete.data()[0].ml_earned);
								$('#ml_used').html(tautocomplete.data()[0].ml_used);
								$('#ml_balance').html(tautocomplete.data()[0].ml_balance);
								if(tautocomplete.data()[0].gender == "Male"){
									$('.menstrual-leave').addClass('hidden')
									$('#removeML').addClass('hidden')
									$('#ml_earned').addClass('hidden')
									$('#ml_used').addClass('hidden')
									$('#ml_balance').addClass('hidden')
								}else{
									$('.menstrual-leave').removeClass('hidden')
									$('#removeML').removeClass('hidden')
									$('#ml_earned').removeClass('hidden')
									$('#ml_used').removeClass('hidden')
									$('#ml_balance').removeClass('hidden')

									
									
								}

	                        	// console.log(tautocomplete.data()[0]);
	                        },
	                        department: function(){
	                        	return tautocomplete.data()[0].department;
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
	
		var form_options = {
			clearForm: true,
			resetForm: true,
			beforeSubmit: function() {
				if($('[name=emp_id]').val() !== '') {
					$('#btn_add').attr('disabled', true);
					return true;
				}
				return false;
			},
			success: function() {
				oTable.api().ajax.reload();
				$('#btn_add').attr('disabled', false);
				$("[name=others]").hide();
				$("[name=others]").attr('required', false);
			}
		};
		$('#form').ajaxForm(form_options);

		
		$("[name=others]").hide();
		$("[name=availed]").change(function() {
			if($(this).val() === "Others") {
				$("[name=others]").show();
				$("[name=others]").attr('required', true);
			} else {
				$("[name=others]").hide();
				$("[name=others]").attr('required', false);
			}
		});

		$(".timepicker").timepicker({
		    showInputs: false,
		    minuteStep: 1
		});

	})

</script>