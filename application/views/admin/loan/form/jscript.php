<script type="text/javascript">
	var autocomp;

	<?php if($this->userInfo->user_privilege != 'admin'): ?>	
		$(document).on('click', '.cancel-request-btn', function(event) {
			$(this).html("<i>Canceling Request. . .</i>");
			$.post('<?= base_url('index.php/employee/loan/cancel_request') ?>',"id="+$(this).attr('loan-id'), function(data, textStatus, xhr) {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
				/*optional stuff to do after success */
			});
		});
	<?php endif ?>

	$(function(){
	  <?php if($this->userInfo->user_privilege == "admin"): ?>	
	  var tautocomplete = {
	                        columns: ['Name','Age','Department','Status'],
	                        norecord: "No Records Found",
	                        placeholder:"Select Employee",
	                        theme: "white",
	                        regex: "^[a-zA-Z0-9\b \, \s]+$",
	                        onchange: function(){
	                          empSelected = autocomp.id();
	                          $('[name=dept]').val(tautocomplete.department());
	                          $('[name=pos]').val("NULL");
	                          $('[name=emp_id]').val(autocomp.id());
	                        },
	                        department: function(){
	                        	return tautocomplete.data()[0].department;
	                        },
	                        data: function () {
		                          var data = <?= $allEmp ?>;
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
		<?php endif; ?>
		
		var form_options = {
			<?php if($this->userInfo->user_privilege == "admin"): ?>
			clearForm: true,
			resetForm: true,
			<?php endif; ?>
			beforeSubmit: function() {
				<?php if($this->userInfo->user_privilege == "employee"): ?>
					$("[name=loan_type]").val("");
					$("[name=amount]").val("");
					$("[name=term]").removeAttr("checked");
					$("[name=deduct]").val("");
					$("[name=date_filed]").val("");
				<?php endif; ?>
				if($('[name=emp_id]').val() !== '') {
					$('#btn_add').attr('disabled', true);
					return true;
				}
				return false;
			},
			success: function() {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
				$('#btn_add').attr('disabled', false);
			}
		};
		$('#form').ajaxForm(form_options);
	})

</script>