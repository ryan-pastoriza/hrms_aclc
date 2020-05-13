<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_children extends MY_Model {

	const DB_TABLE = "emp_app_form_children";
	const DB_TABLE_PK = "eaf_child_id";

	public $eaf_child_id;
	public $eaf_id;
	public $eaf_child_name;
	public $eaf_child_dob;

}

/* End of file emp_app_form_spouse.php */
/* Location: ./application/models/emp_app_form_children.php */