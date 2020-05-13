<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends MY_Model {

	const DB_TABLE = 'announcements';
	const DB_TABLE_PK = 'announcement_id';

	public $announcement_id;
	public $announcement_title;
	public $announcement_body;
	public $announcement_start;
	public $announcement_end;

}

/* End of file announcement.php */
/* Location: ./application/models/announcement.php */