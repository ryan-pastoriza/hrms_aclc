<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Emp_Other_Deduction extends MY_Model{
		
		const DB_TABLE = "emp_other_deductions";
		const DB_TABLE_PK = "eod_id";

		public $eod_id;
		public $eod_date_filed;
		public $employee_id;
		public $other_ded_id;
		public $eod_amt_total;
		public $eod_term_deduction_amt;

		public function payments()
		{

			if (!isset($this->payments)) {
				$this->load->model('emp_other_deduction_payment');
				$pments = new Emp_Other_Deduction_Payment;

				$this->payments = $pments->search(['eod_id' => $this->eod_id]);

			}

			return $this->payments;

		}
		public function total_paid()
		{
			if(!isset($this->total_paid)){
				$sum = 0;
				foreach ($this->payments() as $key => $value) {
					$sum += $value->eod_payment_amount;
				}				
				$this->total_paid =  $sum;
			}
			return $this->total_paid;
		}
		public function balance()
		{
			if(!isset($this->balance)){
				$this->balance = $this->eod_amt_total - $this->total_paid();
			}
			return $this->balance;
		}		


	}
?>