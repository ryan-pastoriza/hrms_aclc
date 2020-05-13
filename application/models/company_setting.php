<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_setting extends MY_Model {

	const DB_TABLE = 'company_settings';
	const DB_TABLE_PK = "comp_setting_id";

	public $comp_setting_id;
	public $comp_setting_name;
	public $comp_setting_val;

}

/* End of file company_setting.php */
/* Location: ./application/models/company_setting.php */