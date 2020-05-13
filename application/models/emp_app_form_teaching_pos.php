<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_teaching_pos extends MY_Model {

	const DB_TABLE="emp_app_form_teaching_pos";
	const DB_TABLE_PK="eaf_tp_id";
	
	public $eaf_tp_id;
	public $eaf_id;
	public $eaf_tp_date_from;
	public $eaf_tp_date_to;
	public $eaf_tp_school;
	public $eaf_tp_subject;
	public $eaf_tp_superior_cont;
	public $eaf_tp_salary;
	public $eaf_tp_rfl;

}

/* End of file emp_app_form_teaching_pos.php */
/* Location: ./application/models/emp_app_form_teaching_pos.php */