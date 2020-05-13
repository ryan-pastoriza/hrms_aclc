<script type="text/javascript">
$(function(){
	$('#search-payslip-form').ajaxForm({
		beforeSubmit: function(){
			$('#payslip-view').css({
								opacity: '0.5'
								});
		},
		success: function(r){
			$('#payslip-view').html(r).css({
								opacity: '1'
								});
		}
	});
})


	var view_payslip = function(){
		var selectors = $('#search-payslip-form').serializeArray();
		var proll_month;
		var proll_year;
		var proll_date;


		$(selectors).each(function(k,v){
			if (v.value == "") {
				return false;
			}
			v.name = v.value;
		})

		$('#search-payslip-form').trigger('submit');
	}
</script>