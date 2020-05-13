<?php
/**
 * @Author: khrey
 * @Date:   2015-09-24 09:04:34
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-14 10:38:41
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Biometrics extends MY_Controller {

	public function index()
	{
		$this->create_head_and_navi(array(
											asset_url("plugins/datatables/jquery.dataTables.min.js"),
											asset_url("plugins/datatables/dataTables.bootstrap.min.js"),
											asset_url("plugins/iCheck/icheck.min.js")
										 ),
									array(
											asset_url("plugins/datatables/dataTables.bootstrap.css"),
											asset_url("plugins/iCheck/all.css")
										 )
									);

		$bio = $this->load->view('admin/biometrics', FALSE, TRUE);

		create_content(array('contentHeader' => 'Biometrics',
							 'breadCrumbs'	 => true,
							 'content'       => array($bio)
							)
					  );

	}
	public function bio_list()
	{
		$this->load->model('employee');
		$emps = new Employee;
		$emps = $emps->get();
		echo json_encode($this->get_table_data($emps));
	}
	private function get_table_data($bio)
	{
		$toret = array();
		foreach ($bio as $key => $value) {
			$bid = $value->biometric_id != "" ? $value->biometric_id : "Not assigned";
			$bio_id = "<a href='#'' data-type='number' data-title='Assign Biometric ID'  data-pk='". $value->employee_id ."' class='editable editable-click'>{$bid}</a>";
			$toret['data'][] = array($value->fullName(),$bio_id);
		}
		return $toret;
	}
	public function assign_id()
	{
		$this->load->model('employee');
		$emp      = new Employee;
		$assigned = $emp->search(array('biometric_id' => $this->input->post('value')));
		$data = array();

		if ($assigned) {
			$data['success'] = false;
			$data['view'] = "Biometric ID {$this->input->post('value')} has already been assigned to another employee.";
		}else{
			$empNew = new Employee;
			$empNew->load($this->input->post('pk'));
			$empNew->biometric_id = $this->input->post('value');
			$empNew->save();
			$data['success'] = true;
		}
		echo json_encode($data);
	}

}

/* End of file biometrics.php */
/* Location: ./application/controllers/admin/biometrics.php */