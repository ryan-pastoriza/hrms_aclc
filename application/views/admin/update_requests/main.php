<?php

/**
 * @Author: IanJayBronola
 * @Date:   2018-10-10 13:28:12
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-10 14:07:07
 */

$this->load->view('admin/update_requests/jscripts');

$tbl = lte_load_view('dataTable',[
									'tableHeaders' => ['Employee',
													   'Date Filed',
														'Request',
														'Status',
														'Actions'
													],
									'tableRows' => [],
									'tableId' => 'requests-table',
									'tblVarName' => 'req_tbl',
									'tableOptions' => ['ajax' => base_url('index.php/admin/update_requests/eur_list')],
									'helper' => false,
								]);

echo lte_load_view('widget5',[
							'header' => "Employees Update Requests",
							'body' => $tbl,
							'bgColor' => "box-primary",
							'col_grid' => col_grid(6)
							]);
?>
<div class="modal fade" id="approve-req-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<?= form_open(base_url("index.php/admin/update_requests/approve"), 'id="approve-req-form"'); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Approve Employee Update request</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="eur_id">
       	<label for="">Send a response message</label>
       	<br>
       	<textarea name="eur_response" id="" rows="10" style="width:100%"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Approve Employee Request</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>