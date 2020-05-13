

<script type="text/javascript">

  	$(document).ready(function() {

  		 $('#form').on('submit', function(a){
  		 	a.preventDefault();

  		 	$.ajax({
			    url: '<?php echo base_url("index.php/employee/cash_advance/request_form"); ?>',
			    type: "post",
			    data: new FormData(this),
			    dataType:"JSON",
			    contentType: false,
			    processData: false,
			    success: function(data)
			    {
			    	if(data.result == true){
			    		var callback = "<h4 style='color:#337ab7;'><b>Request sent successfuly.</b></h4>";
			    		$('.rqst-callback').html(callback);	
			    		$("#form").trigger('reset');
			    	}
			    }
			});
  		 });

  		 // toWords

  		 $('#reqAmount').on('change keyup', function(e) {
			var amount = $(this).val();
			var words = toWords(amount);
			$('[name=in_words]').val(words);
		});
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

	  	});
	
</script>