<script type="text/javascript">

	var autocomp;
	var count = 0;

$(function(){
	

	var tautocomplete = {
	                    columns: ['Name','Age','Department','Status'],
	                    norecord: "No Records Found",
	                    placeholder:"Select Employee",
	                    theme: "white",
	                    regex: "^[a-zA-Z0-9\b \, \s]+$",
	                    onchange: function(){
	                      empSelected = autocomp.id();
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

	 $(".timepicker").timepicker({
	    showInputs: false
	 });

	 $('#from-time').change(function(e) {
		var from = $('#from-time').val();
		var to = $('#to-time').val();
		var hrs = calculate_hours(from, to);
		$('#total-hours').val(hrs);
	});

	$('#to-time').change(function(e) {
		var from = $('#from-time').val();
		var to = $('#to-time').val();
		var hrs = calculate_hours(from, to);
		$('#total-hours').val(hrs);
	});

	var form_options = {
			clearForm: true,
			resetForm: true,
			beforeSubmit: function() {
				if(count > 0) {
					$('#btn_add').attr('disabled', true);
					return true;
				}
				return false;
			},
			success: function() {
				$('.added_row').each(function(k,v) {
					$(v).parent().parent().remove();
				})
				oTable.api().ajax.reload();
				$('#btn_add').attr('disabled', false);
			}
		};

	$('#form').ajaxForm(form_options);

});

//add row
	var remove_row = function(e){
		$(e).parent().parent().remove();
		count--;
	}
	var add_row = function(){
		var form = $('#tr-form');
		var empId = autocomp.id();
		var emp = autocomp.text();
		var date = form.find('#date').val();
		var fromTime = form.find('#from-time').val();
		var toTime = form.find('#to-time').val();
		var totalHours = form.find('#total-hours').val();
		var fromWorkShift = form.find('#from-work-shift').val();
		var toWorkShift = form.find('#to-work-shift').val();
		var purpose = form.find('#purpose').val();
		var actualHours = form.find('#actualHours').val();
		
		if(emp !== "" && date !== "" && fromTime !== "" && toTime !== "" && totalHours !== "" && fromWorkShift !== "" && toWorkShift !== "" && purpose !== '' && actualHours !== '') {
			$('#table-body').prepend("<tr> \
											<td><input type='hidden' name='id[]' value='"+empId+"'>"+ emp +"</td>\
											<td><input type='hidden' name='date[]' value='"+date+"'>"+ date +"</td>\
											<td><input type='hidden' name='fromTime[]' value='"+fromTime+"'>"+ fromTime +"</td>\
											<td><input type='hidden' name='toTime[]' value='"+toTime+"'>"+ toTime +"</td>\
											<td><input type='hidden' name='totalHours[]' value='"+totalHours+"'>"+ totalHours +"</td>\
											<td><input type='hidden' name='fromWorkShift[]' value='"+fromWorkShift+"'>"+ fromWorkShift +"</td>\
											<td><input type='hidden' name='toWorkShift[]' value='"+toWorkShift+"'>"+ toWorkShift + "</td>\
											<td><input type='hidden' name='purpose[]' value='"+purpose+"'>"+ purpose +"</td>\
											<td><input type='hidden' name='actualHours[]' value='"+actualHours+"'>"+ actualHours +"</td>\
											<td><a onclick='remove_row(this)' class='text-danger added_row'><i class='fa fa-minus'></i></a></td>\
										</tr>");
			count++;
			$('[autocomplete]').val('');
			$('#date').val('');
			$('#from-time').val('');
			$('#to-time').val('');
			$('#total-hours').val('');
			$('#from-work-shift').val('');
			$('#to-work-shift').val('');
			$('#purpose').val('');
			$('#actualHours').val('');
		}
		return false;
	}

	function calculate_hours(t1, t2) {
		var from = t1.split(':');
		var to = t2.split(':');
		var fromDaytime = t1.split(' ');
		var toDaytime = t2.split(' ');
		var fromHr = parseInt(from[0]);
		var toHr = parseInt(to[0]);
		var fromMin = parseInt(from[1]);
		var toMin = parseInt(to[1]);

		if(fromDaytime[1] === 'PM') {
			if(fromHr != 12) {
				fromHr += 12;
			}
		} else {
			if(fromHr == 12) {
				fromHr += 12;
			}
		}

		if(toDaytime[1] === 'PM') {
			if(toHr != 12) {
				toHr += 12;
			}
		} else {
			if(toHr == 12) {
				toHr += 12;
			}
		}

		var f = (fromHr * 60) + fromMin;
		var t = (toHr * 60) + toMin;
		var totalHrs = (t - f) / 60;
		var output = parseInt(totalHrs);

		if(output <= 0) {
			output = '';
		}
		return output;
	}

</script>