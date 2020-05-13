<?php
/**
 * @Author: khrey
 * @Date:   2015-08-14 09:23:37
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-26 09:31:30
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends MY_Controller {

	public function index()
	{
		$this->load->model('employee');
		$this->load->model('department');

		$emps = new Employee;
		$depts = new Department;

		$data = array('emps' => $emps->get_all(),
					  'departments' => $depts->search(array('department_status' => "active")));

		$mainPage = $this->load->view('admin/PIS/employees/main_page',$data,TRUE);
		
		$this->create_head_and_navi(array(
											asset_url("plugins/datatables/jquery.dataTables.min.js"),
											asset_url("plugins/iCheck/icheck.min.js")
										 ),
									array(
											asset_url("plugins/datatables/jquery.dataTables.min.css"),
											asset_url("plugins/iCheck/all.css")
										 )
									);
		
		create_content(array('contentHeader' => 'Employees\' Record',
							 'breadCrumbs' 	 => true,
							 'content'		 => array($mainPage)	
					  		)
					   );

		$this->create_footer(array(
								$this->load->view('admin/PIS/new/jscripts',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/employees_table/jscripts',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/201/emp_app_form/jscript',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/201/staff_info_sheet/jscripts',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/201/employment_checklist/jscripts',FALSE,TRUE)
							));


	}
	public function view_info()
	{
		$emps = new Employee;
		$emps->toJoin = array('employment' => 'employee' , 
						'department' => 'employment');
		$emps->load($this->input->post('emp_id'));
		echo json_encode($emps);
	}
	public function employees_list()
	{
		$this->load->model('employee');
		$emps = new Employee;
		$emps = $emps->get_all();

		$tableData = $this->get_table_data($emps);

		echo json_encode($tableData);
	}
	private function get_table_data($employees)
	{
		$tableData = array();
		foreach ($employees as $key => $value) {
			$fullname = $value->fullName('l f, m.');
			$status = $value->employment_status == "active" ? "<span class=\"label label-success\">ACTIVE</span>" : "<span class=\"label label-danger\">INACTIVE</span>";
			$tableData['data'][] = array($fullname,
										 $value->employment_job_title,
										 $value->department_name,
										 $status,
										 "<a href=\"#\" data-toggle=\"tooltip\" title=\"View Information\" class=\"openEmpFileBtn\" emp_id=\"$value->employee_id\"><i class=\"fa fa-folder-open-o\" ></i></a>");
		}
		return $tableData;
	}
	
}


/* End of file employees.php */
/* Location: ./application/controllers/admin/employees.php */