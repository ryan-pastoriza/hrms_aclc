<?php
/**
 * @Author: gian
 * @Date:   2016-04-14 14:19:48
 * @Last Modified by:   gian
 * @Last Modified time: 2016-06-09 11:03:14
 */
?>
<script type="text/javascript">
	$(function(){

		$(document).on('change','#type',function(e){
			var val = $('#type').val();
			if(val == "one day"){
				$('#oneD').removeClass('hidden');
				$('#repeat').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
				$('#longE').addClass('hidden');
			}
			else if(val == "long event"){
				$('#longE').removeClass('hidden');
				$('#oneD').addClass('hidden');
				$('#repeat').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
			}
			else if(val == "repeat"){
				$('#repeat').removeClass('hidden');
				$('#oneD').addClass('hidden');
				$('#longE').addClass('hidden');
				

			}else{
				$('#repeat').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
				$('#oneD').addClass('hidden');
				$('#longE').addClass('hidden');
			}

			if($('#repeat').hasClass('hidden')){
				$('#monthly').addClass('hidden');
				$('#yearly').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
			}

		});




		$(document).on('change','#selRep',function(e){
			var val = $(this).val();

			if(val == "monthly"){
				$('#yearly').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
				$('#monthly').removeClass('hidden');
			}

			else if(val == "yearly"){
				$("#yearType").removeClass("hidden");
				$("#yearly").removeClass("hidden");
				$("#dynamic-text").removeClass("hidden");

				$('#monthly').addClass('hidden');
				$("#nString").trigger("click");
			}

			else{

				$("#yearType").addClass("hidden");
				$('#yearly').addClass('hidden');
				$('#monthly').addClass('hidden');
				$('#dynamic-text').addClass('hidden');

			}

			e.preventDefault();

		});

		$(document).on("click","#nString",function(e){

			if($(this).prop("checked")){
				$($(this).attr("checked","checked"));
				$("#sString").removeAttr("checked");
				$(this).val("date");
				$("#sString").removeAttr("value");
			}

		});

		$(document).on("click","#sString",function(e){
			if($(this).prop("checked")){
				$($(this).attr("checked","checked"));
				$("#nString").removeAttr("checked");
				$(this).val("string");
				$("#nString").removeAttr("value");
			}
		});



		$(document).on('change','#fixed',function(){
			if($(this).prop("checked")){
				$('#dynamic-text').fadeOut();
				$('#toDate').fadeIn();
				$(this).attr('checked','checked');
				$(this).val('fixed');
				$('#dynamic').removeAttr("checked");
			}
		});
		
		$(document).on('change','#dynamic',function(){
			if($(this).prop("checked")){
				$('#dynamic-text').fadeIn();
				$('#toDate').fadeOut();
				$(this).attr('checked','checked');
				$(this).val('dynamic');
				$('#fixed').removeAttr("checked");
			}
		});

		$(document).on('change','#pay',function(e){
			if($(this).prop("checked")){
				$('#pay').val(1);
				$(this).attr('checked','checked');
			}else{
				$(this).removeAttr("checked");
				$('#pay').val(0);
			}
		});

		$(document).on('change','#work',function(e){
			if($(this).prop("checked")){
				$('#work').val(1);
				$(this).attr('checked','checked');
			}else{
				$('#work').val(0);
				$(this).removeAttr("checked");
			}
		});
		

		// date timepicker
		$('#startDay').datetimepicker({
			format: 'YYYY-MM-DD' //its format
		});

		$('#dateYearly').datetimepicker({
			format:'YYYY-MM-DD'
		});

		$('#dateMonthly').datetimepicker({
			format:'YYYY-MM-DD'
		});

		$('#reportrange').daterangepicker({
			timepicker:false,
		},cb);

		$(document).on("change","#frm_one_d",function(e){
			$("one_d").val($(this).val());
			e.preventDefault();
		});
		$(document).on("change","#frm_monthly_d",function(e){
			$("monthly_d").val($(this).val());
			e.preventDefault();
		});

		// end date timepicker
		$(document).on("change","#yearly_date",function(){
			alert($(this).val());
		});

		$(document).click(function(){
	      	var y =  $('#yearly_date').val();

	      	if(y != ""){
	        	dateToWord(new Date(y));
	      	}

	    });	    

	});
	function cb(start, end) {
        $('#reportrange').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

	function dateToWord(d){
    	var dateNum 	= ['first','second','third','fourth','fifth'],
        	dateDays 	= ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'],
        	dateMonth 	= ['January','February','March','April','May','June','July','August','September','October','November','December'];
    	return $('#date_number').val(dateNum[Math.floor(d.getDate()/7.2)])+''+$('#date_day').val(dateDays[d.getDay()])+''+$('#date_month').val(dateMonth[d.getMonth()]);
  	}
</script>