<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Training_Seminar extends MY_Model {

	const DB_TABLE = "employee_training_seminar";
	const DB_TABLE_PK = "ets_id";

	public $ets_id;
	public $employee_id;
	public $ets_title;
	public $ets_date;
	public $ets_venue;
	public $ets_provider;

}

/* End of file employee_training_seminar.php */
/* Location: ./application/models/employee_training_seminar.php */
