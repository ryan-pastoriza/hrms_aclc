<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_relatives extends MY_Model {

	const DB_TABLE = "emp_app_form_relatives";
	const DB_TABLE_PK = "eaf_relative_id";

	public $eaf_relative_id;
	public $eaf_id;
	public $eaf_relative_name;
	public $eaf_relative_relationship;
	public $eaf_relative_position;

}

/* End of file emp_app_form_relatives.php */
/* Location: ./application/models/emp_app_form_relatives.php */