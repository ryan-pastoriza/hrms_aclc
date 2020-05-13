<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_orgs extends MY_Model {

	const DB_TABLE = 'emp_app_form_orgs';
	const DB_TABLE_PK = 'eaf_org_id';

	public $eaf_org_id; 
	public $eaf_id; 
	public $eaf_org_name; 
	public $eaf_org_position; 
	public $eaf_org_date_from; 
	public $eaf_org_date_to; 

}

/* End of file emp_app_form_orgs.php */
/* Location: ./application/models/emp_app_form_orgs.php */