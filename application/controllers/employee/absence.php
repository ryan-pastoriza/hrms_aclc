<?php
/**
 * @Author: gian
 * @Date:   2016-07-14 15:21:11
 * @Last Modified by:   gian
 * @Last Modified time: 2016-07-14 15:58:19
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Absence extends MY_Controller{
	
	public function index(){
		$this->create_head_and_navi(
									[
										asset_url('plugins/datatables/jquery.dataTables.min.js'),
										asset_url('plugins/datatables/dataTables.bootstrap.js'),
										asset_url('plugins/datatables/version1/datatableTools.min.js'),
										asset_url('plugins/datatables/version1/dataTables.buttons.min.js'),

									],
									[
										asset_url('plugins/datatables/version1/buttons.dataTables.min.css'),
										asset_url('plugins/datatables/version1/dataTables.bootstrap.css'),

									]

								   );
		create_content(
						[
							"contentHeader" => "Absences",
							"breadCrumbs"	=> true,
							"content"		=> $this->load->view("employee/attendance/absence/main",FALSE,TRUE),
						]
					  );

		$this->create_footer();
	}
}