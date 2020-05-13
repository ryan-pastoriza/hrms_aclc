<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employment_Requirement_Checklist extends MY_Model{
		
		const DB_TABLE = "employment_requirement_checklists";
		const DB_TABLE_PK = "erc_id";

		public $erc_id;
		public $employee_id;
		public $er_id;
		public $status;
		
	}