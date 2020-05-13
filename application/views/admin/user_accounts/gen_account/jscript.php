<script type="text/javascript">
	var selectedEmp;
	$(function(){

		 var tautocomplete = {
                        columns: ['Name','Department'],
                        norecord: "No Records Found",
                        placeholder:"Type Employee Name",
                        theme: "white",
                        regex: "^[a-zA-Z0-9\b \, \s]+$",
                        onchange: function(){
                        	selectedEmp = autocomp.id();
                        	$('#generateBTN').removeAttr('disabled');
                        },
                        data: function () {
                              var data = <?= $empData ?>;

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
		autocomp = $('#empSelector').tautocomplete(tautocomplete);
	})
	$(document).on('click','#generateBTN',function(){
		var url ="<?= base_url('index.php/admin/user_accounts/generate_keycode') ?>/"+selectedEmp;
		$('#keycode-view').html("<em><small>Generating Keycode. . .</small></em>");
	  $.post(url,"",function(r){
        	$('#generateBTN').attr('disabled','disabled');
	  		$('#keycode-view').html(r);
	  	})
	});
</script>