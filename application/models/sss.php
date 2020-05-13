<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sss extends MY_Model {

	const DB_TABLE = "sss";
	const DB_TABLE_PK = "sss_id";

	public $sss_id;
	public $sss_range_from;
	public $sss_range_to;
	public $sss_monthly_credit;
	public $sss_er_cont;
	public $sss_ee_cont;
	public $sss_ec;

}

/* End of file sss.php */
/* Location: ./application/models/sss.php */