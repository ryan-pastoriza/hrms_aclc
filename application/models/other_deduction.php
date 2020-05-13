<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Other_Deduction extends MY_Model {
		
		const DB_TABLE = "other_deductions";
		const DB_TABLE_PK = "other_ded_id";

		public $other_ded_id;
		public $other_ded_name;
		public $other_ded_description;
		public $other_ded_start_date;
		public $other_ded_term;
		public $other_ded_duration_months;
	}
?>