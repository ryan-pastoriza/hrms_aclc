<?php
/**
 * @Author: Dale
 * @Date:   2016-07-15 08:20:58
 * @Last Modified by:   Dale
 * @Last Modified time:
 */
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employee_Update_Request extends MY_Model{
		const DB_TABLE = "employee_update_request";
		const DB_TABLE_PK = "eur_id";
		
		public $eur_id;
		public $employee_id;
		public $eur_request_content;
		public $eur_status;

	}