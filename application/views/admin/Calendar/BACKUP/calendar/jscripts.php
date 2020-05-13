<style type="text/css">
	.fc-time{
		display:none;
	}
</style>

<script type="text/javascript">
	$(function(){
		$('#myCalendar').fullCalendar({
			height: 600,
			eventLimit: true,
			views: {
		        		agenda: {
		            		eventLimit: 4 // adjust to 6 only for agendaWeek/agendaDay
		       			}
		    		},
		    header: {
			        	left:   'prev,next today',
			        	center: 'title',
			        	right:  false
			    	},
			events:"<?= base_url('index.php/admin/my_calendar/show_event'); ?>"
		});

		// $('#myCalendar').fullCalendar('addEventSource',
		// 	function(start, end, timezone, callback) {	
		// 		// base_url("index.php/admin/my_calendar/repeatable_event");
		// 		$.post('<?= base_url('index.php/admin/my_calendar/show_all_events') ?>',function(data){
		// 			$.each(data, function(key, value){
		// 			    	var events = [];
		// 			    	var one_day = (24 * 60 * 60 * 1000);
		// 			    	var fromDate = new Date(value.start);
		// 			    	// console.log(value)
		// 			        for(loop = start.toDate().getTime(); loop <= end.toDate().getTime(); loop = loop + one_day){
		// 			       		var d = new Date(loop);
		// 			       		if(d.getMonth() == fromDate.getMonth() && d.getDate() == fromDate.getDate() && d.getFullYear() == fromDate.getFullYear()){
		// 			       			events.push(value);
		// 			       		}
		// 			        }
		// 			     callback( events );
		// 			});
		// 		},'JSON');
		//     }
		// );
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
        	<div class="modal-content" style="background-color:#369886;">
          		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		<h4 class="modal-title">Event &amp; Holidays</h4>
          		</div>
          		<div class="modal-body">
					<div class="info-box" style="box-shadow: none;background-color:#369886;">
					    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
					    <div class="info-box-content">
					      	<span class="info-box-text" id="title" style="font-size:25px !important;margin-top:-12px;"></span>
					      	<div class="progress">
		                    	<div class="progress-bar" style="width: 95%"></div>
		                  	</div>
		                  	<span class="progress-description">
		                    	<p>Start : <span id="eventFromDate"></span><br>
		                    	   End &nbsp;&nbsp;: <span id="eventToDate"></span><br>
		                    	   Description :  <span id="description"></span>
		                    	</p>
		                  	</span>
					    </div>
					</div>
          		</div>
        	</div>
      	</div>
    </div>
