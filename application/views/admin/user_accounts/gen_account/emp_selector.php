<form action="">
<?php 

	$vars = [];
	$widgetVar = [];


	$vars['formInputs'] = [
							'Employee' => [
											'attribs' => [
															'placeholder' => 'Type Employee Name',
															'id' => 'empSelector'
														],
											'col_grid' => col_grid(5)
											]
						];


	$widgetVar['body'] = "Sign-up Keycode: <br> &nbsp;&nbsp;&nbsp;&nbsp; <span class='text-black' id='keycode-view'></span>";
	$widgetVar['bgColor'] = "bg-aqua";
	// $widgetVar['imgIcon'] = base_url("images/users/btn-2012-0213.jpg");
	$widgetVar['imgIcon'] = base_url("images/no-image.fw.png");
	$widgetVar['header'] = "Account Information";

	echo lte_load_view('form_group',$vars);
	echo "<div class='col-sm-12'><button type='button' class='btn btn-primary btn-flat' id='generateBTN' disabled> <i class='fa fa-refresh'></i> Generate</button></div>";
	echo lte_widget(3,$widgetVar);
?>
<input type="hidden" name="employee_id">
</form>