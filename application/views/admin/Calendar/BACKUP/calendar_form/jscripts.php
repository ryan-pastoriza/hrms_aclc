<?php
/**
 * @Author: gian
 * @Date:   2016-04-14 14:19:48
 * @Last Modified by:   gian
 * @Last Modified time: 2016-05-25 09:07:27
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
				$('#dynamic-text').addClass('hidden');

				//check the yearly event | holiday
				$('#chk-yearly').trigger('click');

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
				$('#yearly').removeClass('hidden');
				$('#dynamic-text').removeClass('hidden');
				$('#monthly').addClass('hidden');
			}else{
				$('#yearly').addClass('hidden');
				$('#monthly').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
			}

			e.preventDefault();
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
			locale:{
				format:"MMMM, dd yyyy"
			}
		},cb);


		// end date timepicker

		$(document).click(function(){
	      	var y =  $('[name="yearly"]').val();

	      	if(y != ""){
	        	dateToWord(new Date(y));
	      	}

	    });	    

	});
	function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    	$('[name="longEvent"]').val(start.format('MMMM D, YYYY') + '-' + end.format('MMMM D, YYYY'));
    }

	function dateToWord(d){
    	var dateNum 	= ['first','second','third','fourth','fifth'],
        	dateDays 	= ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'],
        	dateMonth 	= ['January','February','March','April','May','June','July','August','September','October','November','December'];
    	return $('#date_number').val(dateNum[Math.floor(d.getDate()/7.2)])+''+$('#date_day').val(dateDays[d.getDay()])+''+$('#date_month').val(dateMonth[d.getMonth()]);
  	}
</script>