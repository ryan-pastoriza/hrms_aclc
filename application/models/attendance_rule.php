<?php
/**
 * @Author: khrey
 * @Date:   2015-10-22 11:00:30
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-22 11:54:30
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_rule extends MY_Model {
	const DB_TABLE = "attendance_rules";
	const DB_TABLE_PK = "rule_id";

	public $rule_id;
	public $late_hr_max;
	public $late_min_max;
	public $ut_hr_max;
	public $ut_min_max;

}

/* End of file attendance_rule.php */
/* Location: ./application/models/attendance_rule.php */