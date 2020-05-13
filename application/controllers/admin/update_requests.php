<?php

/**
 * @Author: IanJayBronola
 * @Date:   2018-10-10 13:26:59
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-10 14:08:17
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_requests extends MY_Controller {

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

		$main = $this->load->view('admin/update_requests/main', FALSE, TRUE);

		create_content(array('contentHeader' => 'Employees Update Requests',
							 'breadCrumbs'	 => true,
							 'content'       => array($main)
							)
					  );
	}
	public function eur_list()
	{
		$this->load->model('employee_update_request');
		$eur = new Employee_Update_Request;
		$eurs = $eur->get();

		$data = [];
		foreach ($eurs as $value) {
			$status = "<i class='text-muted fa fa-hourglass-start' ></i>";
			$button = "<div class='btn-group'>
							<button class='btn btn-success btn-xs' onclick='approve_request({$value->eur_id})'><i class='fa fa-check'></i></button>
							<button class='btn btn-danger btn-xs dropdown-toggle' data-toggle='dropdown' ><i class='fa fa-close'></i></button>
							<ul class='dropdown-menu pull-right' role='menu'>
								<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
								<li class='text-center'><a href='#' onclick='disapprove_request({$value->eur_id}); return false;'>Yes</a></li>
								<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
							</ul>
					 	</div>";

			if($value->eur_status == 1){
				$status = "<i class='text-success fa fa-check'></i>";
				$button = "";
			}
			elseif($value->eur_status == 2){
				$status = "<i class='text-danger fa fa-info'></i>";
			}
			$data['data'][] = [$value->belongs_to('employee')->fullName(),
								date('M d, Y', strtotime($value->eur_date_filed)),
								$value->eur_request_content,
								$status,
								$button
								];
		}
		echo json_encode($data);

	}
	public function approve()
	{
		$this->load->model('employee_update_request');
		$eur = new Employee_Update_Request;
		$eur->load($this->input->post('eur_id'));
		$eur->eur_status = 1;
		$eur->eur_response = $this->input->post('eur_response');
		$eur->save();
	}

}

/* End of file update_requests.php */
/* Location: ./application/controllers/admin/update_requests.php */