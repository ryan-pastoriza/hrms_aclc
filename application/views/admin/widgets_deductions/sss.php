
<script type="text/javascript">
	var editableOptions;
	var dataTableOptions;
	var dedSssDataTable;
	$(function(){
   		dataTableOptions = {
		          "ajax": { "url": "<?= base_url() ?>index.php/admin/deductions/deductions_sss_data",
		      				"data": function(d){ d.employee_id = $('#searchEmp').val(); },
		      				type:"POST",
		      				beforeSend: function(){
		      					$('#sssTable').css({opacity:"0.5"});
		      				},
		      				complete:function(){
		      					$('#sssTable').css({opacity:"1"})
		      				}
		      			},
		          fnDrawCallback: function(){
		            $('.editable').editable(editableOptions);
          },
        }

     editableOptions = {
          url:"<?= base_url() ?>index.php/admin/deductions/update_sss",
          mode:"inline",
          params: function(d){
          	d.employee_id = dedSelDected;
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
		dedSssDataTable = $('#sssTable').DataTable(dataTableOptions);
	});


	function refresh_deductions_sss(){
		  dedSssDDataTable.ajax.reload();
	}

</script>
	<table class="table table-bordered table-hover" id="sssTable">
		 <thead>
            <tr>
              <th rowspan="3" width="2px"><center>Range of Compensation</center></th>
              <th rowspan="3" width="2px"><center>Monthly Salary Credit</center></th>
              <th colspan="7"><center>Employer-Employee</center></th>
              <th colspan="2"><center>SE/VM/OFW</center></th>
             
            </tr>
            <tr>
              <th colspan="3"><center>Social Security</center></th>
              <th width="100px"><center>EC</center></th>
              <th colspan="3"><center>Total Contribution</center></th>
              <th rowspan="2"><center>Total Contribution</center></th>
              
            </tr>
            <tr>
              <th width="100px"><center>ER</center></th>
              <th width="100px"><center>EE</center></th>
              <th width="100px"><center>Total</center></th>
              <th width="100px"><center>ER</center></th>
              <th width="100px"><center>ER</center></th>
              <th width="100px"><center>EE</center></th>
              <th width="100px"><center>Total</center></th>
            </tr>
          </thead>

		<tbody role="alert" aria-live="polite" aria-relevant="all" id='sssLV'>
	    </tbody>
	</table>
	