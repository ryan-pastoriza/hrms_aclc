<?php
/**
 * @Author: khrey
 * @Date:   2015-08-17 11:20:28
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-09-07 10:50:54
 */

 $empsInDeptsPhp = json_decode($empsInDepts);

  

  $counter = 0;
?>
<link href="<?= base_url() ?>assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>assets/plugins/raphael.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/morris/morris.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- DONUT CHART -->
  <section class="content">
    <div class="col-md-6 ">
        
          
    <div class="col-sm-12">
      <?php
        $this->load->view('admin/dashboard/announcements.php');
      ?>    
    </div>
    </div>
    <?php if (!$birthdays): ?>
        <div class="col-md-4">
          <div class="info-box bg-yellow">
              <span class="info-box-icon "><i class="fa fa-frown-o"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"></span>
                <span class="info-box-number">No Birthdays this month.</span>
              </div><!-- /.info-box-content -->
          </div>
        </div>
    <?php else: ?>
      <div class="col-sm-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Birthays This Month!</h3>
        </div>
        <div class="box-body">
          <ul class="users-list clearfix">
              <?php foreach ($birthdays as $key => $value): ?>
                <li>
                 <img src= '<?= file_exists(base_url()."images/users/".$value->employee_id.".jpg") ? base_url()."images/users/".$value->employee_id.".jpg" : base_url()."images/no-image.fw.png" ?>' >
                  <a class="users-list-name" href="#"><?= $value->fullName("f m. l") ?></a>
                  <span class="users-list-date"><?= $value->employee_bday() ?></span>
                </li>
              <?php endforeach ?>
          </ul>
        </div>
      </div>
      </div>
    <?php endif ?>
    <div class="col-md-4">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Employees Chart</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <?php foreach ($empsInDeptsPhp as $key => $value): ?>
              <label for="" class="label" style="background: <?= $colours[$counter] ?>"><?= $value->label ?></label>
              <?php 
                if ($counter == count($colours) - 1) {
                  $counter = 0; 
                }
                else{
                  $counter++; 
                }

              ?>
            <?php endforeach ?>
          </div>
        </div><!-- /.box -->

      </div><!-- /.col (LEFT) -->
    </div>
</section>
<?php 
  // $this->load->view('admin/home/jscripts.php', $data, FALSE);
 ?>
<script>
	// var donut = new Morris.Donut({
 //          element: 'sales-chart',
 //          colors: ["#357CA5", "#3C8DBC", "#80B5D3","#30BBBB","#39CCCC","#7EDEDE"],
 //          data: <?php 
 //          		echo $empsInDepts;
 //          	?>,
 //          hideHover: 'auto'
 //        });
</script>