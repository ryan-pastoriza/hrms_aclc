<?php
/**
 * @Author: gian
 * @Date:   2016-05-20 14:35:27
 * @Last Modified by:   Gian Carl Anduyan
 * @Last Modified time: 2020-08-24 11:26:29
 */


defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Event extends MY_Model{
	
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
		$from =  date('Y-m-d', strtotime(str_replace('-','/', $from)));

		$date1 = str_replace('-', '/', $to);
		$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

		$this->db->where("start_date BETWEEN '{$from}' AND '{$tomorrow}'");
		$event = $this->get();
		return $event;
	}
	
}