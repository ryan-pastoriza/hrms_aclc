



<?php
/**
 * @Author: gian
 * @Date:   2016-08-16 10:49:52
 * @Last Modified by:   Gian
 * @Last Modified time: 2017-07-05 14:17:16
 */

$body = "<div class='col-md-12'>

			<div class='row'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Title</label>
					<div class='col-md-10'>
						<input type='text' class='form-control' name='title' required />
					</div>
				</div>
			</div>

			<div class='row'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Type</label>
					<div class='col-md-10'>
						<select class='form-control' select='selected' id='type' name='type'>
							<option>-Select-</option>
							<option value='one day'>One Day</option>
							<option value='long event'>Long Event</option>
							<option value='repeat'>Repeat</option>
						</select>
					</div>
				</div>
			</div>

			<div class='row hidden' id='repeat'>
				<div class='form-group'>
					<label class='col-md-3' style='padding-top:8px;font-size:12px;'>Repeat type</label>
					<div class='col-md-9'>
						<select class='form-control' select='selected' id='selRep' name='repeat'>
							<option>-Select-</option>
							<option value='monthly'>Monthly</option>
							<option value='yearly'>Yearly</option>
						</select>
					</div>
				</div>
			</div>

			<div class='row hidden' id='oneD'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Date</label>
					<div class='col-md-10'>
						<div class='input-group date' id='startDay'>
							<input type='text' id='from_one_d' class='form-control' name='from_date' placeholder='Click the calendar icon to select date'/>
							<input type='text' name='one_d' id='one_d' hidden/>
							<span class='input-group-addon'>
								<i class='fa fa-calendar'></i>
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class='row hidden' id='longE'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Date</label>
					<div class='col-md-10'>
						<input type='text' id='reportrange' class='form-control' placeholder='Click the calendar icon to select date'/>
						<input type='text' name='long_from' id='long_from' hidden/>
						<input type='text' name='long_to' id='long_to' hidden/>
					</div>
				</div>
			</div>

			<!-- monthly  -->
			<div class='row hidden' id='monthly'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Date</label>
					<div class='col-md-10'>
						<div class='input-group date' id='dateMonthly'>
							<input type='text' id='frm_monthly_d' class='form-control' name='from_date' placeholder='Click the calendar icon to select date' />
							<input type='text' name='monthly_d' id='monthly_d' hidden />
							<span class='input-group-addon'>
								<i class='fa fa-calendar'></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!-- monthly -->
			<!-- yearly -->

			<div class='row hidden' id='yearType'>
				<div class='form-group'>
					<div class='col-sm-2'></div>
					<div class='col-md-10'>
						<div>
							<label style='font-weight:normal;'>
								<input type='radio' name='dateType' id='nString' checked='checked'> Date
							</label>
							<label style='font-weight:normal;'>
								<input type='radio' name='dateType' id='sString' checked='checked'> String
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class='row hidden' id='yearly'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Date</label>
					<div class='col-md-10'>
						<div class='input-group date' id='dateYearly'>
							<input type='text' id='yearly_date' class='form-control' name='from_date' placeholder='Click the calendar icon to select date' />
							<input type='text' name='yearly_d' id='yearly_d' hidden/>
							<span class='input-group-addon'>
								<i class='fa fa-calendar'></i>
							</span>
						</div>
					</div>
				</div>
			</div>

			<!-- yearly -->
			<!-- dynamictext-->
			<div class='row hidden' id='dynamic-text'>
				<div class='form-group'>
					<div class='col-sm-3'>
						<input type='text' class='form-control' id='date_number' name='dateNum' placeholder='eg. 1st'>
					</div>
					<div class='col-sm-4'>
						<input type='text' class='form-control' id='date_day' name='dateDay' placeholder='eg. Sunday'>
					
					</div>
					<label class='col-sm-1 control-label' style='font-size:12px;text-align:left;'>of</label>
					<div class='col-sm-4'>
						<input type='text' class='form-control' id='date_month' name='dateMonth' placeholder='eg. November'>
					</div>
				</div>
			</div>
			<!-- dynamictext-->

			<div class='row hidden' id='timeSet'>
				<div class='form-group'>
					<div class='col-sm-12'>
						<div class='col-sm-6'>
							<div class='form-group'>
								<label class='col-md-5' style='padding-top:8px;font-size:12px;text-align:left;'>Time From</label>
								<div class='col-md-7'>
									<input type='time' class='form-control' name='timeFrom'>
								</div>
							</div>
						</div>
						<div class='col-sm-6'>
							<div class='form-group'>
								<label class='col-md-5' style='padding-top:8px;font-size:12px;text-align:left;'>Time To</label>
								<div class='col-md-7'>
									<input type='time' class='form-control' name='timeTo'>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class='row'>
				<div class='form-group'>
					<div class='col-sm-2'></div>
					<div class='col-sm-10'>
						<div class='checkbox'>
							<label> 
								<input type='checkbox' name='pay' id='pay' checked='checked' value='1'>Pay 
							</label>
							<label>
							<input type='checkbox' name='work' id='work' checked='checked' value='1'>Work 
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class='row'>
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Event Type</label>
					<div class='col-md-10'>
						<select class='select2 form-control' id='event-type' name='event_type'>
							<option value='holiday'>Holiday</option>
							<option value='non-academic'>Non-Academic</option>
							<option value='academic'>Academic</option>
							<option value='institutional'>Institutional</option>
						</select>
					</div>
				</div>
				<input id='new-state' type='text' hidden/>
				<button type='button' id='btn-add-state' hidden>Set state value</button>
			</div>

			<div class='row'>
				<input type='text' id='frm-evt-id' name='evt_id' hidden />
				<div class='form-group'>
					<label class='col-md-2' style='padding-top:8px;font-size:12px;'>Description</label>
					<div class='col-sm-10'>
						<textarea class='form-control' placeholder='eg. This is a holiday' style='resize:none;height:100px;' name='description'></textarea>	
					</div>
				</div>
			</div>

		 </div>
        ";


		echo lte_widget(4,array( "header" => "Event Form",
								 "col_grid" => col_grid(12,12,4),
								 "bgColor"	=> "box-info",
								 "body"	=> $body,
								 "foot" 			=>	'
													 
													 <button name="addEventBtn" value="Add Event" id="addEventBtn" class="btn btn-primary btn-flat">Add Event</button>
													',
								 "formData"		=> array(
															'form_open' => form_open('admin/my_calendar/add_event', 'class="form-horizontal" id="eventForm" '),
															'ajaxform'	=> array('beforSubmit' => 'function(e){
																										$("#addEventBtn").attr("disabled","disabled");
	                                  																	$("#addEventBtn").html("Submitting");
																								   }',
																				  'complete'   => 'function(data){
																				  					// console.log(data)
																				  						if(data.responseJSON.success == true){
																				  							$.gritter.add({
																				  								title: "Adding success.",
																				  								text: "",
																				  								class_name: "bg-green",
																				  								sticky:false,
																				  								time:6000
																				  							});

																				  							$("#eventForm input").not(":radio ,:checkbox, :button, :submit, :reset, :hidden").val("");
		          																							$("#eventForm textarea").not(":button, :submit, :reset, :hidden").val("");
		          																							$("#eventForm select>option:first-child").prop("selected","selected").trigger("change");
		          																							$("#fixed").trigger("click");
		          																							if (!$("#pay").is(":checked")) {
		          																								$("#pay").trigger("click");
		          																							}
																									        if(!$("#work").is(":checked")){
																									        	$("#work").trigger("click");
																									        }
																									        if(!$("#non-academ").is(":checked")){
																									        	$("#non-academ").trigger("click");
																									        }
																									        if($("#yearly").is(":checked")){
																									        	$("#yearly").trigger("click");
																									        }
																									        
																				  							$("#myCalendar").fullCalendar("refetchEvents");
																				  							$("#addEventBtn").removeAttr("disabled");
	                                																		$("#addEventBtn").html("Add Event");
																				  						}																	  						
																				  				   }',
																				  'dataType'   => '"JSON"'
																				),
														),
								"formID"		=> "eventForm"
							)
				    );
?>

