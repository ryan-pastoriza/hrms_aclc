<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/

	/**
	* 
	*/
	class Employee_Est_Classifications extends MY_Model{		
		const DB_TABLE = "employee_est_classifications";
		const DB_TABLE_PK = "eec_id";
		public $eec_id;
		public $est_id;
		public $employee_id;
	}

?>