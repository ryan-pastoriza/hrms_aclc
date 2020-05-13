<script type="text/javascript">
var selectedDepartment;
	$(function(){
		$('.select2').select2();
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
	     	if ($(this).val() == 0) {
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

		var cal = $('#calendar').fullCalendar({
			eventSources: [
							{
								url: "<?= base_url('index.php/admin/department_schedule/cal_events') ?>",
								type: 'POST',
								data: function () { // a function that returns an object
							                return {
												department_id: selectedDepartment,
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
      		dayClick: function(date,jsEvent,view){
      			var departmentSelected = $('#department-selector').val();
      			if( departmentSelected == ''){
      				toastr.error("No Department Selected! <br> Select a department to start viewing schedule.");
      			}
      			else{

      			}
      		},
      		eventRender: function(event, element) {

                element.html(event.title+"<div class='event-buttons'>\
	                    						<a href='#' edit-event='"+event.sched_id+"' event-type='"+event.objectClass+"' ><i  class='fa fa-edit' id='"+event.id+"'></i></a>\
                    							<a href='#' delete-event='"+event.sched_id+"' sched-type='"+event.schedType+"' ><i  class='fa fa-trash' id='"+event.id+"'></i></a>\
                    						</div>");

               	if (typeof event.dow !== "undefined" && event.end != null) {
               		var has_irreg =  irreg_overlap(event.start, event.end, $('#calendar').fullCalendar('clientEvents'));
			          if (has_irreg != false) {
			            return false;
			          }
			          else{
					      return (event.ranges.filter(function(range){
					        return (moment(event.start).isBefore(range.end) &&
					        moment(event.end).isAfter(range.start));
					      }).length) > 0;
					  }
			    }
            },
		});

		$('select').on('change', function(){
			selectedDepartment = $('#department-selector').val();
			$('#dept_id_hidden').val(selectedDepartment);
			$('#calendar').fullCalendar('refetchEvents');
		})
		$('.datesPicker').multiDatesPicker();

		$('#set_schedule').ajaxForm({
			beforeSubmit: function(a,b,c){
				// alert($("[name=regirreg][value=1]:checked").length);
				this.data = {dept_id: selectedDepartment};
				dept_id = $('#department-selector').val();
				if (typeof selectedDepartment === "undefined") {
      				toastr.error("No Department Selected! <br> Select a department to start setting schedule.");
					return false;
				}
				else if( ($("[name=regirreg][value=1]:checked").length > 0) && ($("input[type=checkbox]:checked").length < 1) ){
					toastr.error("No Day Selected! <br> Select a day to start setting regular schedule.");
					return false;
				}
				else if( $("[name=regirreg][value=1]:checked").length > 0 && $('[name=date_start]').val() == "" ){
					toastr.error("No Date Start Selected!");
					return false;
				}
				else if( $("[name=regirreg][value=0]:checked").length > 0 && $('.datesPicker').multiDatesPicker('value') == "" ){
					toastr.error("No Date Selected!");
					return false;
				}
				else{
					$('.loading-div').removeClass('hidden');
					$(b).find("button:submit").attr('disabled','disabled');
				}
			},
			complete: function(a,b,c,d){
				var ret = a.responseJSON;
				$('.loading-div').addClass('hidden');

				$(c).find("button:submit").removeAttr('disabled');
				if (ret.success == false) {
					toastr.options.timeOut = 0;
					toastr.error(ret.text);
				}
				else{
					$(c).find("[name=overwrite]").val('0');
					toastr.success("Schedule set successfully");
					$('.select2').trigger('change');
				}

			},
			dataType: 'json'
		});

		$('#edit-sched-modal').ajaxForm({
			beforeSubmit: function(a,b){
				$(b).find(":submit").attr('disabled','disabled');
			},
			complete: function(a,b,c,d){
				$(c).find(":submit").removeAttr('disabled');
				var ret = a.responseJSON;
				if (ret.success == false) {
					toastr.error(ret.txt);
				}
				else{
					toastr.success(ret.txt);
					$('.modal').modal('hide');
					$('.select2').trigger('change');
				}
			},
			dataType: 'json'

		})
		$('#delete-sched-form').ajaxForm({
			beforeSubmit: function(a,b,c){
				$(c).find(":submit").attr('disabled','disabled');
			},
			success: function(a,b,c){
				toastr.success("Department Schedule Has Been Deleted!");
				$(b).find(":submit").removeAttr('disabled');
				$('.modal').modal('hide');
				$('.select2').trigger('change');
			}
		})


	})
	
	$(document).on('click','.update-override-btn',function(){
		$('#edit-sched-modal [name=edit_sched_overwrite]').val('1');
		$('#edit-sched-modal :submit').trigger('click');
	});
	$(document).on('click','.override-btn',function(){
		$("input:hidden[name=overwrite]").val('1');
		$('#set_schedule button:submit').trigger('click');
	});
	$(document).on('click','[edit-event]',function(){
		var id = $(this).attr('edit-event');
		var event_type = $(this).attr('event-type');

		$('#edit-sched-modal').modal('show');
		$('#edit-sched-view').html("<h3> Fetching Schedule Information . . . </h3>");
		$.post("<?= base_url('index.php/admin/department_schedule/edit_schedule_view') ?>","id="+id+"&event_type="+event_type,function(r){
			$('#edit-sched-view').html(r);
		})
		return false;
	});
	$(document).on('click','[delete-event]',function(){
		var schedType 	= $(this).attr('sched-type');
		var id 			= $(this).attr('delete-event');

		$('#delete-sched-form [name=id]').val(id);
		$('#delete-sched-form [name=sched_type]').val(schedType);
		$('#delete-sched-modal').modal('show');

		return false;
	});

	$(document).on('click','#clearDatesBtn',function(){
		$('.datesPicker').multiDatesPicker('resetDates', 'picked');
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
	function irreg_overlap(from,to,events){
	    var toret = false;
	    $.each(events,function(k,v){
	      if (v.schedType == 'irreg' && v.end !== null) {
	        if (moment(from).format('YYYY-MM-DD') == moment(v.start).format('YYYY-MM-DD') ) {
	           	var bet  = from.isBetween(v.start,v.end,'[]') || to.isBetween(v.start,v.end,'[]')|| v.start.isBetween(from, to,'[]') || v.end.isBetween(from, to, '[]') ;
	            if(bet){
	            	toret = true;
	            	return;
	            }
	        }
	      }
	    });
	    return toret;
	}

</script>