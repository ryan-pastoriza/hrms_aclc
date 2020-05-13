<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Sched_Model extends MY_Model {

	const TIME_IN = "default";
	const TIME_OUT = "default";

	public function minutes_late()
	{
		$total_late = 0;
		if (isset($this->log)) {
			$interval_from_sched = $this->funcs->time_interval($this->log->emp_log_in,$this->{$this::TIME_IN});

			if ($interval_from_sched->invert) {
				$total_late += $interval_from_sched->i;
				$total_late += $interval_from_sched->h * 60;
			}

		}
		return $total_late;
	}
	public function minutes_undertime()
		{
		$total_undertime = 0;
		if (isset($this->log)) {
			$interval_from_sched = $this->funcs->time_interval($this->{$this::TIME_OUT},$this->log->emp_log_out);

			if ($interval_from_sched->invert) {

				$total_undertime += $interval_from_sched->i;
				$total_undertime += $interval_from_sched->h * 60;
				
			}

		}
		return $total_undertime;
	}

}

/* End of file Sched_Model.php */
/* Location: ./application/core/Sched_Model.php */