<style type="text/css">
        /* responsive text queries */
   .imgFooter{
        height: 30px;
        width: 50px;
        vertical-align: middle;
   }
   .footer h2{
    color: #ccc !important;
   }
   .footer
   {
    z-index: -1;
    position: fixed;
    bottom: 2%;
    right: 2%;
   }
   img
    {
      height: 150px;
      width:150px;
    }
    .content-wrapper{
      /*background: url("<?= base_url('images/biometric_log/bg.png') ?>");*/
      background: rgba(255,255,255,0.3);
      /*background-size:100%;*/
    }
      @font-face{
      font-family: 'HeroLight';
      src:url("<?php echo base_url('assets/fonts/HeroLight.otf'); ?>");
    }
    @font-face{
      font-family: 'stalemate';
      src:url("<?php echo base_url('assets/fonts/Stalemate-Regular.ttf'); ?>");
    }
     .box .box-header .box-title {
      font-family: 'HeroLight',Regular;
    }
    .title{
      font-family: stalemate !important;
    }
    body{
      background:  url("<?= base_url('images/biometric_log/morning.jpg') ?>"),linear-gradient(red,green) ;
      background-size: 100% 100%;
    }
    .bg-purple{
      background: rgba(255,255,255,0.3) !important; 
    }
    .clock{
      /*-webkit-transform: rotate(20deg);*/
      position: absolute;
      top:30px;
      right: 50px;
    }
    .clock .middle{
      border-top: 2px groove #63B5CD;
      border-bottom: 2px groove #63B5CD;
      margin-top:10px;
      background: linear-gradient(90deg,transparent,rgba(17,73,86,0.3), transparent);
      color:#fff;
      text-align:center;
      width:900px;
      height: 100px;
      line-height: 100px;
    }
    .clock .top{
      font-size: 1em;
      width:900px;
      text-align: center;
      /*background: rgba(0,0,0,0.4);*/
      /*padding-top:5px;*/
      /*padding-bottom: 5px;*/
      color: #114B59;
    }
    .clock .bottom{
      width:900px;
      text-align: center;
      color:#114B59;
    }
</style>
<?php 
  $date = date('F d, Y h:i A');
 ?>
 <script type="text/javascript">
 setInterval(function(){
  $.post("<?= base_url('index.php/biometrics/bio_log/show_logs') ?>",'',function(r){
     $('#logDisplay').html(r);
          });
  
  var dt = new Date();
  var hours = dt.getHours();
  var minutes = dt.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;





  $('.clock .middle').html(strTime);

 },1000)
 // setInterval(function(){
 //  $.post("<?= base_url('index.php/biometrics/bio_log/change_bg') ?>","", function(r){

 //  })
 // },1800000)
 </script>
 <body class="sidebar-collapse">
<div class="content-wrapper">
  <section class="content" style="margin-left:4%; margin-bottom:2%">
         <h1 style="font-size: 6em; color:#fff"><span ><?= date('l') ?></span><br>
           <small style="color:#128195">
           <div class="clock">
             <div class="top">
              <span class="title"><?= date('F d') ?></span>
             </div>
             <div class="middle">
               <?= date('h:i A') ?>
             </div>
             <div class="bottom">
               <?= date('Y') ?>
             </div>
           </div>
             
           </small>
         </h1>
  </section>
  <!-- <section class="content"> -->
    <div class="col-md-4">
        <div class="box box-solid bg-purple flat">
            <div class="box-header with-border">
                <center>
                    <h2 class="box-title" style="font-weight:bold;font-size:1.8em;">Upcoming Birthdays</h2>
                </center>
              </div>
              <div class="box-body row"><br>
                <?php if ($birthdays): ?>
                  <?php foreach ($birthdays as $key => $value): ?>
                  <ul class="users-list">
                    <li>
                    <?php 
                      $img = file_exists(base_url('images/users/{$value->employee_id}.jpg')) ? base_url('images/users/{$value->employee_id}.jpg') : base_url('images/no-image.fw.png');
                     ?>
                      <img src="<?= $img ?>" >
                      <a class="users-list-name" href="#" style="color:#222"><?= $value->fullName() ?></a>
                      <span class="users-list-date" style="color:#fff;background: rgba(255,94,94,0.8)"><?= $value->employee_bday() ?></span>
                    </li>
                  </ul>
                  <?php endforeach ?>
                <?php else: ?>
                  <center>
                    <h1 class="fa fa-frown-o"><br>No Birthdays this month.</h1>
                  </center>
                <?php endif ?>
              </div> 
        </div>
    </div>
    <div class="col-md-8" id='logDisplay'>
      <?php 
        // foreach ($recentLogs as $key => $empInfo) {

          $data['allLogs'] = $recentLogs;
          // $data['empInfo']  = $empInfo['emp_info'] ;
          $this->load->view('biometrics/home3',$data);
        // }
       ?>
    </div>
  <!-- </section> -->
</div>
 <div class="footer">
    <h2>
        <img class="imgFooter" src="<?= base_url() ?>images/engtech.fw.png" >
       <span>Engtech Global Solutions</span>
    </h2>
  </div>
  </div>
</body>