<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Philhealth extends MY_Model {

	const DB_TABLE = 'philhealth';
	const DB_TABLE_PK = 'phic_id';

	public $phic_id;
	public $phic_salary_range_from;
	public $phic_salary_range_to;
	public $phic_monthly_premium;
	public $phic_er_share;
	public $phic_ee_share;

}

/* End of file philhealth.php */
/* Location: ./application/models/philhealth.php */