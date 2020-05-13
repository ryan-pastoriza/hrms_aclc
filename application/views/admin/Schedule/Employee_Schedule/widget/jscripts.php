<script type="text/javascript">
	var editableOptions;
	var dataTableOptions;
	var empSchedsDataTable;
	
	$(function(){
   		dataTableOptions = {
		          ajax: { "url": "<?= base_url() ?>index.php/admin/employee_schedule/employee_sched_data",
		      				data: function(d){ d.employee_id = empSelected},
		      				type:"POST",
		      				beforeSend: function(){
		      					$('#schedTable').css({opacity:"0.5"});
		      				},
		      				complete:function(r){
		      					$('#schedTable').css({opacity:"1"})
		      				}
		      			},
		          fnDrawCallback: function(){
		            $('.editable').editable(editableOptions);
		          },
        }

     editableOptions = {
          url:"<?= base_url() ?>index.php/admin/employee_schedule/update_schedule",
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
		empSchedsDataTable = $('#schedTable').DataTable(dataTableOptions);
	});


	function refresh_schedule_list(){
		  empSchedsDataTable.ajax.reload();
	}
</script>