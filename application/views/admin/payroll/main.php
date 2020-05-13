<?php 


echo lte_tab([
              'tabs' => [
                          'Generate Payroll' 	=> $this->load->view('admin/payroll/generate',[], TRUE),
                          'Payroll Record' 		=> $this->load->view('admin/payroll/payroll_record_admin',[],TRUE)
                        ],
              'tab_id' => 'payroll-tabs'
            ]);

/* End of file main.php */
/* Location: ./application/views/admin/payroll/main.php */