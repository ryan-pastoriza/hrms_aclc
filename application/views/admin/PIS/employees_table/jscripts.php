<?php
/**
 * @Author: gian
 * @Date:   2016-03-31 16:49:35
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-24 14:22:08
 */
?>
<style>
	#submit{
		display: none;
	}
</style>
<script type="text/javascript">
	var table;
	var tableOptions
	$(function(){
		// DataTable
	    tableOptions = { 
	     	"ajax": "<?= base_url() ?>index.php/admin/employees/employees_list",
		}
	    table = $('#empsTable').DataTable(tableOptions);

	    // Apply the search
	    table.columns().every( function () {
	        var that = this;

	        $( 'input,select', this.footer() ).on( 'keyup change', function () {
	            that.search( this.value ).draw();
	        } );
	    } );
	})

/* -----  PIS SCRIPTS    -------- */
	$(document).on('click','#updateBTN',function(r){
		var t = $(this);
	  	t.addClass('disabled');

	    var newOptions = {
	            beforeSubmit: function(formData){
	                                  $('#submit').attr('disabled','disabled');
	                                  $('#submit').html('Submitting');
	                              },  // pre-submit callback 
	            data:{employee_id: $('#addNewForm [name=employee_id]').val()},
		        success: function(e){
		                $('#notifications').append(e.view);
		                if (e.success == true) {
		                	reload_emp_list();
		                };  
		                t.removeClass('disabled');
		                              },
		        dataType:  'json',
	        };
	    
	        $('#addNewForm').ajaxForm(newOptions);
	        $('#addNewForm').submit();
		return false;
	  })
	$(document).on('click','.setActive',function(r){
		var t = $(this);
			$.ajax({
				type: "post",
				url: "<?= base_url() ?>index.php/admin/personnel_information/set_active",
				data: "employee_id="+$("#addNewForm [name=employee_id]").val(),
				dataType: 'json',
				success: function(e){
					$('#notifications').append(e.view);
	                if (e.success == true) {
	                    t.removeAttr('disabled');
						t.removeClass('btn-success').addClass('btn-danger');
						t.removeClass('setActive').addClass('setInactive').attr('title','Set as Inactive').attr('data-original-title','Set as Inactive').html('<i class="glyphicon glyphicon-user"></i>');
	                    reload_emp_list();
	                }
				} 
			});
			return false;
	  })
	$(document).on('click','.setInactive',function(){
		var t = $(this);
	     $.ajax(
	            {
	              type: "post",
	              url:"<?= base_url() ?>index.php/admin/personnel_information/set_inactive",
	              data: "employee_id="+ $('#addNewForm [name=employee_id]').val(),
	              dataType: 'json',
	        	  success: function(e){
	        	  	$('#notifications').append(e.view);
	                if (e.success == true) {
	                    $('.setInactive').removeAttr('disabled');
						$('.setInactive').removeClass('btn-danger').addClass('btn-success');
						$('.setInactive').removeClass('setInactive').addClass('setActive').attr('title','Set as Active').attr('data-original-title','Set as Active').html('<i class="fa fa-smile-o"></i>');
	                    reload_emp_list();
	                }
					},
	   		    })
	     return false;})
	$(document).on('click','#addNewEmpBTN',function(){
		$('#submit').trigger('click');
	    reload_emp_list();
		return false;})
	$(document).on('click','#clearPisBTN',function(r){
	$('#pisView input,select').val('');
	$('.only-with-data').fadeOut(1000);
	return false;})
/* ------ END OF PIS SCRIPTS ------- */

$(function(){
	$('.only-with-data').css({display:'none'});

	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
    });
	$('#emp-app-form').ajaxForm({
									beforeSubmit: function(){
										$('#emp-app-form').css({'opacity':'0.5'})
										if (typeof emp_id === "undefined") {
										}
									},
									success: function(r){
										$('#emp-app-form').css({'opacity':'1'})
									},	
								})
})
	//@Author: ARIEL
	var dep_oTable;
	var dep_tbl;
	var dep_tableOptions;
	var spouse_oTable;
	var spouse_tableOptions;
	var spouse_tbl;
	var educ1_oTable;
	var educ1_tbl;
	var educ1_tableOptions;
	var educ2_oTable;
	var educ2_tbl;
	var educ2_tableOptions;
	var eli_oTable;
	var eli_tbl;
	var eli_tableOptions;
	var aff_oTable;
	var aff_tbl;
	var aff_tableOptions;
	var ets_oTable;
	var ets_tbl;
	var ets_tableOptions;
	//END


