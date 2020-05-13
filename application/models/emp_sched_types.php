<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/

	/**
	* 
	*/
	class Emp_Sched_Types extends MY_Model{		
		const DB_TABLE = "emp_sched_types";
		const DB_TABLE_PK = "est_id";
		public $est_id;
		public $est_name;
	}

?>