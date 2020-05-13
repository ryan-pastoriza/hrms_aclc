<script type="text/javascript">
var empData;

	$.post("<?= base_url('index.php/admin/deduction_tables/emp_json') ?>","",function(r){
			    	empData =  r;

			    	var tcomplete = $('#employee-selector').tautocomplete({
											columns: ['Name','Age','Department'],
											theme: 'white',
											data: function () {

													    var filterData = [];

													    var searchData = eval("/" + tcomplete.searchdata() + "/gi");

													    $.each(empData, function 	(i, v) {
													        if (v.fullName.search(new RegExp(searchData)) != -1) {
													            filterData.push(v);
													        }
													    });	
													    return filterData;
												},
											onchange : function(e){
												var empID = tcomplete.id()

												bracketTbl.clear();
												bracketTbl.rows.add([['loading ...','','','']]);
												bracketTbl.draw();

												$.post("<?= base_url('index.php/admin/deduction_tables/calculate_wtax_bracket') ?>","employee_id="+empID,function(r){
													bracketTbl.clear();
													bracketTbl.rows.add(r);
													bracketTbl.draw();

												},'json')
											}
											});
	    },'json');
</script>