var globe_empID; //==========gian
$(document).on('click','.openEmpFileBtn',function(r){
	var btn;



	emp_id 		= $(this).attr('emp_id');
	d 			= new Date();
	globe_empID = emp_id; //=======gian
	/*------------- INITIALIZE EAF VARIABLES --------------*/
	var spouseDisp 		= "";
	var childrenDisp 	= "";
	var relativeDisp 	= "";
	var educationDisp 	= "";
	var employmentDisp 	= "";
	var teachingDisp 	= "";
	var emprecDisp 		= "";
	var trainingDisp 	= "";
	var orgDisp 		= "";
	var referenceDisp 	= "";

	/*------------- END OF INITIALIZING EAF VARIABLES --------------*/


	// Author: Dale
	// Showing print and save buttons when openempfilebtn clicked
	
	var eaf_buttons = "<a href='<?= base_url('index.php/admin/employees/employee_application_sheet?employee_id=btn-2012-0213') ?>' target='blank' class='btn btn-success'><i class='fa fa-print'></i> Print</a> <button type='submit' class='btn btn-success'><i class='fa fa-save'></i> Save</button>";
	$('.eaf_showButtons').html(eaf_buttons);
	// var ss_buttons  = "<button class='btn btn-primary' id='addBtn'><span class='fa fa-save'></span> Save</button> <button type='button' id='btnPrint' class='btn btn-primary'><span class='fa fa-print'></span> Print</button>"; 
	// $('.ss_buttons').html(ss_buttons);


	// $('#btnPrint').click(function(){
	// 	$('.printable').print();
	// });

	// End 

	/* ------------ SHOW DATA FETCHING ON PIS FORM --------------*/

	$('#pisView input,select').attr('disabled','disabled');
	$('#pisView input:not([type=date],[type=file]),select').val('fetching. . .');

	/* ------------ END OF SHOW DATA FETCHING ON PIS FORM --------------*/
	// employment requirements
	$.post("<?= base_url() ?>index.php/admin/employees/check_requirement","empID="+globe_empID,function(e){
		// alert(e);
		$('#req').html(e.view);
	},"json");

	// end

	$.post("<?= base_url() ?>index.php/admin/employees/view_info","emp_id="+emp_id,	function(r){
		$.each(r,function(k,v){
			var element = $('#pisView [name='+k+']');
			var element2 = $('#emp-app-form [name='+k+']');

			/*------------ PIS ACTIVE/INACTIVE BUTTON ------------- */
			if(k == 'employment_status'){
				if(v == 'active'){
					btn = '<a href="#" class="btn btn-danger only-with-data setInactive dynamic" data-toggle="tooltip" title="Set as Inactive"><i class="glyphicon glyphicon-user"></i></a>';
				}
				else{
					btn = '<a href="#" class="btn btn-success only-with-data setActive dynamic" data-toggle="tooltip" title="Set as Active"><i class="fa fa-smile-o"></i></a>';
				}
			}
			/*------------- POPULATE NON-INPUT EMP APP FORM -------------*/
			else if(k == 'spouse'){
					var spouse_id = "";

					spouseDisp += "<h5><b><i>Spouse Information</i></b></h5><br><table id='spouse_tbl' class='table' style='font-size:12px !important;'>\
									<thead>\
										<th>Spouse Name</th>\
										<th>Spouse Birthdate</th>\
										<th>Spouse Occupation</th>\
										<th>Spouse Contact Number</th>\
										<th></th>\
									 </thead>\
									 <tbody>";

					$.each(v,function(key,obj){
						var id_spouse = obj.eaf_spouse_id;
						var name_spouse = obj.eaf_spouse_name;
						var dob_spouse = obj.eaf_spouse_dob;
						var occu_spouse = obj.eaf_spouse_occupation;
						var contact_spouse = obj.eaf_spouse_contact_num;
					spouseDisp +=  "<tr style='width:100%;'>"+
										"<td><span class='eaf_spouse' data-name='eaf_spouse_name' 			data-pk='"+id_spouse+"' data-value='"+name_spouse+"'>"+name_spouse+"</span></td>"+
										"<td><span class='eaf_spouse' data-name='eaf_spouse_dob' data-type = 'combodate' data-pk='"+id_spouse+"' data-value='"+dob_spouse+"'>"+dob_spouse+"</span></td>"+
										"<td><span class='eaf_spouse' data-name='eaf_spouse_occupation' 	data-pk='"+id_spouse+"' data-value='"+occu_spouse+"'>"+occu_spouse+"</span></td>"+
										"<td><span class='eaf_spouse' data-name='eaf_spouse_contact_num' 	data-pk='"+id_spouse+"' data-value='"+contact_spouse+"'>"+contact_spouse+"</span></td>"+
								  		"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_spouse("+id_spouse+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
								   "</tr>"; 		   
					spouse_id = obj.eaf_spouse_id;
					})
					spouseDisp += "</tbody></table>";
					if(spouse_id == ""){
						$("#e_spouse").html('');
					}else {
						$("#e_spouse").html(spouseDisp);
					}
			}
			else if(k == 'children'){
					var child_id = "";
					childrenDisp += "<h5><b><i>Children Information</i></b></h5><br><table class='table' style='font-size:12px !important;'>\
										<thead>\
											<th>Child Name</th>\
											<th>Child Birthdate</th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						childrenDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_child_name' data-name='eaf_child_name' data-pk='"+obj.eaf_child_id+"'    data-value='"+obj.eaf_child_name+"'>" +obj.eaf_child_name+"</span></td>"+
											"<td><span class='eaf_child_dob'  data-name='eaf_child_dob'  data-pk='"+obj.eaf_child_id+"'    data-value='"+obj.eaf_child_dob+"'>"  +obj.eaf_child_dob+"</span></td>"+
								  			"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_children("+obj.eaf_child_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
								  		"</tr>";
						child_id = obj.eaf_child_id;
					})
					childrenDisp +="</tbody></table>";
					if(child_id==""){
						$("#e_children").html('');
					}else {
						$("#e_children").html(childrenDisp);
					}
			}
			else if(k == 'relative'){
					var relative_id = "";
					relativeDisp += "<h5><b><i>Relative Information</i></b></h5><table class='table' style='font-size:12px !important;'>\
										<thead>\
											<th>Relative Name</th>\
											<th>Relationship</th>\
											<th>Position / Department</th>\
										 </thead>\
									 <tbody>";

					$.each(v,function(key,obj){

					relativeDisp += "<tr style='width:100%;'>"+
										"<td><span class='eaf_relative_name' data-name='eaf_relative_name' data-pk='"+obj.eaf_relative_id+"'    data-value='"+obj.eaf_relative_name+"'>" +obj.eaf_relative_name+"</span></td>"+
										"<td><span class='eaf_relative_relationship'  data-name='eaf_relative_relationship'  data-pk='"+obj.eaf_child_id+"'    data-value='"+obj.eaf_relative_relationship+"'>"  +obj.eaf_relative_relationship+"</span></td>"+
										"<td><span class='eaf_relative_position'  	  data-name='eaf_relative_position'      data-pk='"+obj.eaf_child_id+"'    data-value='"+obj.eaf_relative_position+"'>"      +obj.eaf_relative_position+"</span></td>"+
							  			"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_relative("+obj.eaf_relative_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
							  		"</tr>";
					relative_id = obj.eaf_relative_id;	  				
					})
					relativeDisp += "</tbody></table>";
				
					if(relative_id==""){
						$("#e_relative").html('');
					}else{
						$("#e_relative").html(relativeDisp);
					}
			}
			else if(k == 'education'){
					var education_id = "";
					educationDisp += "<h5><i><b>&nbsp;&nbsp;Education History</b></i></h5><table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Type of School</th>\
											<th>Name of School</th>\
											<th>Degree Earned</th>\
											<th>From</th>\
											<th>To</th>\
											<th>Honors Received</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						educationDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_educ_school_type' data-name='eaf_educ_school_type' data-pk='"+obj.eaf_educ_id+"'    data-value='"+obj.eaf_educ_school_type+"'>" +obj.eaf_educ_school_type+"</span></td>"+
											"<td><span class='eaf_educ_school_name'  data-name='eaf_educ_school_name'  data-pk='"+obj.eaf_educ_id+"'    data-value='"+obj.eaf_educ_school_name+"'>"  +obj.eaf_educ_school_name+"</span></td>"+
								  			"<td><span class='eaf_educ_degree'  data-name='eaf_educ_degree'  data-pk='"+obj.eaf_educ_id+"'    data-value='"+obj.eaf_educ_degree+"'>"  +obj.eaf_educ_degree+"</span></td>"+
								  			"<td><span class='eaf_educ_from'  data-name='eaf_educ_from'  data-pk='"+obj.eaf_educ_id+"'    data-value='"+obj.eaf_educ_from+"'>"  +obj.eaf_educ_from+"</span></td>"+
								  			"<td><span class='eaf_educ_to'  data-name='eaf_educ_to'  data-pk='"+obj.eaf_educ_id+"'    data-value='"+obj.eaf_educ_to+"'>"  +obj.eaf_educ_to+"</span></td>"+
								  			"<td><span class='eaf_educ_honors'  data-name='eaf_educ_honors'  data-pk='"+obj.eaf_educ_id+"'    data-value='"+obj.eaf_educ_honors+"'>"  +obj.eaf_educ_honors+"</span></td>"+
								  			"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_education("+obj.eaf_educ_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
								  		"</tr>";
						education_id = obj.eaf_educ_id;
					})
					educationDisp +="</tbody></table>";
					if(education_id==""){
						$(".educ_table").html('');
					}else {
						$(".educ_table").html(educationDisp);
					}
			}
			else if(k == "employment_rec"){
					var employ_rec_id = "";
					employmentDisp += "<i><b>&nbsp;&nbsp; Employment History</b></i><br><table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Company Name</th>\
											<th>Address</th>\
											<th>Company Contact Number</th>\
											<th>Immediate Superior</th>\
											<th>Contact Number</th>\
											<th>Your Position</th>\
											<th>Salary Start</th>\
											<th>Salary Final</th>\
											<th>REASON FOR LEAVING</th>\
											<th>DUTIES & RESPONSIBILITIES</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						employmentDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_er_comp_name' data-name='eaf_er_comp_name' data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_comp_name+"'>" +obj.eaf_er_comp_name+"</span></td>"+
											"<td><span class='eaf_er_comp_address'  data-name='eaf_er_comp_address'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_comp_address+"'>"  +obj.eaf_er_comp_address+"</span></td>"+
								  			"<td><span class='eaf_er_comp_num'  data-name='eaf_er_comp_num'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_comp_num+"'>"  +obj.eaf_er_comp_num+"</span></td>"+
								  			"<td><span class='eaf_er_superior'  data-name='eaf_er_superior'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_superior+"'>"  +obj.eaf_er_superior+"</span></td>"+
								  			"<td><span class='eaf_er_superior_num'  data-name='eaf_er_superior_num'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_superior_num+"'>"  +obj.eaf_er_superior_num+"</span></td>"+
								  			"<td><span class='eaf_er_position'  data-name='eaf_er_position'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_position+"'>"  +obj.eaf_er_position+"</span></td>"+
								  			"<td><span class='eaf_er_salary_start'  data-name='eaf_er_salary_start'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_salary_start+"'>"  +obj.eaf_er_salary_start+"</span></td>"+
								  			"<td><span class='eaf_er_salary_final'  data-name='eaf_er_salary_final'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_salary_final+"'>"  +obj.eaf_er_salary_final+"</span></td>"+
								  			"<td><span class='eaf_er_rfl'  data-name='eaf_er_rfl'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_rfl+"'>"  +obj.eaf_er_rfl+"</span></td>"+
								  			"<td><span class='eaf_er_duties'  data-name='eaf_er_duties'  data-pk='"+obj.eaf_er_id+"'    data-value='"+obj.eaf_er_duties+"'>"  +obj.eaf_er_duties+"</span></td>"+
								  			"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_employment("+obj.eaf_er_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
								  		"</tr>";
					employ_rec_id = obj.eaf_er_id;
					})
					employmentDisp +="</tbody></table>";
					if(employ_rec_id == ""){
						$(".e_employment").html('');
					}else{
						$(".e_employment").html(employmentDisp);
					}
			}
			else if(k == "teaching"){
					var teaching_id = "";
					teachingDisp += "<h5><b><i>&nbsp;&nbsp;Teaching History</i></b></h5><table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Date From</th>\
											<th>Date To</th>\
											<th>School</th>\
											<th>Grade or Subject taught</th>\
											<th>SUPERIOR & CONTACT #</th>\
											<th>Salary</th>\
											<th>Reason for leaving</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						teachingDisp += "<tr style='width:100%;'>"+
										"<td><span class='eaf_tp_date_from' data-name='eaf_tp_date_from' data-pk='"+obj.eaf_tp_id+"' data-value='"+obj.eaf_tp_date_from+"'>" +obj.eaf_tp_date_from+"</span></td>"+
										"<td><span class='eaf_tp_date_to'  data-name='eaf_tp_date_to'  data-pk='"+obj.eaf_tp_id+"' data-value='"+obj.eaf_tp_date_to+"'>"+obj.eaf_tp_date_to+"</span></td>"+
										"<td><span class='eaf_tp_school' data-name='eaf_tp_school'  data-pk='"+obj.eaf_tp_id+"' data-value='"+obj.eaf_tp_school+"'>" +obj.eaf_tp_school+"</span></td>"+
										"<td><span class='eaf_tp_subject' data-name='eaf_tp_subject' data-pk='"+obj.eaf_tp_id+"' data-value='"+obj.eaf_tp_subject+"'>" +obj.eaf_tp_subject+"</span></td>"+
										"<td><span class='eaf_tp_superior_cont' data-name='eaf_tp_superior_cont' data-pk='"+obj.eaf_tp_id+"' data-value='"+obj.eaf_tp_superior_cont+"'>" +obj.eaf_tp_superior_cont+"</span></td>"+
										"<td><span class='eaf_tp_salary'  data-name='eaf_tp_salary' data-pk='"+obj.eaf_tp_id+"'  data-value='"+obj.eaf_tp_salary+"'>" +obj.eaf_tp_salary+"</span></td>"+
										"<td><span class='eaf_tp_rfl' data-name='eaf_tp_rfl' data-pk='"+obj.eaf_tp_id+"' data-value='"+obj.eaf_tp_rfl+"'>" +obj.eaf_tp_rfl+"</span></td>"+
										"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_teaching("+obj.eaf_tp_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
										"</tr>";
					teaching_id = obj.eaf_tp_id;
					})
					teachingDisp +="</tbody></table>";
					if(teaching_id == ""){
						$(".e_teaching").html('');
					}else{
						$(".e_teaching").html(teachingDisp);
					}
			}
			else if(k == "emprec"){
					var emprec_id = "";
					emprecDisp += "<h5><b><i>&nbsp;&nbsp;Employment Records in ACLC </i></b></h5><table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Date From</th>\
											<th>Date To</th>\
											<th>Position and Department</th>\
											<th>Superior Contact #</th>\
											<th>Salary</th>\
											<th>Reason for leaving</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						emprecDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_erc_date_from' data-name='eaf_erc_date_from' data-pk='"+obj.eaf_erc_id+"'    data-value='"+obj.eaf_erc_date_from+"'>" +obj.eaf_erc_date_from+"</span></td>"+
											"<td><span class='eaf_erc_date_to' data-name='eaf_erc_date_to' data-pk='"+obj.eaf_erc_id+"'    data-value='"+obj.eaf_erc_date_to+"'>" +obj.eaf_erc_date_to+"</span></td>"+
											"<td><span class='eaf_prev_position' data-name='eaf_prev_position' data-pk='"+obj.eaf_erc_id+"'    data-value='"+obj.eaf_prev_position+"'>" +obj.eaf_prev_position+"</span></td>"+
											"<td><span class='eaf_erc_superior_cont' data-name='eaf_erc_superior_cont' data-pk='"+obj.eaf_erc_id+"'    data-value='"+obj.eaf_erc_superior_cont+"'>" +obj.eaf_erc_superior_cont+"</span></td>"+
											"<td><span class='eaf_erc_salary' data-name='eaf_erc_salary' data-pk='"+obj.eaf_erc_id+"'    data-value='"+obj.eaf_erc_salary+"'>" +obj.eaf_erc_salary+"</span></td>"+
											"<td><span class='eaf_erc_rfl' data-name='eaf_erc_rfl' data-pk='"+obj.eaf_erc_id+"'    data-value='"+obj.eaf_erc_rfl+"'>" +obj.eaf_erc_rfl+"</span></td>"+
											"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_emprec("+obj.eaf_erc_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
											"</tr>";	
					emprec_id = obj.eaf_erc_id;
					})
					emprecDisp +="</tbody></table>";
					
					if(emprec_id==""){
						$(".e_emprec").html('');
					}else{
						$(".e_emprec").html(emprecDisp);
					}
			}
			else if(k == "training"){
					var training_id = "";
					trainingDisp += "<i><b>Training and Seminar History</b></i><br><table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Title</th>\
											<th>Name and Location</th>\
											<th>Date from</th>\
											<th>Date to</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						trainingDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_tas_title' data-name='eaf_tas_title' data-pk='"+obj.eaf_tas_id+"'    data-value='"+obj.eaf_tas_title+"'>" +obj.eaf_tas_title+"</span></td>"+
											"<td><span class='eaf_tas_name_loc' data-name='eaf_tas_name_loc' data-pk='"+obj.eaf_tas_id+"'    data-value='"+obj.eaf_tas_name_loc+"'>" +obj.eaf_tas_name_loc+"</span></td>"+
											"<td><span class='eaf_tas_date_from' data-name='eaf_tas_date_from' data-pk='"+obj.eaf_tas_id+"'    data-value='"+obj.eaf_tas_date_from+"'>" +obj.eaf_tas_date_from+"</span></td>"+
											"<td><span class='eaf_tas_date_to' data-name='eaf_tas_date_to' data-pk='"+obj.eaf_tas_id+"'    data-value='"+obj.eaf_tas_date_to+"'>" +obj.eaf_tas_date_to+"</span></td>"+
											"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_training("+obj.eaf_tas_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
										"</tr>";	
					training_id = obj.eaf_tas_id;
					})
					trainingDisp +="</tbody></table>";
					if(training_id==""){
						$(".e_training").html('');
					}else{
						$(".e_training").html(trainingDisp);
					}
			}
			else if(k == "orgs"){
					var org_id = "";
					orgDisp += "<table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Organization/Club</th>\
											<th>Position</th>\
											<th>Date from</th>\
											<th>Date to</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						orgDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_org_name' data-name='eaf_org_name' data-pk='"+obj.eaf_org_id+"'    data-value='"+obj.eaf_org_name+"'>" +obj.eaf_org_name+"</span></td>"+
											"<td><span class='eaf_org_position' data-name='eaf_org_position' data-pk='"+obj.eaf_org_id+"'    data-value='"+obj.eaf_org_position+"'>" +obj.eaf_org_position+"</span></td>"+
											"<td><span class='eaf_org_date_from' data-name='eaf_org_date_from' data-pk='"+obj.eaf_org_id+"'    data-value='"+obj.eaf_org_date_from+"'>" +obj.eaf_org_date_from+"</span></td>"+
											"<td><span class='eaf_org_date_to' data-name='eaf_org_date_to' data-pk='"+obj.eaf_org_id+"'    data-value='"+obj.eaf_org_date_to+"'>" +obj.eaf_org_date_to+"</span></td>"+
											"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_orgs("+obj.eaf_org_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
										"</tr>";	
					org_id=obj.eaf_org_id;
					})
					orgDisp +="</tbody></table>";
					if(org_id==""){
						$(".e_orgs").html('');
					}else{
						$(".e_orgs").html(orgDisp);
					}
			}
			else if(k == "references"){
					var ref_id="";
					referenceDisp += "<b><i>Reference Info</i></b><table class='table' style='border:1px solid #CCC;font-size:12px !important;'>\
										<thead>\
											<th>Name</th>\
											<th>Company Name and Address</th>\
											<th>Position</th>\
											<th>Contact No.</th>\
											<th> </th>\
										 </thead>\
									 <tbody>";
					$.each(v,function(key,obj){
						referenceDisp += "<tr style='width:100%;'>"+
											"<td><span class='eaf_ref_name' data-name='eaf_ref_name' data-pk='"+obj.eaf_ref_id+"'    data-value='"+obj.eaf_ref_name+"'>" +obj.eaf_ref_name+"</span></td>"+
											"<td><span class='eaf_ref_comp_name' data-name='eaf_ref_comp_name' data-pk='"+obj.eaf_ref_id+"'    data-value='"+obj.eaf_ref_comp_name+"'>" +obj.eaf_ref_comp_name+"</span></td>"+
											"<td><span class='eaf_ref_position' data-name='eaf_ref_position' data-pk='"+obj.eaf_ref_id+"'    data-value='"+obj.eaf_ref_position+"'>" +obj.eaf_ref_position+"</span></td>"+
											"<td><span class='eaf_ref_contact' data-name='eaf_ref_contact' data-pk='"+obj.eaf_ref_id+"'    data-value='"+obj.eaf_ref_contact+"'>" +obj.eaf_ref_contact+"</span></td>"+
											"<td><div class='btn-group'>"+
											"<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>"+
												"<span class='glyphicon glyphicon-trash'></span>"+
											"</button>"+
											"<ul class='dropdown-menu pull-right' role='menu'>"+
												"<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>"+
												"<li class='text-center'><a href='#' onclick='delete_references("+obj.eaf_ref_id+",this); return false;'>Yes</a></li>"+
												"<li class='text-center'><a href='#' onclick='return false;'>No</a></li>"+
											"</ul>"+
										"</div></td>"+
										"</tr>";
					ref_id = obj.eaf_ref_id;
					})
					referenceDisp +="</tbody></table>";
					if(ref_id==""){
						$(".e_references").html('');
					}else{
						$(".e_references").html(referenceDisp);
					}
			}
			/*------------- POPULATE NON-INPUT EMP APP FORM -------------*/

				/*----------- EMP APP FORM EDITABLES ---------------*/
				$('.eaf_spouse').editable({
					mode:'inline',
					url: "<?= base_url('index.php/admin/employees/update_spouse') ?>",
					success: function() {
					}
				});
				/*----------- END OF EMP APP FORM EDITABLES ---------------*/

			/*------------ END OF PIS ACTIVE/INACTIVE BUTTON ------------- */

			/*------------ POPULATE EAF INPUTS ----------------*/
			if (element2.length > 0) {
				if( element2.attr('type') == 'radio' ){
					element2.prop('checked',false);
					if (k == 'eaf_employment_desired') {
						$.each(element2,function(el2,val2){
							if(v == $(val2).val()){
								$(val2).prop('checked','checked');
							}
						})
					}
					}
				else{
					element2.val(v);
				}	
			};
			/*------------ END OF POPULATING EAF INPUTS ----------------*/

			/*-------------------- POPULATE PIS INPUTS ----------------*/
			if (element.length > 0) {
				element.val(v);

				// CHECK EAF NAME
				if (k == 'employee_fname') {
					var el2 = $('[name=eaf_fname]') ;
					if ( el2.val() == '' ) {
						el2.val(v);
					}
				}
				else if (k == 'employee_mname') {
					var el2 = $('[name=eaf_mname]') ;
					if ( el2.val() == '' ) {
						el2.val(v);
					}
				}
				else if (k == 'employee_lname') {
					var el2 = $('[name=eaf_lname]') ;
					if ( el2.val() == '' ) {
						el2.val(v);
					}
				}
				else if (k == 'employee_bday') {
					var el2 = $('[name=eaf_birthdate]') ;
					if ( el2.val() == '' ) {
						el2.val(v);
					}
				}
				// END OF CHECKING EAF NAME


			}
			//@Author: ARIEL
				var sis_element = $('#sis_form [name='+k+']');
				if (sis_element.length > 0) {
					sis_element.val(v);
				}
			//END
			/*-------------------- END OF POPULATING PIS INPUTS ----------------*/


		})
		/*--------------- EMPLOYEE IMAGE PREVIEW ---------------------*/

		$.ajax({
			url:"<?= base_url('images/users/"+emp_id+".jpg') ?>",
			success: function(){
				$('.img-prev').attr('src',"<?= base_url('images/users/"+emp_id+".jpg?"+d.getTime()+"') ?>");
			},
			error: function(){
				$('.img-prev').attr('src',"<?= base_url('images/no-image.fw.png') ?>");
			}
		})

		/*--------------- END OF EMPLOYEE IMAGE PREVIEW ---------------------*/

		/*--------------- REACTIVATING PIS FORM --------------------*/
			$('#pisView input:not([name=employee_id]),select').removeAttr('disabled');
			$('a.dynamic').replaceWith(btn);
			$('.only-with-data').fadeIn(1000);
		/*--------------- END OF REACTIVATING PIS FORM --------------------*/

		},'json');

