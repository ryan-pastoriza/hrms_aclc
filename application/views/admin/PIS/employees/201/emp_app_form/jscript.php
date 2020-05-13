<?php
/**
 * @Author: gian
 * @Date:   2016-03-31 16:36:58
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-10 11:25:52
 */
?>
<script type="text/javascript">
	var count = 1;
	var counta = 1;
	var countb = 1;
	var countc = 1;
	var dateId  = 'daterange-btn1 span, #daterange-btna1 span, #daterange-btn1b span, #daterange-btn2b span';
	var inputIdStart  = 'input#start, input#starta, input#startb, input#startc';
	var inputIdEnd  = 'input#end, input#enda, input#endb, input#endc';
	$(function(){

$('.date-pick').click(function(){
	inputIdStart = 'input#start';
	inputIdEnd = 'input#end';
	dateId = 'daterange-btn1 span';
});
$('.date-picka').click(function(){
	inputIdStart = 'input#starta';
	inputIdEnd = 'input#enda';
	dateId = 'daterange-btna1 span';
});
$('.date-pick1b').click(function(){
	inputIdStart = 'input#startb';
	inputIdEnd = 'input#endb';
	dateId = 'daterange-btn1b span';
});
$('.date-pick2b').click(function(){
	inputIdStart = 'input#startc';
	inputIdEnd = 'input#endc';
	dateId = 'daterange-btn2b span';
});

	    function cb(start, end) {
	    	$('#'+ dateId).html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	    	$(inputIdStart).val(start.format('MMMM D, YYYY'));
	    	$(inputIdEnd).val(end.format('MMMM D, YYYY'));	
	    }

	    cb(moment().subtract(29, 'days'), moment());

	    $('#daterange-btn1').daterangepicker({
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    $('#daterange-btna1').daterangepicker({
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    $('#daterange-btn1b').daterangepicker({
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    $('#daterange-btn2b').daterangepicker({
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    //  DATE RANGE PICKER

		$(document).on('click','#addRelative',function(e){
			$('#parentRelative').prepend('<tr>\
				<td width="30%">DO YOU HAVE RELATIVES OR FAMILY MEMBERS WORKING FOR ACLC?</td><td><div class="checkbox">\
				<label><input type="radio"> YES</label><label><input type="radio"> NO</label></div></td>\
				<td>NAME OF RELATIVE<input name="eaf_relative_name[]" type="text" style="width: 99%"></td>\
				<td>RELATIONSHIP<input name="eaf_relative_relationship[]" type="text" style="width: 99%"></td>\
				<td>POSITION &amp; DEPARTMENT<input name="eaf_relative_position[]" type="text" style="width: 99%"></td>\
				<td><br />&nbsp;<a href="#" id="removeChild" class="danger"><span class="glyphicon glyphicon-minus"></span></a></td></tr>');
			e.preventDefault();
		});
		$(document).on('click','#addSpouse',function(e){
			$('#parentSpouse').prepend('<tr><td>NAME OF SPOUSE<input name="eaf_spouse_name[]" type="text" style="width:99%;" /></td><td>DATE OF BIRTH (SPOUSE)<input name="eaf_spouse_dob[]" type="date" style="width:99%;height:23px;" /></td><td>OCCUPATION (SPOUSE)<input name="eaf_spouse_occupation[]" type="text" style="width:99%;" /></td><td>TELEPHONE #<input name="eaf_spouse_contact_num[]" type="text" style="width:99%;" /></td><td><br />&nbsp;<a href="#" id="removeChild" class="danger"><span class="glyphicon glyphicon-minus"></span></a></td></tr>');
			e.preventDefault();
		});
		$(document).on('click','#addChildren',function(e){
			$('#parentChildren').prepend('<tr><td>NAME OF CHILDREN<input name="eaf_child_name[]" type="text" style="width:99%;" /></td><td>DATE OF BIRTH<input name="eaf_child_dob[]" type="date" style="width:100%;height:23px;" /></td><td><br />&nbsp;<a href="#" id="removeChild" class="danger"><span class="glyphicon glyphicon-minus"></span></a></td></tr>')
			e.preventDefault();
		});

		$(document).on('click','#addEducationalBackground',function(e){
			$('#parentEducational').prepend('<tr><td width="15%" style="border:1px solid #CCC;"><select name="eaf_educ_school_type[]" select="selected" style="height:23px;width: 100%"><option>-SELECT-</option><option>ELEMENTARY</option><option>HIGH SCHOOL</option><option>VOCATIONAL SCHOOL</option><option>COLLEGE</option><option>GRADUATE SCHOOL (MASTER)</option><option>GRADUATE SCHOOL (DOCTORATE)</option></select></td><td width="20%" style="border:1px solid #CCC;"><input name="eaf_educ_school_name[]" type="text" style="width: 100%;"></td><td width="10%" style="border:1px solid #CCC;"><input name="eaf_educ_degree[]" type="text" style="width: 100%;"></td><td width="20%" style="border:1px solid #CCC;"><center><input name="eaf_educ_from[]" type="date" style="height: 23px"> - <input name="eaf_educ_to[]" type="date" style="height: 23px"></center></td><td width="10%" style="border:1px solid #CCC;"><input name="eaf_educ_honors[]" type="text" style="width:80%;"><a href="#" id="removeChild" class="danger"><span class="glyphicon glyphicon-minus"></span></a></td></tr>')
			e.preventDefault();
		})

		$(document).on('click','#addEmploymentRecord',function(e){
			$('#bodyEmployment').prepend('<div><a href="#" id="addEmploymentRecord"style="float:right;"><b>Add Employment Record</b> <span class="glyphicon glyphicon-plus" title="Add Employment Record"></span></a><table class="table" style="font-size:11px;border:1px solid #CCC;"><tr style="border:1px solid #CCC;"><td width="20%" style="border:1px solid #CCC;"><table width="100%"><tr><td><b>COMPANY NAME:</b></td><td><input type="text" style="width: 99%" name="eaf_er_comp_name[]"></td></tr></table>\</td><td style="border:1px solid #CCC;"><table width="100%"><tr><td><b>IMMEDIATE SUPERIOR</b></td></tr><tr><td><i>NAME</i>:</td><td><input type="text" style="width: 99%" name="eaf_er_superior[]"></td></tr></table></td><td style="border:1px solid #CCC;"><table width="100%"><tr><td><b>EMPLOYMENT DATES</b></td></tr><tr><td><i>FROM:</i></td><td width="50%"><input type="date" style="width: 99%;height:23px;" name="eaf_er_date_from[]"></td></tr></table></td><td style="border:1px solid #CCC;"><table width="100%"><tr><td><b>SALARY</b></td></tr><tr><td><i>START</i>:</td><td><input type="text" style="width: 99%;" name="eaf_er_salary_start[]"></td></tr></table></td></tr><tr><td width="20%"style="border:1px solid #CCC;"><table width="100%"><tr><td><b>ADDRESS:</b></td><td><input type="text" style="width: 99%;" name="eaf_er_comp_address[]"></td></tr></table></td><td style="border:1px solid #CCC;"><table width="100%"><tr><td><i>CONTACT #</i>:</td><td width="49%"><input type="text" style="width: 99%;" name="eaf_er_superior_num[]"></td></tr></table></td><td style="border:1px solid #CCC;"><table width="100%"><tr><td><i>TO</i>:</td><td width="50%"><input type="date" style="width: 99%;height:23px;"  name="eaf_er_date_to[]"></td></tr></table></td><td style="border:1px solid #CCC;"><table width="100%"><tr><td><i>FINAL</i>:</td><td><input type="text" style="width: 99%;" name="eaf_er_salary_final[]"></td></tr></table></td></tr><tr><td rowspan="2" style="border:1px solid #CCC;"><b>TELEPHONE #: </b><input type="text" style="width: 99%;" name="eaf_er_comp_num[]"></td><td style="border:1px solid #CCC;"><b>POSITION</b> <input type="text" style="width: 99%;" name="eaf_er_position[]"></td><td colspan="2" style="border:1px solid #CCC;"><b>REASON FOR LEAVING</b><input type="text" style="width: 99%;" name="eaf_er_rfl[]"></td></tr><tr><td colspan="3" style="border:1px solid #CCC;"><b>DUTIES &amp; RESPONSIBILITIES</b><input type="text" style="width: 99%;" name="eaf_er_duties[]"></td></tr></table></div></div>');
			e.preventDefault();
		});

// <a href="#" id="removeEmploymentRecord" style="float:right;"><b>Remove Employment Record</b> 
// 			<span class="glyphicon glyphicon-minus" title="Add Employment Record"></span></a>

		$(document).on('click','#addTeaching',function(e){
			counta++;
			$('#bodyTeaching').prepend('<tr>\
				<td style="border:1px solid #CCC;text-align: center">\
					<button type="button" class="btn btn-default date-picka" id="daterange-btna'+counta+'" data-id="'+counta+'">\
						<i class="fa fa-calendar"></i> <span></span>\
						<i class="fa fa-caret-down"></i>\
					</button>\
					<input type="hidden" id="starta'+counta+'" name="eaf_tp_date_from[]">\
					<input type="hidden" id="enda'+counta+'" name="eaf_tp_date_to[]">\
				<td style="border:1px solid #CCC;text-align: center">\
				<input type="text" style="width: 99%;" name="eaf_tp_school[]"></td>\
				<td style="border:1px solid #CCC;text-align: center">\
				<input type="text" style="width: 99%;" name="eaf_tp_subject[]"></td>\
				<td style="border:1px solid #CCC;text-align: center">\
				<input type="text" style="width: 99%;" name="eaf_tp_superior_cont[]"></td>\
				<td style="border:1px solid #CCC;text-align: center">\
				<input type="text" style="width: 99%;" name="eaf_tp_salary[]"></td>\
				<td style="border:1px solid #CCC;text-align: center">\
				<input type="text" style="width: 99%;" name="eaf_tp_rfl[]"></td>\
				<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td></tr>');

				$('.date-picka').click(function(){
						var id = $(this).attr('data-id');
						counta = id;
						console.log(id);
					});

					function cb(start, end) {
							$('input#starta'+counta).val(start.format('MMMM D, YYYY'));
					    	$('input#enda'+counta).val(end.format('MMMM D, YYYY'));
							$('.date-picka').click(function(){				
								$('input#starta'+counta).val(start.format('MMMM D, YYYY'));
					    		$('input#enda'+counta).val(end.format('MMMM D, YYYY'));
							});
					        $('#daterange-btna'+counta+' span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
					        	
					    }
					    cb(moment().subtract(29, 'days'), moment());

				    $('#daterange-btna'+counta).daterangepicker({
				        ranges: {
				           'Today': [moment(), moment()],
				           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				           'This Month': [moment().startOf('month'), moment().endOf('month')],
				           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				        }
				    }, cb);
		
			e.preventDefault();
		});

		$(document).on('click','#addCompanies',function(e){
			count++;
		
			$('#bodyCompanies').prepend('\
				<tr>\
					<td style="border:1px solid #CCC;text-align: center">\
						<button type="button" class="btn btn-default date-pick" id="daterange-btn'+count+'" data-id="'+count+'">\
						<i class="fa fa-calendar"></i> <span></span><i class="fa fa-caret-down"></i></button>\
						<input type="hidden" id="start'+count+'" name="eaf_erc_date_from[]">\
						<input type="hidden" id="end'+count+'" name="eaf_erc_date_to[]">	\
					</td>\
					<td style="border:1px solid #CCC;text-align: center"><input name="eaf_prev_position[]" type="text" style="width: 99%;"></td>\
					<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_superior_cont[]" type="text" style="width: 99%;"></td>\
					<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_salary[]" type="text" style="width: 99%;"></td>\
					<td style="border:1px solid #CCC;text-align: center"><input name="eaf_erc_rfl[]" type="text" style="width: 99%;"></td>\
					<td style="text-align: center"><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus"></span></a></td>\
				</tr>')
			
			$('.date-pick').click(function(){
				var id = $(this).attr('data-id');
				count = id;
			});

			function cb(start, end) {
					$('input#start'+count).val(start.format('MMMM D, YYYY'));
			    	$('input#end'+count).val(end.format('MMMM D, YYYY'));
					$('.date-pick').click(function(){				
						$('input#start'+count).val(start.format('MMMM D, YYYY'));
			    		$('input#end'+count).val(end.format('MMMM D, YYYY'));
					});
			        $('#daterange-btn'+count+' span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			        	
			    }
			    cb(moment().subtract(29, 'days'), moment());

		    $('#daterange-btn'+count).daterangepicker({
		        ranges: {
		           'Today': [moment(), moment()],
		           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		           'This Month': [moment().startOf('month'), moment().endOf('month')],
		           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		        }
		    }, cb);
			e.preventDefault();
		});
		

		$(document).on('click','#addOrganization',function(e){
			$('#bodyOrganization').prepend('<tr>\
				<td style="border:1px solid #CCC;"><input name="eaf_org_name[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;"><input name="eaf_org_position[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;">\
					<center>\
					<button type="button" class="btn btn-default date-pick2b" id="daterange-btn2b'+count+'" data-id="'+count+'" style="width:90%;">\
							<i class="fa fa-calendar"></i> <span></span>\
							<i class="fa fa-caret-down"></i>\
					</button>\
						<input type="hidden" id="startc'+count+'" name="eaf_org_date_from[]">\
						<input type="hidden" id="endc'+count+'" name="eaf_org_date_to[]">\
					</center>\
				</td>\
				<td><a href="#" id="removeChild" ><span class="glyphicon glyphicon-minus" ></span></a></td></tr>')

				function cb(start, end) {
						$('input#startc'+countc).val(start.format('MMMM D, YYYY'));
				    	$('input#endc'+countc).val(end.format('MMMM D, YYYY'));
						$('.date-pick2b').click(function(){				
							$('input#startc'+countc).val(start.format('MMMM D, YYYY'));
				    		$('input#endc'+countc).val(end.format('MMMM D, YYYY'));
						});
				        $('#daterange-btn2b'+countc+' span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				        	
				    }
				    cb(moment().subtract(29, 'days'), moment());

			    $('#daterange-btn2b'+countc).daterangepicker({
			        ranges: {
			           'Today': [moment(), moment()],
			           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			           'This Month': [moment().startOf('month'), moment().endOf('month')],
			           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			        }
			    }, cb);
				e.preventDefault();
		});


		
		$(document).on('click','#addTraining',function(e){
			$('#bodyTrainingSeminar').prepend('<tr>\
				<td style="border:1px solid #CCC;"><input name="eaf_tas_title[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;"><input name="eaf_tas_name_loc[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;">\
				<center>\
				<button type="button" class="btn btn-default date-pick1b" id="daterange-btn1b'+count+'" data-id="'+count+'" style="width:90%;">\
						<i class="fa fa-calendar"></i> <span></span>\
						<i class="fa fa-caret-down"></i>\
				</button>\
					<input type="hidden" id="startb'+count+'" name="eaf_tas_date_from[]">\
					<input type="hidden" id="endb'+count+'" name="eaf_tas_date_to[]">\
				</center>\
				</td>\
				<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus" >\
				</span></a></td></tr>')

			function cb(start, end) {
					$('input#startb'+countb).val(start.format('MMMM D, YYYY'));
			    	$('input#endb'+countb).val(end.format('MMMM D, YYYY'));
					$('.date-pick1b').click(function(){				
						$('input#startb'+countb).val(start.format('MMMM D, YYYY'));
			    		$('input#endb'+countb).val(end.format('MMMM D, YYYY'));
					});
			        $('#daterange-btn1b'+countb+' span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			        	
			    }
			    cb(moment().subtract(29, 'days'), moment());

		    $('#daterange-btn1b'+countb).daterangepicker({
		        ranges: {
		           'Today': [moment(), moment()],
		           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		           'This Month': [moment().startOf('month'), moment().endOf('month')],
		           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		        }
		    }, cb);
			e.preventDefault();
		});

		$(document).on('click','#addReference',function(e){
			$('#bodyReference').prepend('<tr>\
				<td style="border:1px solid #CCC;"><input name="eaf_ref_name[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;"><input name="eaf_ref_comp_name[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;"><input name="eaf_ref_position[]" type="text" style="width: 99%;"></td>\
				<td style="border:1px solid #CCC;"><input name="eaf_ref_contact[]" type="text" style="width: 99%;"></td>\
				<td><a href="#" id="removeChild"><span class="glyphicon glyphicon-minus" ></span></a></td></tr>');
			e.preventDefault();
		});

	})

	$(document).on('click','#removeChild',function(e){
		removeParent($(this));
		e.preventDefault();
	});
	$(document).on('click','#removeEmploymentRecord',function(e){
		removeDivParent($(this));
		e.preventDefault();
	});
	var removeDivParent = function(elem){
		$(elem).closest('div').remove();
	}
	var removeParent = function(elem){
		$(elem).closest('tr').remove();
		return false;
	}
</script>