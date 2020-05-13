<div class="box box-primary">
  <div class="box-header with-border">
            <i class="fa fa-bullhorn" style="font-size: 2em;"></i>
    <div class=" pull-right">
    <h3 class="box-title">Announcements</h3>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">

    <?= form_open(base_url('index.php/admin/home/post_announcement'), 'id="post-announcement-form"'); ?>
    <form role="form">
                <!-- text input -->
        <div class="form-group">
          <label>Title</label>
          <input type="text" class="form-control" placeholder="Announcement Title" name="announcement_title" required="">
        </div>

        <!-- textarea -->
         <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Announcement Starts</label>
              <input type="date" class="form-control" name="announcement_start" required="">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Announcement Ends</label>
              <input type="date" class="form-control" name="announcement_end" required="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label>Announcement</label>
          <textarea class="form-control" rows="3" placeholder="Enter ..." name="announcement_body" required=""></textarea>
        </div>
        <div class="row">
        <div class="col-sm-12">
        <div class="pull-right">
            <button type="reset" class='btn btn-default btn-xs'><i class="fa fa-times"></i> Clear</button>
            <button  type="submit" class='btn btn-primary btn-xs'><i class="fa fa-paper-plane-o" id='submit-announcement-icon'></i> POST ANNOUNCEMENT</button>
        </div>
      </div>
      </div>
      </form>

    <hr>

    <div id="announcements-list" style="max-height: 500px;overflow: auto">
    <?php 
      $this->load->view('admin/dashboard/announcements_list');
     ?>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<?php 
    $this->load->view('admin/dashboard/jscripts');
 ?>