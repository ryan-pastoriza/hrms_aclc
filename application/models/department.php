<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Department extends MY_Model{
		
		const DB_TABLE = "departments";
		const DB_TABLE_PK = "department_id";
		public $department_id;
		public $department_name;
		public $department_status;
		public $est_id;

		public function head()
		{
			$this->load->model('department_head');

			$dh = new Department_head;
			$dh->toJoin = ['employee' => 'department_head'];
			$ret =  $dh->pop(['department_id' => $this->department_id]);

			return $ret;
		}
		public function calendar_sched($date = false)
		{
			$regSched 		= $this->reg_sched($date,$date,$date);
			$irreg_sched 	= $this->irreg_sched($date,$date,$date);

			$allSched 		= array_merge($regSched,$irreg_sched);
			
			return $allSched;
		}
		public function reg_sched($from = false, $to = false, $dow = false)
		{
			$this->load->model('depts_def_sched_nfds');

			$dds 			= new Depts_Def_Sched_Nfds;
			$dds->toJoin 	= ['non_flexi_daily_scheds' => 'depts_def_sched_nfds'];

			if ($dow) {
				$theDow = date('D', strtotime($dow));

				$allsched 		= $dds->search("department_id = {$this->department_id} AND start <= '{$from}' AND ( end >= '{$to}' OR end is NULL ) AND non_flexi_daily_scheds.nfds_day = '{$theDow}' ");
			}
			elseif ($from && $to) {
				$allsched 		= $dds->search("department_id = {$this->department_id} AND start <= '{$from}' AND ( end >= '{$to}' OR end is NULL )");
			}
			elseif ($from) {
				$allsched 		= $dds->search("department_id = {$this->department_id} AND start <= '{$from}' AND (end is NULL OR end >= '{$from}' ) ");
			}else{
				$allsched 		= $dds->search(['department_id' => $this->department_id]);
			}


			return $allsched;
		}
		public function irreg_sched($from = false, $to = false)
		{
			$this->load->model('department_irregular_sched');

			$dis = new Department_irregular_sched;

			if ($from && $to) {
				$allSched = $dis->search("department_id = {$this->department_id} AND DATE(sched_from_date) BETWEEN '{$from}' AND '{$to}' AND DATE(sched_to_date) BETWEEN '{$from}' AND '{$to}' ");
			}
			else{
				$allSched = $dis->search(['department_id' => $this->department_id]);
			}

			return $allSched;
		}
		public function sched($from = false, $to = false)
		{
			$reg_sched 		= $this->reg_sched($from, $to);
			$irreg_sched 	= $this->irreg_sched($from, $to);

			$allSched = array_merge($reg_sched, $irreg_sched);

			return $allSched;
		}
		public function check_sched_conflict($sched_days = false, $sched_time = false, $sched_type = false)
		{
			$in 	= strtotime($sched_time['time_in']);
			$out 	= strtotime($sched_time['time_out']);
			$conflicts = [];


			if ($sched_type == 'reg') {
				$reg_sched = $this->reg_sched();

				foreach ($reg_sched as $key => $value) {
					if ( in_array($value->nfds_day, $sched_days) ) {
						$schedIn  = strtotime($value->nfds_time_in);
						$schedOut = strtotime($value->nfds_time_out);

						$in_range 	= $this->funcs->range($in, $schedIn, $schedOut);
						$out_range 	= $this->funcs->range($out, $schedIn, $schedOut);
						$schedInRange 	= $this->funcs->range($schedIn, $in, $out);
						$schedOutRange 	= $this->funcs->range($schedOut, $in, $out);

						
						if ($in_range || $out_range || $schedInRange || $schedOutRange) {
							$conflicts[] = $value;
						}
					}
				}

			}
			else{
				$sched_days = explode(",", $sched_days);
				if (!is_array($sched_days)) {
					$sched_days = [$sched_days];
				}

				foreach ($sched_days as $key => $value) {
					$value = trim($value);
					$dow = date('D', strtotime($value));


					$date  = date('Y-m-d', strtotime($value));
					$sched = $this->sched($date, $date);


					foreach ($sched as $key2 => $value2) {
						if (get_class($value2) == "Department_irregular_sched" ) {
							if ( date('m/d/Y', strtotime($value2->sched_from_date)) == $value) {
								$schedIn  = date('H:i', strtotime($value2->sched_from_date));
								$schedOut = date('H:i', strtotime($value2->sched_to_date));

								$schedIn  = strtotime($schedIn);
								$schedOut = strtotime($schedOut);
							}
							else{
								continue;
							}

						}else{
							if ( $value2->nfds_day == strtolower($dow)) {
								$schedIn  = strtotime($value2->nfds_time_in);
								$schedOut = strtotime($value2->nfds_time_out);

							}
							else{
								continue;
							}
										
						}

						$inRange 		= $this->funcs->range($in, $schedIn, $schedOut);
						$outRange 		= $this->funcs->range($out, $schedIn, $schedOut);
						$schedInRange 	= $this->funcs->range($schedIn, $in, $out);
						$schedOutRange 	= $this->funcs->range($schedOut, $in, $out);

						if ($inRange || $outRange || $schedInRange || $schedOutRange) {
							$conflicts[] = $value2;
						}

					}

				}
			}
			return $conflicts;
		}
		public function employees()
		{
			$this->load->model('employment');
			
			$employment = new Employment;
			$employment->toJoin = ['employee' => 'employment'];

			$emps = $employment->search(['department_id' => $this->department_id]);

			return $emps;

		}

	}
?>