<?php
/**
 * @Author: khrey
 * @Date:   2015-09-28 14:34:27
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-19 14:30:57
 */
?>


    
<?php foreach ($allLogs['recentLogs'] as $key => $value): ?>
    
  <?php 
    $this->load->model('employee','empInfo');
    $empInfo = new Employee;
    $empInfo->toJoin = array('employment' => 'employee',
                            'department' => 'employment');
    $empInfo->load($value->employee_id);
   ?>
    <div class="col-md-12 fade-in">
      <div class="callout callout-black row">
        <div class="col-md-3">
          <center>
          <img src="<?= base_url('images/users/1201330024.jpg') ?>" class="img-circle" alt="User Image" style="height:100px !important; width:100px !important">
            <a class="users-list-name" href="#"><?= $empInfo->fullName('f m. l') ?></a>
            <span class="users-list-date" style='color:black'><?= $empInfo->department_name ?> Department</span>
          </center>
        </div>
        <div class="col-md-9">
        <?php 
          foreach ($empInfo->logs_today() as $key => $log) {
            $sched = date('A',strtotime($value->nfds_time_in));
            $logOutTimeDisp = "<span class='text-red'>NO LOG.</span>";
            $loginTimeDisp = "<span class='text-red'>NO LOG.</span>";
            $lateDisplay = "";
            $underDisplay = "";
            $loginTimeDisp = date('h:i:s a', strtotime($log->log_in));

            if ($log->log_out != "") {
              $logOutTimeDisp = date('h:i:s a', strtotime($log->log_out));

              if (strtotime($log->log_out) < strtotime($value->nfds_time_out)) {
                $logOutInterval = $this->funcs->time_interval($log->log_out,$value->nfds_time_out);
                $underTimeHrs  = $logOutInterval->h;
                $underTimeMins = $logOutInterval->i;

                if ($underTimeHrs) {
                  $underDisplay .= $underTimeHrs . " hour/s and ";
                }
                // if ($underTimeMins) {
                  $underDisplay .= $underTimeMins . " minute/s early.";
                // }
              }
            }
            if ($log->log_in != "") {
                if (strtotime($log->log_out) < strtotime($value->nfds_time_out)) {
                  $log_in_interval = $this->funcs->time_interval($value->nfds_time_in,$log->log_in);
                  $lateHours = $log_in_interval->h;
                  $lateMins = $log_in_interval->i;

                  if ($lateHours) {
                    $lateDisplay .= $lateHours. " hour/s and ";
                  }
                  // if ($lateMins) {
                    $lateDisplay .= $lateMins." minute/s late.";
                  // }
                }
              }
              ?>
              <!-- logs display -->
                  <!-- AM logs -->
                    <div class="col-md-12 col-lg-6 col-xl-12">
                      <div class="info-box bg-gray">
                        <span class="info-box-icon"><?= $sched ?></span>
                        <div class="info-box-content">
                          <div class="col-md-12">
                            <span class="info-box-text fa fa-sign-in"> Time In</span>
                            <span class="info-box-number"><?= $loginTimeDisp; ?></span>
                            <span class="text-red"><?= $lateDisplay ?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- / AM log -->
                    <!-- PM log -->
                    <div class="col-md-12 col-lg-6">
                      <div class="info-box bg-purple disabled">
                        <span class="info-box-icon"><?= $sched ?></span>
                        <div class="info-box-content">
                          <div class="col-md-12">
                            <span class="info-box-text fa fa-sign-in"> Time Out</span>
                            <span class="info-box-number"><?= $logOutTimeDisp ?></span>
                            <span class="text-red"><?= $underDisplay ?></span>
                          </div>
                        </div><!-- /.info-box-content -->
                      </div><!-- /.info-box -->
                    </div>
                    <!-- / pm log -->
               <!-- /logs display -->
              <?php
          }
            ?>
            
      </div>
  </div>
</div>
<?php endforeach ?>
  <?php if (count($allLogs['noIds']) > 0): ?>
    <div class='col-md-12'>
      <div class='callout callout-warning'>
      <small class="text-black">Log Warnings
      </small>
      <ul>

      <?php foreach ($allLogs['noIds'] as $key => $value): ?>
          <li><?= $value['error'] ?></li>
      <?php endforeach ?>
      </ul>
      </div>
    </div>
  <?php endif ?>
