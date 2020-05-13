<?php
/**
 * @Author: gian
 * @Date:   2016-08-01 11:00:31
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 09:25:57
 */

/**
* 
*/
class Deduction_Tables extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index(){
		$this->load->model("employee");
		$emp = new Employee;
		$data = array();

		$emp->toJoin = [
							"employment"  => "employee",
					   ];
		$searchEmp = $emp->search(
							[
								"employees.employee_id" => $this->userInfo->employee_id
							]
						  );

		$foundEmp = reset($searchEmp);
		
		$this->employment_rate = $foundEmp->employment_rate;
		$emp->employee_id = $this->userInfo->employee_id;

		$data = [
					"sss" =>  $emp->sss_share(),
					"philhealth" => $emp->philhealth_share(),
					"pagibig"	=> $emp->pagibig_share(),
				];

		$this->create_head_and_navi();

		
		create_content(
						[
							"contentHeader" => "Deduction Backets",
							"breadCrumbs"	=> true,
					   		"content"	=>  [
					   							$this->load->view("employee/deduction_bracket/sss_contri",$data,TRUE),
					   							$this->load->view("employee/deduction_bracket/philhealth_contri", $data, TRUE),
					   							$this->load->view("employee/deduction_bracket/pagibig_contri", $data, TRUE),
					   							$this->load->view("admin/deduction_tables/wtax/search_bracket",[],TRUE)

					   					    ],
					  	]
					  );

		$this->create_footer();
	}


	public function calculate_wtax_bracket()
	{
		$this->load->model('employee');

		$emp = new Employee;
		$data = array("data" =>[]);
		$emp->toJoin = ['employment' => 'employee'];

		if ($this->userInfo->employee_id) {
			$emp->load_with_employment_record($this->userInfo->employee_id);

			if ($emp->employee_fname != "") {
				$empRate = $emp->employment_rate;

				$dailyRate 		= isset($emp->daily_rate) ? $emp->daily_rate : "<i class='text-red'>Rate not set.</i>"; 
				$weeklyate 		= isset($emp->weekly_rate) ? $emp->weekly_rate : "<i class='text-red'>Rate not set.</i>"; 
				$semi_monthly 	= isset($emp->semi_monthly_rate) ? $emp->semi_monthly_rate : "<i class='text-red'>Rate not set.</i>"; 
				$monthlyRate 	= isset($emp->monthly_rate) ? $emp->monthly_rate : "<i class='text-red'>Rate not set.</i>"; 

				$dailyBracket 		= $emp->tax_bracket('daily');
				$weeklyBracket 		= $emp->tax_bracket('weekly');
				$semiMonthlyBracket = $emp->tax_bracket('semi-monthly');
				$monthlyBracket 	= $emp->tax_bracket('monthly');


				$data["data"] = array(
								['Daily', 	$dailyBracket->wtax_bracket_status, number_format($dailyBracket->wtax_bracket_base,2 ), $dailyBracket->wtax_bracket_percent_over."%" ],
								['Weekly', 			$weeklyBracket->wtax_bracket_status, 		number_format($weeklyBracket->wtax_bracket_base,2) ,		 $weeklyBracket->wtax_bracket_percent_over."%" ],
								['Semi-monthly', 	$semiMonthlyBracket->wtax_bracket_status, 	number_format($semiMonthlyBracket->wtax_bracket_base,2) , $semiMonthlyBracket->wtax_bracket_percent_over."%" ],
								['Monthly', 		$monthlyBracket->wtax_bracket_status, 		number_format($monthlyBracket->wtax_bracket_base,2) ,	 $monthlyBracket->wtax_bracket_percent_over."%" ],

							);
			}
			else{
					$data["data"] = array(
						['Daily','0.00','0.00','0.00'],
						['Weekly','0.00','0.00','0.00'],
						['Semi-Monthly','0.00','0.00','0.00'],
						['Monthly','0.00','0.00','0.00'],
					);
			}
		}
		else{
			$data["data"]  = array(
					['Daily','0.00','0.00','0.00'],
					['Weekly','0.00','0.00','0.00'],
					['Semi-Monthly','0.00','0.00','0.00'],
					['Monthly','0.00','0.00','0.00'],
				);
		}

		echo json_encode($data);
	}



}
