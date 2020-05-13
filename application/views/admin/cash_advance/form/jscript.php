<script type="text/javascript">

	

	$(function(){
		
		var autocomp;
		var tautocomplete = {
		                    columns: ['Name','Age','Department','Status'],
		                    norecord: "No Records Found",
		                    placeholder:"Select Employee",
		                    theme: "white",
		                    regex: "^[a-zA-Z0-9\b \, \s]+$",
		                    onchange: function(){
		                      empSelected = autocomp.id();
		                      $('[name=dept]').val(tautocomplete.department());
		                      console.log(tautocomplete.emp_position());
	                          $('[name=pos]').val(tautocomplete.emp_position());
		                      $('[name=emp_id]').val(autocomp.id());
		                    },
		                    department: function(){
		                    	return tautocomplete.data()[0].department;
		                    },
		                    emp_position : function(){
		                    	return tautocomplete.data()[0].position;
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

		$('#reqAmount').on('change keyup', function(e) {
			var amount = $(this).val();
			var words = toWords(amount);
			$('[name=in_words]').val(words);
		});

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
			}
		};
		$('#form').ajaxForm(form_options);

	})

	function toWords(s) {
		var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
		var dg = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
		var tn = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
		var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
	    s = s.toString();
	    s = s.replace(/[\, ]/g, '');
	    if (s != parseFloat(s)) return 'Input a number';
	    var x = s.indexOf('.');
	    if (x == -1) x = s.length;
	    if (x > 15) return 'Too big';
	    var n = s.split('');
	    var str = '';
	    var sk = 0;
	    for (var i = 0; i < x; i++) {
	        if ((x - i) % 3 == 2) {
	            if (n[i] == '1') {
	                str += tn[Number(n[i + 1])] + ' ';
	                i++;
	                sk = 1;
	            } else if (n[i] != 0) {
	                str += tw[n[i] - 2] + ' ';
	                sk = 1;
	            }
	        } else if (n[i] != 0) {
	            str += dg[n[i]] + ' ';
	            if ((x - i) % 3 == 0) str += 'Hundred ';
	            sk = 1;
	        }
	        if ((x - i) % 3 == 1) {
	            if (sk) str += th[(x - i - 1) / 3] + ' ';
	            sk = 0;
	        }
	    }
	    if (x != s.length) {
	        var y = s.length;
	        str += 'point ';
	        for (var i = x + 1; i < y; i++)  { //str += dg[n[i]] + ' ';
	    		if ((y - i) % 3 == 2) {
		            if (n[i] == '1') {
		                str += tn[Number(n[i + 1])] + ' ';
		                i++;
		                sk = 1;
		            } else if (n[i] != 0) {
		                str += tw[n[i] - 2] + ' ';
		                sk = 1;
		            }
		        } else if (n[i] != 0) {
		            str += dg[n[i]] + ' ';
		            if ((y - i) % 3 == 0) str += 'Hundred ';
		            sk = 1;
		        }
		        if ((y - i) % 3 == 1) {
		            if (sk) str += th[(y - i - 1) / 3] + ' ';
		            sk = 0;
		        }
	    	}
	    }	
	    return str.replace(/\s+/g, ' ');
	}

</script>