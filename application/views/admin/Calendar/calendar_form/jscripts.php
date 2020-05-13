<?php
/**
 * @Author: gian
 * @Date:   2016-04-14 14:19:48
 * @Last Modified by:   Gian
 * @Last Modified time: 2017-05-05 10:29:59
 */
?>
<script type="text/javascript">
	$(function(){

		$("#event-type").select2({
			tags: true,
		});
		// var newStateVal = "";
		// var newState = new Option(newStateVal, newStateVal, true, true);
		// $("#event-type").append(newState).trigger('change');


		//sa stack overvlow gikuha hahahahahaha
		$("#btn-add-state").on("click", function(){
	      	var newStateVal = $("#new-state").val();
	      	// Set the value, creating a new option if necessary
	      	if ($("#event-type").find("option[value='" + newStateVal + "']").length) {
	        	$("#event-type").val(newStateVal).trigger("change");
	      	} else { 
	        	// Create the DOM option that is pre-selected by default
	        	var newState = new Option(newStateVal, newStateVal, true, true);
	        	// Append it to the select
	        	$("#event-type").append(newState).trigger('change');
	      	} 
	    });  

		$(document).on('change','#type',function(e){
			var val = $('#type').val();
			if(val == "one day"){
				$('#oneD').removeClass('hidden');
				$('#timeSet').removeClass('hidden');
				$('#repeat').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
				$('#longE').addClass('hidden');
				$('#yearType').addClass('hidden');
			}
			else if(val == "long event"){
				$('#longE').removeClass('hidden');
				$('#timeSet').removeClass('hidden');
				$('#oneD').addClass('hidden');
				$('#repeat').addClass('hidden');
				$('#dynamic-text').addClass('hidden');
				$('#yearType').addClass('hidden');
			}
			else if(val == "repeat"){
				$('#repeat').removeClass('hidden');
				$('#timeSet').addClass('hidden');
				$('#oneD').addClass('hidden');
				$('#longE').addClass('hidden');
				

			}else{
				$('#timeSet').addClass('hidden');
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
				$('#timeSet').removeClass('hidden');
				$("#yearType").addClass("hidden");
			}

			else if(val == "yearly"){
				$("#yearType").removeClass("hidden");
				$("#yearly").removeClass("hidden");
				$('#timeSet').removeClass('hidden');
				$("#dynamic-text").removeClass("hidden");
				$('#nString').trigger('click');
				$('#monthly').addClass('hidden');
				$("#nString").trigger("click");
			}

			else{
				$('#timeSet').addClass('hidden');
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
			format: 'YYYY/MM/DD',
		},cb);
		$(document).on("change","#reportrange",function(e){

			var longDate = $(this).val();

			var splitDate = longDate.split(" - "); //split  " - "

			var from = splitDate[0].replace(/\//g,"-"); // change fowardslash to "-"
			var to = splitDate[1].replace(/\//g,"-"); // change fowardslash to "-"

			$("#long_from").val(from);
			$("#long_to").val(to);

			e.preventDefault();
		});

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
			$("#yearly_d").val($(this).val());
		});

		$(document).click(function(){
	      	var y =  $('#yearly_date').val();
	      	var ond = $('#from_one_d').val();
	      	var month = $("#monthly_d").val();
	      	if(y != ""){
	        	dateToWord(new Date(y));
	      	}
	      	if(ond != ""){
	      		dateToWord(new Date(ond));
	      	}
	      	if(month != ""){
	      		dateToWord(new Date(month));
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