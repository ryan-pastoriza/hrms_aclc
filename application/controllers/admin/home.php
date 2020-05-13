<?php
/**
 * @Author: khrey
 * @Date:   2015-08-14 16:56:03
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-22 09:25:44
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$this->load->model('employee'); 
		

		$emps         = new Employee;
		$allEmps      = $emps->get_all('active');
		$empsInDepts  = $this->emps_department_json($allEmps);
		$month 		  = date('m');
		$emps->sqlQueries['toJoin'] = array('employment' 	=> 'employee' , 
											'department' 	=> 'employment',
											'employee_est_classifications' => 'employee');

		$emps->sqlQueries['order_field'] = "DAY(employee_bday)";
		$emps->sqlQueries['order_type']  = "asc";
		$empBirthdays = $emps->search("MONTH(employee_bday) = '{$month}' AND employment_status = 'ACTIVE'");
		$colours = [];
		foreach (json_decode($empsInDepts) as $key => $value) {
		    $colours[] = '#'.random_color();
		  }

		$data = array('empsInDepts' 	=> $empsInDepts,
					  'allEmps' 		=> $allEmps,
					  'colours' 		=> $colours,
					  'birthdays' 		=> $empBirthdays,
					  'announcements' 	=> $this->get_announcements());

		// $headerData = array('title' => "Human Resource Management System",
		// 					'sub_title' =>"Quick Preview");

		$this->create_head_and_navi(array(asset_url('plugins/momentjs/moment.js'),));

		create_content(array("contentHeader" => "HRMS Dashboard",
							'breadCrumbs' => true,
							'content' => array( $this->load->view('admin/home',$data, true))));

		$this->create_footer([$this->load->view('admin/home/jscripts', array(), TRUE)]);
	}
	private function get_announcements()
	{
		$this->load->model('announcement');

		$announcement = new Announcement;
		$announcement->sqlQueries['order_field'] = 'announcement_start';
		$announcement->sqlQueries['order_type']  = 'desc';
		$announcements = $announcement->get();

		$theAnns = [];

		foreach ($announcements as $key => $value) {
			$theAnns[date('F Y',strtotime($value->announcement_start))][] = $value;
		}

		return $theAnns;
	}
	private function emps_department_json($emps)
	{
		$empsInDepts = array();
		$toret = array();
		   foreach ($emps as $key => $value) {
		   	if (isset($empsInDepts[$value->department_name])) {
			   	$empsInDepts[$value->department_name] += 1;
		   	}
		   	else{
			   	$empsInDepts[$value->department_name] = 1;
		   	}
		   }

		   foreach ($empsInDepts as $key => $value) {
		   	$toret[] = array('label' => $key,
		   					'value' => $value);
		   }
		   return json_encode($toret);
	}
	public function post_announcement()
	{
		$this->load->model('announcement');

		$announcement = new Announcement;

		$announcement->announcement_title 	= $this->input->post('announcement_title');
		$announcement->announcement_body 	= $this->input->post('announcement_body');
		$announcement->announcement_start 	= $this->input->post('announcement_start');
		$announcement->announcement_end 	= $this->input->post('announcement_end');
		$announcement->save();
	}
	public function edit_announcement()
	{
		$this->load->model('announcement');
		$ann = new Announcement;
		$ann->load($this->input->post('pk'));
		$ann->{$this->input->post('name')} = $this->input->post('value');
		$ann->save();
	}
	public function announcements_list()
	{
		
		$data = ['announcements' => $this->get_announcements() ];

		$this->load->view('admin/dashboard/announcements_list', $data, FALSE);
	}
	public function remove_announcement()
	{
		$this->load->model('announcement');

		$ann = new Announcement;
		$ann->load($this->input->post('id'));
		$ann->delete();
	}

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */