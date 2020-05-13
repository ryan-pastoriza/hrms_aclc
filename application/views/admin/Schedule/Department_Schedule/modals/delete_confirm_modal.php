<div id="delete-sched-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Schedule?</h4>
      </div>
      <div class="modal-body">
       <?= form_open(base_url('index.php/admin/department_schedule/delete_sched'), 'id="delete-sched-form"');?>
        <span class="text-warning">Are you sure you want to delete this schedule?</span>
        <input type="hidden" name="id">
        <input type="hidden" name="sched_type">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Yes</button>
        <?= form_close(); ?>
      </div>

    </div>
  </div>
</div>