//@Author: ARIEL
	clear_all();

	dep_tbl = '<table id="dep_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Name of Dependents</th>\
											<th>Date of Birth</th>\
											<th>Age</th>\
											<th>Relationship</th>\
											<th>Dependent</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';

	$('#dep_list').html(dep_tbl);
	dep_tableOptions = {dom: '',
						ajax : "<?= base_url('index.php/admin/employees/get_dep_json?employee_id="+emp_id+"') ?>",
						fnDrawCallback: function() {
											$('.emp_dependent_name').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/employees/update_dependent') ?>",
												success: function() {
													dep_oTable.api().ajax.reload();
												}
											});
											$('.emp_dependent_birthdate').editable({
												type: 'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>", minYear: "1900"},
												url: "<?= base_url('index.php/admin/employees/update_dependent') ?>",
												success: function() {
													dep_oTable.api().ajax.reload();
												}
											});
											$('.emp_dependent_relationship').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/employees/update_dependent') ?>",
												success: function() {
													dep_oTable.api().ajax.reload();
												}
											});
											$('.emp_dependent_dependency').editable({
												type: 'select',
												mode:'inline',
												url: "<?= base_url('index.php/admin/employees/update_dependent') ?>",
												source: [
													{value: 1, text: 'Yes'},
													{value: 0, text: 'No'}
												],
												success: function() {
													dep_oTable.api().ajax.reload();
												}
											});
										},
						initComplete: function() {
							if(this.api().rows().count() == 0) {
								$('#dep_list').html('');
							}
						}
					};
    dep_oTable = $('#dep_table').dataTable(dep_tableOptions);

    spouse_tbl = '<table id="spouse_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Name of Spouse</th>\
											<th>Date of Birth</th>\
											<th>Age</th>\
											<th>Date of Marriage</th>\
											<th>Occupation</th>\
											<th>Employer</th>\
											<th>Employer\'s Address</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';
    $('#spouse_list').html(spouse_tbl);
	spouse_tableOptions = {dom: '',
						ajax : "<?= base_url('index.php/admin/employees/get_spouse_json?employee_id="+emp_id+"') ?>",
						fnDrawCallback: function() {
								$('.spouse_name').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_spouse') ?>",
									success: function() {
										spouse_oTable.api().ajax.reload();
									}
								});
								$('.spouse_birth_date').editable({
									type: 'combodate',
									mode:'popup',
									combodate: {maxYear: "<?= date('Y') ?>", minYear: "1900"},
									url: "<?= base_url('index.php/admin/employees/update_sis_spouse') ?>",
									success: function() {
										spouse_oTable.api().ajax.reload();
									}
								});
								$('.spouse_date_of_marriage').editable({
									type: 'combodate',
									mode:'popup',
									combodate: {maxYear: "<?= date('Y') ?>", minYear: "1900"},
									url: "<?= base_url('index.php/admin/employees/update_sis_spouse') ?>",
									success: function() {
										spouse_oTable.api().ajax.reload();
									}
								});
								$('.spouse_occupation').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_spouse') ?>",
									success: function() {
										spouse_oTable.api().ajax.reload();
									}
								});
								$('.spouse_employer').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_spouse') ?>",
									success: function() {
										spouse_oTable.api().ajax.reload();
									}
								});
								$('.spouse_employer_address').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_spouse') ?>",
									success: function() {
										spouse_oTable.api().ajax.reload();
									}
								});
							},
							initComplete: function() {
								if(this.api().rows().count() == 0) {
									$('#spouse_list').html('');
								}
							}
						};
    spouse_oTable = $('#spouse_table').dataTable(spouse_tableOptions);


    educ1_tbl = '<table id="educ1_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Attainment</th>\
											<th>Name of School</th>\
											<th>Year Graduated</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';
    $('#educ1_list').html(educ1_tbl);
	educ1_tableOptions = {dom: '',
						ajax : "<?= base_url('index.php/admin/employees/get_educ1_json?employee_id="+emp_id+"') ?>",
						fnDrawCallback: function() {
								$('.ee_attainment').editable({
									mode:'inline',
									type: 'select',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									source: [
										{value: 'Elementary', text: 'Elementary'},
										{value: 'High School', text: 'High School'}
									],
									success: function() {
										educ1_oTable.api().ajax.reload();
									}
								});
								$('.ee_school_name').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ1_oTable.api().ajax.reload();
									}
								});
								$('.ee_year_graduated').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ1_oTable.api().ajax.reload();
									}
								});
							},
							initComplete: function() {
								if(this.api().rows().count() == 0) {
									$('#educ1_list').html('');
								}
							}
						};
    educ1_oTable = $('#educ1_table').dataTable(educ1_tableOptions);


    educ2_tbl = '<br><table id="educ2_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Attainment</th>\
											<th>Course Taken</th>\
											<th>Name of School</th>\
											<th>Units Earned</th>\
											<th>Ongoing No. of Units Taken</th>\
											<th>Year Graduated</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';
    $('#educ2_list').html(educ2_tbl);
	educ2_tableOptions = {dom: '',
							ajax : "<?= base_url('index.php/admin/employees/get_educ2_json?employee_id="+emp_id+"') ?>",
							fnDrawCallback: function() {
								$('.ee_attainment').editable({
									mode:'inline',
									type: 'select',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									source: [
										{value: 'Undergrad', text: 'Undergrad'},
										{value: 'Graduate', text: 'Graduate'},
										{value: 'Post Grad', text: 'Post Grad'},
										{value: 'TechVoc', text: 'TechVoc'}
									],
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
								$('.ee_course_taken').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
								$('.ee_school_name').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
								$('.ee_units_earned').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
								$('.ee_ongoing_units').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
								$('.ee_school_name').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
								$('.ee_year_graduated').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_sis_education') ?>",
									success: function() {
										educ2_oTable.api().ajax.reload();
									}
								});
							},
							initComplete: function() {
								if(this.api().rows().count() == 0) {
									$('#educ2_list').html('');
								}
							}
						};
    educ2_oTable = $('#educ2_table').dataTable(educ2_tableOptions);


    eli_tbl = '<table id="eli_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Program / Module</th>\
											<th>Certificate Level</th>\
											<th>Status</th>\
											<th>Certificate Expiration Date</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';
    $('#eli_list').html(eli_tbl);
	eli_tableOptions = {dom: '',
							ajax : "<?= base_url('index.php/admin/employees/get_eli_json?employee_id="+emp_id+"') ?>",
							fnDrawCallback: function() {
								$('.emp_el_program').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_eligibility') ?>",
									success: function() {
										eli_oTable.api().ajax.reload();
									}
								});
								$('.emp_el_certificate_level').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_eligibility') ?>",
									success: function() {
										eli_oTable.api().ajax.reload();
									}
								});
								$('.emp_el_status').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_eligibility') ?>",
									success: function() {
										eli_oTable.api().ajax.reload();
									}
								});
								$('.emp_el_certificate_exp').editable({
									type: 'combodate',
									mode:'popup',
									combodate: {maxYear: "<?= date('Y') ?>", minYear: "1900"},
									url: "<?= base_url('index.php/admin/employees/update_eligibility') ?>",
									success: function() {
										eli_oTable.api().ajax.reload();
									}
								});
							},
							initComplete: function() {
								if(this.api().rows().count() == 0) {
									$('#eli_list').html('');
								}
							}
						};
    eli_oTable = $('#eli_table').dataTable(eli_tableOptions);


    aff_tbl = '<table id="aff_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Club/Organization\'s Name</th>\
											<th>Membership Type</th>\
											<th>Status</th>\
											<th>Membership Expiration Date</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';
    $('#aff_list').html(aff_tbl);
	aff_tableOptions = {dom: '',
							ajax : "<?= base_url('index.php/admin/employees/get_aff_json?employee_id="+emp_id+"') ?>",
							fnDrawCallback: function() {
								$('.emp_aff_org_name').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_affilation') ?>",
									success: function() {
										aff_oTable.api().ajax.reload();
									}
								});
								$('.emp_aff_membership_type').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_affilation') ?>",
									success: function() {
										aff_oTable.api().ajax.reload();
									}
								});
								$('.emp_aff_status').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_affilation') ?>",
									success: function() {
										aff_oTable.api().ajax.reload();
									}
								});
								$('.emp_aff_membership_exp').editable({
									type: 'combodate',
									mode:'popup',
									combodate: {maxYear: "<?= date('Y') ?>", minYear: "1900"},
									url: "<?= base_url('index.php/admin/employees/update_affilation') ?>",
									success: function() {
										aff_oTable.api().ajax.reload();
									}
								});
							},
							initComplete: function() {
								if(this.api().rows().count() == 0) {
									$('#aff_list').html('');
								}
							}
						};
    aff_oTable = $('#aff_table').dataTable(aff_tableOptions);


    ets_tbl = '<table id="ets_table" class="table table-bordered table-striped">\
									<thead>\
										<tr>\
											<th>Name/Title of Training/Seminar</th>\
											<th>Inclusive Dates</th>\
											<th>Venue</th>\
											<th>Training Provider</th>\
											<th>Action</th>\
										</tr>\
									</thead>\
									<tbody></tbody></table><br>';
    $('#ets_list').html(ets_tbl);
	ets_tableOptions = {dom: '',
							ajax : "<?= base_url('index.php/admin/employees/get_ets_json?employee_id="+emp_id+"') ?>",
							fnDrawCallback: function() {
								$('.ets_title').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_training_seminar') ?>",
									success: function() {
										ets_oTable.api().ajax.reload();
									}
								});
								$('.ets_date').editable({
									type: 'combodate',
									mode:'popup',
									combodate: {maxYear: "<?= date('Y') ?>", minYear: "1900"},
									url: "<?= base_url('index.php/admin/employees/update_training_seminar') ?>",
									success: function() {
										ets_oTable.api().ajax.reload();
									}
								});
								$('.ets_venue').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_training_seminar') ?>",
									success: function() {
										ets_oTable.api().ajax.reload();
									}
								});
								$('.ets_provider').editable({
									mode:'inline',
									url: "<?= base_url('index.php/admin/employees/update_training_seminar') ?>",
									success: function() {
										ets_oTable.api().ajax.reload();
									}
								});
							},
							initComplete: function() {
								if(this.api().rows().count() == 0) {
									$('#ets_list').html('');
								}
							}
						};
    ets_oTable = $('#ets_table').dataTable(ets_tableOptions);
