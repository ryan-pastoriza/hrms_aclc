	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Emp_app_form_trainings extends MY_Model {
		
		const DB_TABLE = 'emp_app_form_trainings';
		const DB_TABLE_PK = 'eaf_tas_id';

		public $eaf_tas_id ;
		public $eaf_id ;
		public $eaf_tas_title ;
		public $eaf_tas_name_loc ;
		public $eaf_tas_date_from ;
		public $eaf_tas_date_to ; 
	}
	
	/* End of file emp_app_form_trainings.php */
	/* Location: ./application/models/emp_app_form_trainings.php */