<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Author: Gian
 * @Date:   2015-06-25 15:38:19
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-20 10:06:35
 */
/**
* 
*/
class Users extends MY_Model
{
	const DB_TABLE = 'users';
	const DB_TABLE_PK = 'user_id';
	public $user_id;
	public $username;
	public $password;
	public $employee_id;
	public $user_privilege;
	
}