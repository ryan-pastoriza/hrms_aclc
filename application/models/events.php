<?php
/**
 * @Author: gian
 * @Date:   2015-11-05 14:46:03
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-24 09:14:30
 */
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Events extends MY_Model{
		const DB_TABLE = "events";
		const DB_TABLE_PK = "event_id";
		

		public $event_id;
		public $title;
		public $start_date;
		public $end_date;
		public $string;
		public $type;
		public $work;
		public $pay;
		public $event_type;
		public $backgroundColor;
		public $repeat;
		public $description;

		public function has_event_on($from,$to){
		$this->db->where("start_date BETWEEN  '{$from}' AND '$to'");
		$event = $this->get();
		return $event;
	}

	}