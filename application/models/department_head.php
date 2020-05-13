<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_head extends MY_Model {

	const DB_TABLE = "department_heads";
	const DB_TABLE_PK = "dept_head_id";

	public $dept_head_id;
	public $department_id;
	public $employee_id;
	
}

/* End of file department_head.php */
/* Location: ./application/models/department_head.php */