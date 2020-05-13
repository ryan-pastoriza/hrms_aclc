<script type="text/javascript">
	var editableOptions;
	var dataTableOptions;
	var dedPhilhealthDataTable;
	$(function(){
   		dataTableOptions = {
		          "ajax": { "url": "<?= base_url() ?>index.php/admin/deductions/deductions_philhealth_data",
		      				"data": function(d){ d.employee_id = $('#searchEmp').val(); },
		      				type:"POST",
		      				beforeSend: function(){
		      					$('#philhealthTable').css({opacity:"0.5"});
		      				},
		      				complete:function(){
		      					$('#philhealthTable').css({opacity:"1"})
		      				}
		      			},
		          fnDrawCallback: function(){
		            $('.editable').editable(editableOptions);
          },
        }

     editableOptions = {
          url:"<?= base_url() ?>index.php/admin/deductions/update_philhealth",
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
		dedPhilhealthDataTable = $('#philhealthTable').DataTable(dataTableOptions);
	});


	function refresh_leave_vacation(){
		  dedPhilhealthDataTable.ajax.reload();
	}

</script>
	<table class="table table-bordered table-hover" id="philhealthTable">
		<thead>
			<tr>
			    <th><center>Salary Bracket</center></th>
			    <th><center>Salary Range</center></th>
			    <th><center>Salary Base</center></th>
			    <th><center>Total Monthly Premium</center></th>
			    <th><center>Employee Share</center></th>
			    <th><center>Employer Share</center></th>
			</tr>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all" id='philhealthLV'>
	    </tbody>
	</table>
	