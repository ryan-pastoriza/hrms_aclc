<style type="text/css">
	.fc-time{
		display:none;
	}
</style>

<script type="text/javascript">
	$(function(){

		var m_y;
		$(document).on('click',".fc-next-button",function(e){
			var d = new Date($("#myCalendar").fullCalendar('getDate'));
			var month = d.getMonth();
			var my_month;
			if(month <=8){
				my_month = "0"+(month+1);
			}else if(month == 9){
				my_month = month+1
			}else{
				my_month  = month+1
			}
			m_y = my_month +" " + d.getFullYear();
		});
		$(document).on('click',".fc-prev-button",function(e){

			var d = new Date($("#myCalendar").fullCalendar('getDate'));
			var month = d.getMonth();
			var my_month;
			if(month <=8){
				my_month = "0"+(month+1);
			}else if(month == 9){
				my_month = month+1
			}else{
				my_month  = month+1
			}
			 m_y = my_month +" " + d.getFullYear();
		});

		$(document).on("click","#delEvent",function(e){
			aa = $('#evt_id').val();
			$.post('<?= base_url("index.php/admin/my_calendar/delete_event") ?>',"id="+aa,function(data){
					$.gritter.add({
						title: "Deleted...",
						text: "",
						class_name:"bg-green",
						sticky:false,
						time:6000
					});
					$("#myCalendar").fullCalendar("refetchEvents");
					$('#modal').modal("hide");
			});
			e.preventDefault();
		});
		
		$(document).on("click","#editEvent",function(e){
			id = $("#evt_id").val();
			$.post("<?= base_url() ?>index.php/admin/my_calendar/view_event","id="+id,function(data){
				// console.log(data)
				$.each(data,function(k,v){
					var element = $("#eventForm [name="+k+"]");
					if (k == "event_type"){
						var newStateVal = v;
						if ($("#event-type").find("option[value='" + newStateVal + "']").length) {
				        	$("#event-type").val(newStateVal).trigger("change");
				      	} else { 
				        	// Create the DOM option that is pre-selected by default
				        	var newState = new Option(newStateVal, newStateVal, true, true);
				        	// Append it to the select
				        	$("#event-type").append(newState).trigger('change');
				      	} 


						
						// var newState = new Option(newStateVal, newStateVal, true, true);
						// $("#event-type").append(newState).trigger('change');
					}
					if(k == "reportrange"){
							$("#"+k).val(v)
					}
					if(element.length > 0){
						element.val(v);

						element.trigger("change");

					}

				});
				$("#modal").modal("hide");
				$("#frm-evt-id").val(id);
				$("#addEventBtn").html("Update");
			},"json");
			e.preventDefault();
		});




		$('#myCalendar').fullCalendar({
			aspectRatio:2.2,
			height: 600,
			eventLimit: true,
			views: {
		        		agenda: {
		            		eventLimit: 3 // adjust to 6 only for agendaWeek/agendaDay
		       			}
		    		},
		    header: {
			        	left:   'prev,next today',
			        	center: 'title',
			        	right:  false,
			        	allDay:true
			    	},
			eventClick:function(event){
				id = event.event_id;
				$.post("<?= base_url('index.php/admin/my_calendar/show_details')?>",{id:id,monthYear:m_y},function(e){
					$("#title").html(e.title);
					if(e.pay == 1){
						$("#py").html("With Pay");
					}else{
						$("#py").html("No Pay");
					}
					if(e.work == 1){
						$("#wk").html("Work");
					}else{
						$("#wk").html("No Work");
					}
					$("#fdate").html(e.start);
					$("#edate").html(e.end);
					$("#evtype").html(e.event_type);
					$("#description").html(e.description);
					$("#evt_id").val(e.event_id);
					
					$("#modal").modal("show");

				},"json");
			},
			   	
			events:"<?= base_url('index.php/admin/my_calendar/show_event'); ?>",
		});

		var d = new Date($("#myCalendar").fullCalendar('getDate'));
		var month = d.getMonth();
		var my_month;
		if(month <=8){
			my_month = "0"+(month+1);
		}else if(month == 9){
			my_month = month+1
		}else{
			my_month  = month+1
		}
		m_y = my_month +" " + d.getFullYear();


	});

	function fullDate(data){
		var month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		var d = new Date(data);
		var ret = month[d.getMonth()] + " "+ d.getDate() + ", " + d.getFullYear();
		return	ret;
	}
</script>

	<div class="modal fade" id="modal" style="color:#FFF;">
      	<div class="modal-dialog">
        	<div class="modal-content bg-aqua">
          		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		<h4 class="modal-title">Event &amp; Holidays</h4>
          		</div>
          		<div class="modal-body">
					<div class="info-box" style="box-shadow: none;background-color:#00C0EF;">
					    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
					    <div class="info-box-content">
					      	<span class="info-box-text" id="title" style="font-size:25px !important;margin-top:-12px;"></span>
					      	<div class="progress">
		                    	<div class="progress-bar" style="width: 95%"></div>
		                  	</div>
		                  	<span class="progress-description">
		                  		<table>
		                  			<tr>
		                  				<td style="width:50px;">Date Start</td>
		                  				<td style="width:10px;"> : </td>
		                  				<td><span id="fdate"></span></td>
		                  			</tr>
		                  			<tr>
		                  				<td style="width:50px;">Date End</td>
		                  				<td style="width:10px;"> : </td>
		                  				<td><span id="edate"></span></td>
		                  			</tr>
		                  			<tr>
		                  				<td style="width:50px;">Event Type</td>
		                  				<td style="width:10px;"> : </td>
		                  				<td><span id="fdate"><?php echo ucfirst('<span id="evtype"></span>'); ?></span></td>
		                  			</tr>
		                  			<tr>
		                  				<td style="width:50px;">Pay</td>
		                  				<td style="width:10px;"> : </td>
		                  				<td><span id="fdate"><span id="py"></span></td>
		                  			</tr>
		                  			<tr>
		                  				<td style="width:50px;">Work</td>
		                  				<td style="width:10px;"> : </td>
		                  				<td><span id="fdate"><span id="wk"></span></td>
		                  			</tr>
		                  			<tr>
		                  				<td style="width:50px;">Description</td>
		                  				<td style="width:10px;"> : </td>
		                  				<td><span id="fdate"><span id="description"></span></td>
		                  			</tr>

		                  		</table>
		                  	</span>
					    </div>
					</div>
          		</div>
          		<div class="modal-footer">
          			<input type="text" id="evt_id" hidden>
          			<button type="button" class="btn btn-outline pull-left" id="delEvent">Delete</button>
          			<button type="button" class="btn btn-outline pull-left" id="editEvent">Edit</button>
          		</div>
        	</div>
      	</div>
    </div>


