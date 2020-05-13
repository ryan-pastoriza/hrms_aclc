<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	/**
	* 
	*/
	class Departments extends MY_Controller{
		public function index(){

			$this->load->model('department');
			$department = new Department;
			$data['empData'] = $this->dept_head();
			$data['allDepartments'] = $department->search(array('department_status' => 'active'));

			$this->create_head_and_navi(array(
												asset_url("plugins/datatables/jquery.dataTables.min.js"),
												asset_url("plugins/datatables/dataTables.bootstrap.min.js"),
												asset_url("plugins/iCheck/icheck.min.js"),
												asset_url("plugins/toast/toastr.min.js")
											 ),
										array(
												asset_url("plugins/datatables/dataTables.bootstrap.css"),
												asset_url("plugins/toast/toastr.css"),
												asset_url("plugins/iCheck/all.css")
											 )
									);

			$dept = $this->load->view('admin/Department/new/new_department',$data,TRUE);
			// $listDept = $this->load->view('admin/Department/department_list/department_listview',FALSE,TRUE);
			create_content(array('contentHeader' => 'Department',
								 'breadCrumbs'   => true,
								 'content'		 => array($dept)
								)
						   );
		}
		public function dept_head(){
			$this->load->model('employee','emps');

			$allEmps = $this->emps->get();
			$json = array();
			$count = 0;
			foreach ($allEmps as $key => $value) {
				$count++;
				$dataArray = array(	"empId" => $value->employee_id,
									"fullName" => $value->fullName('l, f m.'),
									"number" => $count );
				$json[] = $dataArray;
			}

			return json_encode($json);
		}
		public function add_department(){
			$toret = array();
			$this->load->model('department');
			$department = new Department;
			$data = array();

			$department->department_name = $this->input->post('department_name');
			if($this->input->post('empId') != ""){
				$department->emp_id = $this->input->post('empId');

				$checkDepartment = $department->search(array('department_name' => $department->department_name));
				$checkDeptHead = $department->search([
														'emp_id' => $department->emp_id
													]);
				if(count($checkDepartment) > 0){
					$depFound = reset($checkDepartment);
					$departmentName = $department->search(array('department_name' => $depFound->department_name));
					$depName = reset($departmentName);
					if(strtolower($depName->department_name) == strtolower($department->department_name)){
						$toret['Msg'] = "Add department failed, <br>Data Redundancy Detected.";
						$toret['success'] = false;
					}
					if($depName->emp_id == $department->emp_id && (strtolower($depName->department_name) == strtolower($department->department_name))){
						$toret['Msg'] = "Add Department and Department Head failed,<br />Data Redundancy Detected.";
						$toret['success'] = false;
					}
				}else if(count($checkDeptHead) > 0){
					$foundH = reset($checkDeptHead);

					if($foundH->emp_id == $department->emp_id){
						$toret['Msg'] = "Add department head failed, <br>Data Redundancy Detected.";
						$toret['success'] = false;
					}

				}
			}else{
				$department->department_status = "active";
				$department->est_id = 1;
				$department->save();
				$toret['Msg'] = "Successfuly Added";
				$toret['success'] = true;
			}
			echo json_encode($toret);	
		}
		public function delete_department(){
			$toret = array();
			$this->load->model('department');
			$this->load->model('employment');
			$employment = new Employment;
			$inUnse = $employment->search(array('department_id' => $this->input->post('department_id')));
			if (count($inUnse) > 0 ) {

				$toret['Msg'] = "Department in use cannot be deleted!";
				$toret['success'] = false;
			}
			else{
				$department = new Department;
				$department->load($this->input->post('department_id'));
				$department->delete();

				$toret['success'] = true;
				$toret['Msg'] = "Deleted Successfuly";
			}
			echo json_encode($toret);
		}
		public function update_dept_head(){
			$toret['Msg'] 		= "Updated Successfuly";
			$toret['view'] 		= $this->load->view('shared/success',[],TRUE);
			$toret['success'] 	= true;
			$this->load->model('department');
			$department = new Department;
			$department->load($this->input->post('pk'));
			$dept_head = $department->head();
			$none = false;

			if ($dept_head->dept_head_id == "") {
				$this->load->model('department_head');
				$dept_head = new Department_head;

				$dept_head->department_id = $this->input->post('pk');
			}
			else{
				$this->load->model('department_head');


				$dh = new Department_head;
				$dh->load($dept_head->dept_head_id);
				if ($this->input->post('value') == "") {
					$dh->delete();
					$none = true;
				}
				else{
					$dept_head = $dh;
				}
			}

			if (!$none) {
				$dept_head->employee_id = $this->input->post('value');
				$dept_head->save();
			}

			// $data = array();
			// $deptHead = $department->search(array('emp_id' => $this->input->post('value')));

			// if(count($deptHead) > 0 ){
			// 	$depFound = reset($deptHead);
			// 	$deptHead = $department->search(array('emp_id' => $depFound->emp_id));
			// 	$deptHead = reset($deptHead);
			// 	if(strtolower($deptHead->emp_id) == strtolower($depFound->emp_id)){
			// 		$toret['Msg'] = "<h6>
			// 								<i class='fa fa-ban'></i>
			// 								Update failed
			// 							 </h6>
			// 								Data Redundancy Detected
			// 							";
			// 		// $toret['view'] = $this->load->view('shared/error',$data,TRUE);
			// 		$toret['success'] = false;
			// 	}
			// }else{

			// 	$department->load($this->input->post('pk'));
			// 	$department->emp_id = $this->input->post('value');
			// 	$department->save();
				
			// }
			echo json_encode($toret);
		}
		public function update_department(){
			$toret = array();

			$this->load->model('department');
			$department = new Department;
			$data = array();
			$checkDepartment = $department->search(array('department_name' => $this->input->post('value')));
			if(count($checkDepartment) > 0 ){
				$depFound = reset($checkDepartment);
				$departmentName = $department->search(array('department_name' => $depFound->department_name));
				$depName = reset($departmentName);
				if(strtolower($depName->department_name) == strtolower($department->department_name));
					$toret['Msg'] = "<h6>
											<i class='fa fa-ban'></i>
											Update failed
										 </h6>
											<br />
											Data Redundancy Detected
										";
					$toret['view'] = $this->load->view('shared/error',$data,TRUE);
					$toret['success'] = false;
			}else{

				$department->load($this->input->post('pk'));
				$department->department_name = $this->input->post('value');
				$department->save();
				$toret['Msg'] = "Updated Successfuly";
				$toret['view'] = $this->load->view('shared/success',$data,TRUE);
				$toret['success'] = true;

			}
			echo json_encode($toret);
		}
		public function view_department(){
			$this->load->model('department');
			$department = new Department;

			$getDepartments = $department->search(array('department_status' => 'active'));
			$data = array('allDepartments' => $getDepartments);
			$this->load->view('admin/Department/department_list/department_view',$data);
		}
		public function departments_list()
		{
			$this->load->model('department');
			$department = new Department;
			$getDepartments = $department->search(array('department_status' => 'active'));
			$tableData = $this->translate_to_table_data($getDepartments);
			echo json_encode($tableData);
		}
		public function all_emp(){
			$this->load->model('employee');
			$emp = new Employee;
			$emp->sqlQueries['order_field'] = "employee_lname";
			$emp->sqlQueries['order_type'] = "asc";
			$emp = $emp->get();
			$emp_ids = [];
			$emp_ids[] = ["value" => "",
						"text" => "[NONE]"];
			foreach ($emp as $key => $value) {
				$emp_ids[] = [
								"value" => $value->employee_id,
							  "text" => $value->fullName()
							 ];
			}
			echo json_encode($emp_ids);
		}
		private function translate_to_table_data($departments)
		{
			$this->load->model('employee');
			$emp = new Employee;
			$emp = $emp->get();
			$tableData = array('data' => []);

			$emp_ids = [];
			foreach ($emp as $key => $value) {
				$emp_ids[] = ["id" =>$value->employee_id,
							  "fullName" => $value->fullName()
							 ];
			}
			foreach ($departments as $key => $value) {
				// echo "<pre>";
				// print_r($value->head());
				// foreach ($emp_ids as $key2 => $value2) {
					// if($value2["id"] === $value->emp_id){
		        $tableData['data'][] = array("<a href='#'' data-type='text' data-title='Enter Department Name'  data-pk='". $value->department_id ."' class='editable deptName editable-click'> ". $value->department_name ." </a>",
					                          "<a href='#' data-type='select' data-title='Enter Department Head' data-pk='".$value->department_id."' class='editable deptHead editable-click'>".$value->head()->fullName()."</a>",
					                          "<div class='btn-group'>
					                              <button type='button' class='btn btn-xs btn-flat btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
					                                <span class='glyphicon glyphicon-trash'></span>
					                              </button>
					                              <ul class='dropdown-menu'>
					                                <li><span class='label alert-warning'>Are you sure?</span></li>
					                                <li><a href='#' class='deleteDepartment' department_id=' ". $value->department_id ."'>Yes</a></li>
					                                <li><a href='#' id='no'>No</a></li>
					                              </ul>
					                            </div>
					                        ");
					// }
				// }
				// if($value->emp_id === "" or $value->emp_id === NULL){
				// 	$tableData['data'][] = array("<a href='#'' data-type='text' data-title='Enter Department Name'  data-pk='". $value->department_id ."' class='editable deptName editable-click'> ". $value->department_name ." </a>",
				// 			                          "<a href='#' data-type='select' data-title='Enter Department Head' data-pk='".$value->department_id."' class='editable deptHead ediable-click'></a>",
				// 			                          "<div class='btn-group'>
				// 			                              <button type='button' class='btn btn-xs btn-flat btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
				// 			                                <span class='glyphicon glyphicon-trash'></span>
				// 			                              </button>
				// 			                              <ul class='dropdown-menu'>
				// 			                                <li><span class='label alert-warning'>Are you sure?</span></li>
				// 			                                <li><a href='#' class='deleteDepartment' department_id=' ". $value->department_id ."'>Yes</a></li>
				// 			                                <li><a href='#' id='no'>No</a></li>
				// 			                              </ul>
				// 			                            </div>
				// 			                        ");
				// }


			}
			return $tableData;
		}
	}
?>