//END
	

	return false;
})
function reload_emp_list () {
  table.ajax.reload();
}
//@Author: ARIEL
	function delete_row(url, id, elem) {
		$.post(url,
			{id : id}, 
			function() {
				$(elem).closest('tr').fadeOut(function() {
					$(this).closest('tr').remove();
					if($(elem).attr('name') === 'spouse') {
						if((spouse_oTable.api().rows().count()-1) == 0) {
							$('#spouse_list').html('');
						}
						spouse_oTable.api().ajax.reload();
					}
					if($(elem).attr('name') === 'dependent') {
						if((dep_oTable.api().rows().count()-1) == 0) {
							$('#dep_list').html('');
						}
						dep_oTable.api().ajax.reload();
					}
					if($(elem).attr('name') === 'educ1') {
						if((educ1_oTable.api().rows().count()-1) == 0) {
							$('#educ1_list').html('');
						}
						educ1_oTable.api().ajax.reload();
					}
					if($(elem).attr('name') === 'educ2') {
						if((educ2_oTable.api().rows().count()-1) == 0) {
							$('#educ2_list').html('');
						}
						educ2_oTable.api().ajax.reload();
					}
					if($(elem).attr('name') === 'eli') {
						if((eli_oTable.api().rows().count()-1) == 0) {
							$('#eli_list').html('');
						}
						eli_oTable.api().ajax.reload();
					}
					if($(elem).attr('name') === 'aff') {
						if((aff_oTable.api().rows().count()-1) == 0) {
							$('#aff_list').html('');
						}
						aff_oTable.api().ajax.reload();
					}
					if($(elem).attr('name') === 'ets') {
						if((ets_oTable.api().rows().count()-1) == 0) {
							$('#ets_list').html('');
						}
						ets_oTable.api().ajax.reload();
					}
				});
			});
	}

	function clear_all() {
		$('#spouse_div').load('<?= base_url("index.php/admin/employees"); ?> #spouse_content');
		$('#dep_div').load('<?= base_url("index.php/admin/employees"); ?> #dep_content', function() {
			$('.dependency').bootstrapSwitch({
				state: 'true',
				size: 'mini',
				onText: 'Yes',
				offText: 'No',
				offColor: 'danger'
			});
		});
		$('#educ1_div').load('<?= base_url("index.php/admin/employees"); ?> #educ1_div');
		$('#educ2_div').load('<?= base_url("index.php/admin/employees"); ?> #educ2_div');
		$('#eli_div').load('<?= base_url("index.php/admin/employees"); ?> #eli_div');
		$('#aff_div').load('<?= base_url("index.php/admin/employees"); ?> #aff_div');
		$('#ets_div').load('<?= base_url("index.php/admin/employees"); ?> #ets_div');
	}
//END


/*------------------ EAF DELETE FUNCTIONS ------------------ */
function delete_spouse(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_spouse"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_children(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_children"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_relative(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_relative"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_education(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_education"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_employment(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_employment"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_teaching(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_teaching"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_emprec(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_emprec"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_training(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_training"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_orgs(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_orgs"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}
function delete_references(id,fade) {
				$.post(
					'<?= base_url("index.php/admin/employees/delete_references"); ?>',
					{id : id}, 
					function() {
							$(fade).closest('tr').fadeOut(function(){
								$(this).closest('tr').remove();
							});
						});
					}

	
</script>