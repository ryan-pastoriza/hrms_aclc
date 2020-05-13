<script type="text/javascript">
	var editableOptions;
	var dataTableOptions;
	var dedWtaxDataTable;
	$(function(){
   		dataTableOptions = {
		          "ajax": { "url": "<?= base_url() ?>index.php/admin/deductions/deductions_wtax_data",
		      				"data": function(d){ d.employee_id = $('#searchEmp').val(); },
		      				type:"POST",
		      				beforeSend: function(){
		      					$('#wtaxTable').css({opacity:"0.5"});
		      				},
		      				complete:function(){
		      					$('#wtaxTable').css({opacity:"1"})
		      				}
		      			},
		          fnDrawCallback: function(){
		            $('.editable').editable(editableOptions);
          },
        }

     editableOptions = {
          url:"<?= base_url() ?>index.php/admin/deductions/update_wtax",
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
		dedWtaxDataTable = $('#wtaxTable').DataTable(dataTableOptions);
	});


	function refresh_deductions_wtax(){
		  dedWtaxDataTable.ajax.reload();
	}

</script>
	<table class="table table-bordered table-hover" id="wtaxTable">
		<thead>
			<tr>
			    <th>Status</th>
			    <th>Base</th>
			    <th>Exemption</th>
			    <th>Percent Over</th>
			</tr>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all" id='wtaxLV'>
	    </tbody>
	</table>
	