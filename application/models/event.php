<?php
/**
 * @Author: gian
 * @Date:   2016-05-20 14:35:27
 * @Last Modified by:   gian
 * @Last Modified time: 2016-06-06 14:40:09
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
	public $from_date;
	public $description;
	public $type;
	public $work;
	public $pay;
	public $event_type;
	public $backgroundColor;
	public $repeat;


	public function has_event_on($from,$to){

		// $to = date('Y-m-d', strtotime($to." + 1 day"));
		// echo $from."<br>";
		// echo $to."<br>";
		$from = $from." 00:01:00";
		$to = $to." 23:59:00";

		$this->db->where(" '{$from}' BETWEEN start_date AND end_date OR '{$to}' BETWEEN start_date AND end_date ");
		$event = $this->get();
		return $event;
	}
	
}