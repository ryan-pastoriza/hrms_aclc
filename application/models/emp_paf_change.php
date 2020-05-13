<?php

/**
 * @Author: IanJayBronola
 * @Date:   2018-10-12 08:54:26
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-12 08:56:23
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_paf_change extends MY_Model {

	const DB_TABLE = 'emp_paf_changes';
	const DB_TABLE_PK = 'epafc_id';

	public $emp_paf_id;
	public $epafc_id;
	public $epafc_field;
	public $epafc_former_value;
	public $epafc_new_value;

}

/* End of file emp_paf_change.php */
/* Location: ./application/models/emp_paf_change.php */