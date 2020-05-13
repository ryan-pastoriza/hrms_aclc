<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_references extends MY_Model {

	const DB_TABLE = "emp_app_form_references";
	const DB_TABLE_PK = "eaf_ref_id";

	public $eaf_ref_id;
	public $eaf_id;
	public $eaf_ref_name;
	public $eaf_ref_comp_name;
	public $eaf_ref_position;
	public $eaf_ref_contact;
	
}

/* End of file emp_app_form_references.php */
/* Location: ./application/models/emp_app_form_references.php */