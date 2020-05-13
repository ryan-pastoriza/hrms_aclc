<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wtax extends MY_Model {

	const DB_TABLE = "wtax";
	const DB_TABLE_PK = 'wtax_bracket_id';

	public $wtax_bracket_id;
	public $wtax_bracket_term;
	public $wtax_bracket_status;
	public $wtax_bracket_base;
	public $wtax_amount;
	public $wtax_bracket_percent_over;

}

/* End of file wtax.php */
/* Location: ./application/models/wtax.php */