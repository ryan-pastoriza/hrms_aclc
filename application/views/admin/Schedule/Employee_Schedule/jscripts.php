<script type="text/javascript">
var empSelected;
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
	                          $('#empID').val(empSelected);
								$('.calendar').fullCalendar('refetchEvents');
	                        },
	                        data: function () {
	                              var data = <?= $allEmps ?>;
	                              // console.log(data);

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

	  	$('input:radio').iCheck({
	          checkboxClass: 'icheckbox_flat-green',
	          radioClass: 'iradio_flat-blue',
	    });
		$('input:checkbox').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-blue',
	    });

		$('input:checkbox').on('ifChecked', function(b,a){
	    	$(this).parent().parent().css({'color':"#1ABC9C !important"});
	    	$(this).parent().parent().removeClass('text-gray');
	    })
	    $('input:radio').on('ifChecked', function(b,a){
	     	if ($(this).val() == "irreg") {
	     		$('#regForm').addClass('hidden');
	     		$('#irregForm').removeClass('hidden');
	     	}
	     	else{
	     		$('#regForm').removeClass('hidden');
	     		$('#irregForm').addClass('hidden');
	     	}
	    	$(this).parent().parent().css({'color':"#3498DB !important"});
	    	$(this).parent().parent().removeClass('text-gray');
	    })

	    $('input:checkbox').on('ifUnchecked', function(b,a){
	    	// $(this).parent().parent().css({'color':"#1ABC9C !important"});
	    	$(this).parent().parent().addClass('text-gray');
	    })
	    $('input:radio').on('ifUnchecked', function(b,a){
	    	// $(this).parent().parent().css({'color':"#1ABC9C !important"});
	    	$(this).parent().parent().addClass('text-gray');
	    })

		$('.datesPicker').multiDatesPicker();
		$(document).on('click','#clearDatesBtn',function(){
			$('.datesPicker').multiDatesPicker('resetDates', 'picked');
		});
		$(document).on('click','[edit-event]',function(){
			$('#edit-sched-modal').modal('show');
			$('#edit-sched-view').html("<h3 class='tet-gray'> <em>Fetching Information . . .</em> </h3>");
			var id = $(this).attr('edit-event');
			var event_type = $(this).attr('event-type');

			$.post("<?= base_url('index.php/admin/employee_schedule/view_edit_event') ?>","id="+id+"&event_type="+event_type,function(r){
					$('#edit-sched-view').html(r);
				})
		});
		

		$('#set-sched-form').ajaxForm({
			beforeSubmit: function(a,b,c){
				if ($('#searchEmp').val() == "") {
					toastr.error("Select an employee to start setting schedule.");
					return false;
				}
				else if( $('[name=reg_irreg]:checked').val() == "reg" && $("input:checkbox:checked").length < 1 ){
					toastr.error("Select sched days.");
				}
				else if ($('[name=reg_irreg]:checked').val() == "irreg" && $('.datesPicker').val() == "" ) {
					toastr.error("Select Schedule Dates.");
				}
				else{
					$(b).find("button:submit").attr('disabled','disabled');
					$('.loading-div').removeClass('hidden');
				}
			},
			complete: function(a,b,c,d){
				var ret = a.responseJSON;
				// console.log(a);

				$('.loading-div').addClass('hidden');
				$(c).find("button:submit").removeAttr('disabled');
				if (ret.success == false) {
					toastr.options.timeOut = 0;
					toastr.error(ret.text);
				}
				else{
					$(c).find("[name=overwrite]").val('0');
					toastr.success("Schedule set successfully");
					$('.calendar').fullCalendar('refetchEvents');

				}

			},
			dataType: 'json'
		});
		$('#edit-sched-form').ajaxForm({
			beforeSubmit : function(a,b,c){
				$(b).find("button:submit").attr('disabled','disabled');
			},
			complete: function(a,b,c,d){ 
				var ret = a.responseJSON;

				if (ret.success == false) {
					toastr.options.timeOut = 0;
					toastr.error(ret.text);
				}
				else{
					$('.modal').modal('hide');
					$(c).find("[name=edit_sched_overwrite]").val('0');
					toastr.success("Schedule set successfully");
					$('.calendar').fullCalendar('refetchEvents');
				}
			},
			dataType : "json"
		})
		$('#delete-sched-form').ajaxForm({
			beforeSubmit: function(a,b,c){
				$(b).find("button:submit").attr('disabled','disabled');
			},
			success: function(a,b,c,d){
				$(c).find("button:submit").removeAttr('disabled');
				$('.modal').modal('hide');
				$('.calendar').fullCalendar('refetchEvents');
			},
		})


		calendar = $('.calendar').fullCalendar({
			eventSources: [
							{
								url: "<?= base_url('index.php/admin/employee_schedule/cal_events') ?>",
								type: 'POST',
								data: function () {
							                return {
												employee_id: empSelected,
							                };
							    }
							}
						   ],
			displayEventTime : false,
			header: {
			        left:   'prev,next today',
			        center: 'title',
			        right:  'month,agendaWeek,agendaDay'
			      },
			height: 600,
			aspectRatio: 2,
      		eventRender: function(event, element) {

      			if (event.obj_name == 'Depts_Def_Sched_Nfds' || event.obj_name == 'Department_irregular_sched' ) {
      				var overlapped = overlappedByEmp(event)

      				if(overlapped){
      					return false;
      				}


      				element.html(event.title+"<div class='event-buttons'>\
	                    							<a href='#' delete-event='"+event.sched_id+"' sched-type='"+event.obj_name+"' ><i  class='fa fa-trash' id='"+event.id+"'></i></a>\
	                    						</div>");

      			}
      			else if(event.deleted == 1 ){
      				return false;
      			}
      			else{
		                element.html(event.title+"<div class='event-buttons'>\
			                    						<a href='#' edit-event='"+event.sched_id+"' event-type='"+event.obj_name+"' ><i  class='fa fa-edit' id='"+event.id+"'></i></a>\
		                    							<a href='#' delete-event='"+event.sched_id+"' sched-type='"+event.obj_name+"' ><i  class='fa fa-trash' id='"+event.id+"'></i></a>\
		                    						</div>");
      			}
      				
               	if ( typeof event.dow !== "undefined" ) {
	           		var has_irreg =  irreg_overlap(event.start, event.end, $('.calendar').fullCalendar('clientEvents'),event.dow,event.obj_name,event);
			          if (has_irreg ) {
			            return false;
			          }
			          else{
			          	var deleted = deleted_sched(event)
			          	if(deleted){
			          		return false;
			          	}
			          	else{

			          	return (event.ranges.filter(function(range){
			          		return(moment(range.start).diff(event.start) <= 0 && (moment(range.end).diff(event.end) >= 0) || moment(event.end).format('YYYY-MM-DD') == moment(range.end).format('YYYY-MM-DD') );
					      }).length) > 0;
			          	}
			          }
			    }
			    else{
			    	// var overlapping = isOverlapping(event);

			    }
            },
		});

		function isOverlapping(event){
		    var array = calendar.fullCalendar('clientEvents');
		    for(i in array){
		        if(array[i].id != event.id){
		            if(!(Date(array[i].start) >= Date(event.end) || Date(array[i].end) <= Date(event.start))){
		                return true; 		            
		            }
		        }
		    }
		    return false;
		}
		function overlappedByEmp(event) {
			 var array = calendar.fullCalendar('clientEvents');
			  for(i in array){
			        if(array[i].obj_name == 'Eec_Nfds' && typeof(array[i].sched_obj.deleted_dept_sched) == 1 ){
			        	if(event.dow == event.dow){
			        		if( (moment(array[i].start).isBetween(event.start, event.end,"[]") || moment(array[i].end).isBetween(event.start, event.end,"[]"))) {
			        			if(event.obj_name == 'Depts_Def_Sched_Nfds'){
			        				if(moment(event.ranges[0].start).isBetween(array[i].ranges[0].start, array[i].ranges[0].end,"[]")  || moment(event.ranges[0].end).isBetween(array[i].ranges[0].start, array[i].ranges[0].end,"[]")){
			        					return true;
			        				}
			        			}else if(event.obj_name == 'Department_irregular_sched'){
			        				if(moment(event.start).isBetween(array[i].ranges[0].start, array[i].ranges[0].end,'[]')){
			        					return true;
			        				}

			        			}
				                // return true;
			        		}
			        	}
			        }else if( array[i].obj_name == 'Emp_irreg_sched'){

			        }
			    }
			    return false;
		}
		function deleted_sched(event) {
			 var array = calendar.fullCalendar('clientEvents');
			    for(i in array){
			        if(array[i].deleted == 1){
			        	if(moment(array[i].ranges[0].start).isBetween(event.start, event.end,"[]")){
				                return true;
			        		}
			        	}
			        }
			    
			    return false;
		}
		function irreg_overlap(from,to,events,dow, obj_name, obj){
		    var toret = false;

		    $.each(events,function(k,v){
		    	if(v.end !== null){
			      	if (v.schedType == 'irreg') {
				        if (moment(from).format('YYYY-MM-DD') == moment(v.start).format('YYYY-MM-DD') ) {
				        	if(to != null){
					           	var bet  = from.isBetween(v.start,v.end,'[]') || to.isBetween(v.start,v.end,'[]')|| v.start.isBetween(from, to,'[]') || v.end.isBetween(from, to, '[]') ;
					            if(bet){
					            	toret = true;
					            	return;
					            }
				        	}
				        }
			      	}
			      	else if (v.schedType == 'reg' && v.obj_name == 'Eec_Nfds' && obj_name == "Depts_Def_Sched_Nfds" ) {

			      		if (obj.start.isBetween(v.ranges[0].start, v.ranges[0].end,"[]") || obj.start.format("YYYY-MM-DD") == moment(v.ranges[0].start).format('YYYY-MM-DD') ) {
			      			if (from != null && to != null) {
				      			var bet  = from.isBetween(v.start,v.end,'[]') || to.isBetween(v.start,v.end,'[]') || v.start.isBetween(from, to,'[]') || v.end.isBetween(from, to, '[]') || from.format("YYYY-MM-DD hh:mm") == v.start.format("YYYY-MM-DD hh:mm");
						        if(bet && v.dow[0] == dow[0] ){
						        	toret = true;
						        	return;
						        }
						    }
			      		}
			      	}
		      }
		    });

		    return toret;
		}
		
	})
		// $(document).on('click','[yes-revert-btn]', function(){
		// 	alert(empSelected);
		// })
		$(document).on('click','[yes-revert-btn]',function(r){
		    var t = $(this);
		    t.attr('disabled','disabled');
		    $.ajax({
		              type: "post",
		              url:"<?= base_url('index.php/admin/employee_schedule/revert_to_department') ?>",
		              data: "employee_id="+ empSelected,
		              dataType: 'json',
		            success: function(e){
		                if (e.success == true) {
		                  toastr.success(e.msg);
		                  $('.calendar').fullCalendar('refetchEvents');
		                  $('#revertSchedModal').modal('hide');
		                }
		                t.removeAttr('disabled');
		          	},
		         })
	    })
		$(document).on('click','[delete-event]',function(){
			var id 			= $(this).attr('delete-event');
			var event_type  = $(this).attr('sched-type');

			if(event_type == 'Depts_Def_Sched_Nfds'){
				$('#delete-sched-modal [dates]').removeClass('hidden');
			}


			$('#delete-sched-modal [name=id]').val(id);
			$('#delete-sched-modal [name=employee_id]').val(empSelected);
			$('#delete-sched-modal [name=sched_type]').val(event_type);
			$('#delete-sched-modal').modal('show');

		});
		$(document).on('click','.override-btn',function(){
		  	$('#set-sched-form [name=overwrite]').val(1);
		  	$('#set-sched-form button:submit').trigger('click');
		});
		$(document).on('click','.override-edit-btn',function(){
			// console.log($('#edit-sched-form submit').length);
		  	$('#edit-sched-form [name=edit_sched_overwrite]').val(1);
		  	$('#edit-sched-modal :submit').trigger('click');
		});
</script>