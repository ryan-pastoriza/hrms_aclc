<?php
/**
 * @Author: gian
 * @Date:   2016-05-20 14:35:27
 * @Last Modified by:   gian
 * @Last Modified time: 2016-05-25 14:24:10
 */


defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Event extends MY_Model{
	
	const DB_TABLE = "event";
	const DB_TABLE_PK = "event_id";

	public $event_id;
	public $title;
	public $from_date;
	public $to_date;
	public $description;
	public $type_name;
	public $work;
	public $pay;
	public $event_type;
	public $backgroundColor;
	public $repeat;


	public function has_event_on($date=FALSE){
		$date = date("Y-m-d",strtotime($date));
		$this->db->where("event.from_date= '{$date}' OR event.to_date = '{$date}' ");
		$event = $this->get();
		return $event;
	}
	
}