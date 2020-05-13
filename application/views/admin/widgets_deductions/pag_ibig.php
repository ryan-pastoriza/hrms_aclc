
<script type="text/javascript">
	var editableOptions;
	var dataTableOptions;
	var dedPagibigDataTable;
	$(function(){
   		dataTableOptions = {
		          "ajax": { "url": "<?= base_url() ?>index.php/admin/deductions/deductions_pagibig_data",
		      				"data": function(d){ d.employee_id = $('#searchEmp').val(); },
		      				type:"POST",
		      				beforeSend: function(){
		      					$('#pagibigTable').css({opacity:"0.5"});
		      				},
		      				complete:function(){
		      					$('#pagibigTable').css({opacity:"1"})
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
		dedPagibigDataTable = $('#pagibigTable').DataTable(dataTableOptions);
	});


	function refresh_deductions_pagibig(){
		  dedPagibigDataTable.ajax.reload();
	}

</script>
	<table class="table table-bordered table-hover" id="pagibigTable">
		 <thead>
            <tr>
             
              <th rowspan="2" width="2px"><center>Monthly Compensation</center></th>
              <th colspan="2"><center>Percentage of monthly compensation</center></th>
              
            </tr>
            <tr>
             
              <th width="100px"><center>Employee Share</center></th>
              <th width="100px"><center>Employer Share</center></th>
            </tr>
          </thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all" id='pagibigLV'>
	    </tbody>
	</table>
	