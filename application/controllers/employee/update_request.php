<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_request extends MY_Controller {

	public function index()
	{
		
	}

	public function add_request(){
		$this->load->model('employee_update_request');
		$emp_ur = new Employee_Update_Request;

		$emp_ur->eur_request_content = $this->input->post('eur_request_content');	
		$emp_ur->eur_request_file = $this->input->post('eur_request_file');	
		$emp_ur->eur_status = "pending";	
		$emp_ur->save();

		if($emp_ur->db->affected_rows() > 0){
			echo json_encode(array("result" => true, "file" => $this->input->post('eur_request_file')));
		}


	}

}

/* End of file update_request.php */
/* Location: ./application/controllers/employee/update_request.php */