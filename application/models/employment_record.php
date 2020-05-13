<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employment_Record extends MY_Model{
		const DB_TABLE = "employment_record";
		const DB_TABLE_PK = "employment_rec_id";
		public $employment_rec_id;
		public $employment_id;
		public $emp_rec_type;
		public $emp_rec_date;
	}

?>