<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_emprec_at_comp extends MY_Model {

	const DB_TABLE = "emp_app_form_emprec_at_comp";
	const DB_TABLE_PK = "eaf_erc_id";

	public $eaf_erc_id;
	public $eaf_id ;
	public $eaf_erc_date_from;
	public $eaf_erc_date_to;
	public $eaf_prev_position;
	public $eaf_erc_superior_cont;
	public $eaf_erc_salary;
	public $eaf_erc_rfl;

}

/* End of file emp_app_form_emprec_at_comp.php */
/* Location: ./application/models/emp_app_form_emprec_at_comp.php */