<?php
/**
 * @Author: gian
 * @Date:   2016-05-03 08:33:04
 * @Last Modified by:   gian
 * @Last Modified time: 2016-05-04 17:21:13
 */

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Employee_Requirement extends MY_Model{
	const DB_TABLE = "employee_requirements";
	const DB_TABLE_PK = "er_id";
	
	public $er_id;
	public $requirement_name;

}