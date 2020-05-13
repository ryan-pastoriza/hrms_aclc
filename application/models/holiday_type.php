<?php
/**
 * @Author: gian
 * @Date:   2015-11-05 15:09:10
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-22 08:26:35
 */
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Holiday_Type extends MY_Model{	
		const DB_TABLE = "holiday_type";
		const DB_TABLE_PK = "h_type_id";
		public $h_type_id;
		public $h_type_name;
		public $h_with_pay;
		public $h_work;
		public $h_non_academic;
	}