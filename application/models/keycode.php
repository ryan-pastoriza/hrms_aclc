<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keycode extends MY_Model {

	const DB_TABLE = 'keycodes';
	const DB_TABLE_PK = 'keycode_id';

	public $keycode_id;
	public $employee_id;
	public $keycode;

}

/* End of file keycode.php */
/* Location: ./application/models/keycode.php */