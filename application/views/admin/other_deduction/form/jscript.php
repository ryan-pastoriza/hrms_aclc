<script type="text/javascript">
//auto complete
	var autocomp;
	var count = 0;

	$(function() {
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
				oTable_record.api().ajax.reload();
				$('#btn_add').attr('disabled', false);
			}
		};

		$('#form').ajaxForm(form_options);

		$('[name=amt_total]').on('change keyup', function(e) {
			var amt_total = $('[name=amt_total]').val();
			var ded_duration = $("[name=ded_duration]").val();
			var term = $("[name=term]:checked").val();
			var output = deduction_per_term(term, ded_duration, amt_total);
			$('[name=ded_amt]').val(output);
		});

		$('[name=term]').change(function(e) {
			var amt_total = $('[name=amt_total]').val();
			var ded_duration = $("[name=ded_duration]").val();
			var term = $("[name=term]:checked").val();
			var output = deduction_per_term(term, ded_duration, amt_total);
			$('[name=ded_amt]').val(output);

			$('.emp-term-deduction-amt').each(function(k,v){
				var amt_total = $('.emp-amt-total').eq(k).val();
				var ded_duration = $("[name=ded_duration]").val();
				var term = $("[name=term]:checked").val();
				var output = deduction_per_term(term, ded_duration, amt_total);
				$(v).val(output);
			});
		});

		$('[name=ded_duration]').on('change keyup', function(e) {
			var amt_total = $('[name=amt_total]').val();
			var ded_duration = $("[name=ded_duration]").val();
			var term = $("[name=term]:checked").val();
			var output = deduction_per_term(term, ded_duration, amt_total);
			$('[name=ded_amt]').val(output);

			$('.emp-term-deduction-amt').each(function(k,v){
				var amt_total = $('.emp-amt-total').eq(k).val();
				var ded_duration = $("[name=ded_duration]").val();
				var term = $("[name=term]:checked").val();
				var output = deduction_per_term(term, ded_duration, amt_total);
				$(v).val(output);
			});
		});

		$(document).on('change keyup','.emp-amt-total',function(e) {
			var amt_total = $(this).parent().parent().find('.emp-amt-total').val();
			var ded_duration = $("[name=ded_duration]").val();
			var term = $("[name=term]:checked").val();
			var output = deduction_per_term(term, ded_duration, amt_total);
			$(this).parent().parent().find('.emp-term-deduction-amt').val(output);
		});

		function deduction_per_term(term, duration, amount) {
			amount = amount.replace(/[^0-9.]/g, '');
			var output = '';
			if(term === 'Monthly') {
				output = parseFloat(amount) / parseInt(duration);
			} else {
				output = parseFloat(amount) / (parseInt(duration) * 2);
			}
			if(isNaN(output)) {
				return '';
			}
			return output;
		}

	});

//add row
	var remove_row = function(e) {
		$(e).parent().parent().remove();
		count--;
	}
	var add_row = function() {
		var form = $('#tr-form');

		var id = autocomp.id();
		var emp = autocomp.text();
		var amt_total = form.find('[name=amt_total]').val();
		var ded_amt = form.find('[name=ded_amt]').val();
		var ded_duration = $("[name=ded_duration]").val();

		if(autocomp.text() !== "" && amt_total !== "" && ded_amt !== "" && amt_total != 0 && ded_amt != 0 && ded_duration != 0) {
			$('#table-body').prepend("<tr> \
											<td><input type='hidden' name='emp-id[]' value='"+id+"''>"+ emp +"</td>\
											<td><input class='emp-amt-total form-control' min='0' name='emp-amt-total[]' step='any' type='number' value='"+ amt_total +"' required></td>\
											<td><input class='emp-term-deduction-amt form-control' min='0' type='number' step='any' name='emp-term-deduction-amt[]' value='"+ ded_amt +"' required></td>\
											<td><a onclick='remove_row(this)' class='text-danger added_row'><i class='fa fa-minus'></i></a></td>\
										</tr>");
			count++;
			$('[autocomplete]').val('');
			$('[name=amt_total]').val('');
			$('[name=ded_amt]').val('');
		}
		return false;
	}

</script>