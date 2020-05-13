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
		      					$('#vacationTable').css({opacity:"0.5"});
		      				},
		      				complete:function(){
		      					$('#vacationTable').css({opacity:"1"})
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
		empLeaveDataTable = $('#vacationTable').DataTable(dataTableOptions);
	});


	function refresh_leave_vacation(){
		  empLeaveDataTable.ajax.reload();
	}

</script>
	<table class="table table-bordered table-hover" id="vacationTable">
		<thead>
			<tr>
			    <th>Earned</th>
			    <th>Used</th>
			    <th>Left</th>
			</tr>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all" id='vacationLV'>
	    </tbody>
	</table>
	