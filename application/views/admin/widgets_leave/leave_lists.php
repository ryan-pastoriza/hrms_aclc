<script type="text/javascript">
	var editableOptions;
	var dataTableOptions;
	var empLeaveDataTable;
	$(function(){
   		dataTableOptions = {
		          "ajax": { "url": "<?= base_url() ?>index.php/admin/leave/employee_leave_data",
		      				"data": function(d){ d.employee_id = $('#searchEmp').val(); },
		      				type:"POST",
		      				beforeSend: function(){
		      					$('#listsTable').css({opacity:"0.5"});
		      				},
		      				complete:function(){
		      					$('#listsTable').css({opacity:"1"})
		      				}
		      			},
		          fnDrawCallback: function(){
		            $('.editable').editable(editableOptions);
          },
        }

     editableOptions = {
          url:"<?= base_url() ?>index.php/admin/leave/update_leave",
          mode:"inline",
          params: function(d){
          	d.employee_id = empSelected;
          	return d;
          },
          ajaxOptions: {
                          // dataType: 'json'
                      },
          success: function(r,nval){
                      if (r.success != true) {
                        $('#notifications').append(r.view);
                        // return false;
                      }
                        },
          send: "always",
                };
		empLeaveDataTable = $('#listsTable').DataTable(dataTableOptions);
	});


	function refresh_leave_others(){
		  empLeaveDataTable.ajax.reload();
	}

</script>
	<table class="table table-bordered table-striped" id="listsTable">
		<thead>
			<tr>
			    <th>Leave ID</th>
			    <th>Name</th>
			    <th>From</th>
			    <th>To</th>
			    <th>Type</th>
			    <th>Reason</th>
			    <th>Date Filed</th>
			</tr>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all" id='listsLV'>
	    </tbody>
	</table>
	
