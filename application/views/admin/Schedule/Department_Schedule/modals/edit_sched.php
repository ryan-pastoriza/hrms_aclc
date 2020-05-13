<div id="edit-sched-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Schedule</h4>
      </div>
      <div class="modal-body">
        <?= form_open(base_url('index.php/admin/department_schedule/edit_sched'), 'id=edit-sched-form'); ?>
        <div id="edit-sched-view"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
        <button type="submit" class="btn btn-success" id="payment_btn_add"><span class="fa fa-save"></span> Save</button>
        <?= form_close(); ?>
      </div>

    </div>
  </div>
</div>