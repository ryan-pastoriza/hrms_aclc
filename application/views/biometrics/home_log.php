<?php 
	$this->load->view('biometrics/home_log_css');
 ?>
 <style type="text/css">
 	.recovery-container{
		position: fixed;
		display: none;
		top: 0;
		left: 0;
		min-height: 100%;
		min-width: 100%;
		background: rgba(255,90,90,0.5);
		z-index: 10000 !important;
	}
	.recovery-panel{
		background: #333;
		position: absolute;
		top: 15%;
		left: 15%;
		height: 60%;
		width: 60%;
		padding:5%;
		color:#fff;
	}
	.ajax-viewer{
		color:rgb(70,255,70);
	}
 </style>
<script type="text/javascript">
	var ann_count = <?= count($announcements) ?>;
	setInterval(function(){

	  var dt 		= new Date();
	  var hours 	= dt.getHours();
	  var minutes 	= dt.getMinutes();
	  var seconds 	= dt.getSeconds();
	  var ampm 		= hours >= 12 ? 'PM' : 'AM';


	  var d 		= new Date();
	  var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

	  var curMonth 	= d.getMonth() + 1;
	  var curDate 	= d.getDate();
	  var curYear 	= d.getFullYear();
	  var curDay 	= days[d.getDay()];

	  var dispMonth = $('#month-display').html();
	  var dispDate 	= $('#date-display').html();
	  var dispYear 	= $('#year-display').html();
	  var dayDisp 	= $('#dow-display').html();
	  var checkingChanged = false;

	   var allMonths = ['January', 'February', 'March', 'April','May','June','July','August','September','October','November','December'];

	   
	 if(parseInt(curDate) != parseInt(dispDate)){
	  		$('#month-display').html(allMonths[curMonth]);
	  		$('#date-display').html(curDate);
	  		$('#year-display').html(curYear);
			$('#dow-display').html(curDay);
	  }


	  hours = hours % 12;
	  hours = hours ? hours : 12; // the hour '0' should be '12'
	  minutes = minutes < 10 ? '0'+minutes : minutes;
	  seconds = seconds < 10 ? '0'+seconds: seconds;
	  var strTime = hours + ':' + minutes + ':' + seconds;

	  $('.timer').html(strTime);
	  $('.ampm').html(ampm);

	 },1000)
	$(function(){
	  checkNewLog();
	})


	function getval() {
	    var currentTime = new Date()
	    var hours = currentTime.getHours()
	    var minutes = currentTime.getMinutes()
	    if (minutes < 10) minutes = "0" + minutes;
	    var suffix = "AM";
	    if (hours >= 12) {
	        suffix = "PM";
	        hours = hours - 12;
	    }
	    if (hours == 0) {
	        hours = 12;
	    }
	    var current_time = hours + ":" + minutes + " " + suffix;
	    return current_time;
	} 

	var checkNewLog = function(){

		var curr_time = getval();

		var beginningTime = moment('05:00 AM', 'h:mma');
		var endTime = moment('11:00 PM', 'h:mma');

		curr_time = moment(curr_time,'h:mma');


		try{
			if (curr_time.isBefore(endTime)  && curr_time.isAfter(beginningTime) ) {
				$.post("<?= base_url('index.php/biometrics/bio_log/monitor_log') ?>","ann_count="+ann_count,function(r){
						$('#log-monitor').html(r.monitoring);
						$('#log-history').html(r.log_history);

						if(r.recovery === false){
							if (r.announcements !== false) {
								ann_count = r.new_ann_count;
								$('[announcements-view]').html(r.announcements);
							}
						// setTimeout(function(){
							  checkNewLog();

						// },3000)
						}
						else{
							enter_recovery_mode(r.attendance);
						}

						console.log("loading");
					}, 'json')
				.fail(function(a){
					location.reload();
				})
			}
			else{
						console.log("stopped");
				setTimeout(function(){
					console.log("continue");
					checkNewLog();
				},10000)
			}
		}
		catch(e){
						console.log("catch");
			checkNewLog();
		}

	}
	var enter_recovery_mode = function(data,total = 0){
		$('.recovery-container').show();
		if (data.length > 0) {
			var to_record = data.shift();
			$.post("<?= base_url('index.php/biometrics/bio_log/record_from_recovery') ?>","att_data="+JSON.stringify(to_record), function(r){
				$('.ajax-viewer').html(r+"<br><span class='text-yellow'>TOTAL RECOVERED DATA: "+ total+"</span>");
				total + 1;
				enter_recovery_mode(data,total);
			})
		}
		else{
			$('.recovery-container').hide();
			checkNewLog();
		}
	}

</script>

 <body class="sidebar-collapse">
	<div class="content-wrapper">
		<section class="head">
	       <div class="head-left">
	       		<span class="timer"></span> <span class="panel source-light ampm"><?= date('A') ?></span>
	       </div>
	       <div class="head-mid">
	       		<h2 class="source-light">AMA COMPUTER LEARNING CENTER
	       		<img src="<?= base_url('images/icon-image/sun.fw.png') ?>">
	       			<br>
					<small>Butuan City, Agusan del Norte</small>
	       		</h2>
	       		<img src="<?= base_url('images/ama.fw.png') ?>">
	       		
	       </div>
	       <div class="head-right source-light">
	       </div>
	       <div class="head-rightest">
	       		<span>TODAY IS</span>
	       		<span id="month-display"><?= date('F') ?></span> <span id="date-display" style="font-size: 2em; line-height: .3em"><?= date('d') ?>, </span> <span id="year-display"><?= date('Y') ?></span>
	       		<span id="dow-display"><?= strtoupper(date('l')) ?></span>
	       </div>
		</section>
		<section class="content">
			<!-- <div class="row"> -->
				<div class="col-sm-4">
					

						<!-- BIRTHDAYS -->
			          <div class="box box-navy box-solid" style="height:	">
			            <div class="box-header ">
			              <h1 class="box-title source-light"> Upcoming Birthday Celebrants</h1>
							<div class="box-tools pull-right">
					            <i class="fa fa-birthday-cake" style="font-size: 2em;"></i>
				             </div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body" >
			            	<div class='row'>
			            	 <?php if ($birthdays): ?>
			                  <?php foreach ($birthdays as $key => $value): ?>
			                   <?php 
		                      	$img = file_exists(base_url('images/users/{$value->employee_id}.jpg')) ? base_url('images/users/{$value->employee_id}.jpg') : base_url('images/no-image.fw.png');
			                   ?>

							   <?php if($value->employment_status == "active"):?>
			                  <div class='col-sm-3 bg-info' style='height:170px; border-radius:50%;margin:10px !important;padding:5px'>
			                  	<center>
			                  		<img src="<?= $img ?>" style="width:90%">
			                  		<a href="#" style="color:#222;line-height:1em;font-size:2em;background:rgba(255,255,255,0.6);position:absolute;bottom:0px;left:0px">
			                  			<?= $value->fullName() ?>
			                  		</a>
			                  			<span style="color:#fff;background: #154360; position:absolute;top:0px;right:-10px;font-size:2.5em;padding:10px;border-radius:50%"><?= date('d', strtotime($value->employee_bday())) ?></span>
			                  	</center>
			                  </div>
			              	 <?php endif;?>
			                 <!--  <ul class="">
			                    <li style="">
			                    <?php 
			                      $img = file_exists(base_url('images/users/{$value->employee_id}.jpg')) ? base_url('images/users/{$value->employee_id}.jpg') : base_url('images/no-image.fw.png');
			                     ?>
			                      <img src="<?= $img ?>" >
			                      <a class="users-list-name" href="#" style="color:#222"><?= $value->fullName() ?></a>
			                      <span class="users-list-date" style="color:#fff;background: #154360"><?= $value->employee_bday() ?></span>
			                    </li>
			                  </ul> -->
			                  <?php endforeach ?>
				              </div>
			                <?php else: ?>
			                  <center>
			                    <h1 class="fa fa-frown-o"><br>No Birthdays this month.</h1>
			                  </center>
			                <?php endif ?>

			            </div>
			            <!-- /.box-body -->
			          </div>
			          <!-- BIRTHDAYS -->


			          <div class="box box-navy box-solid" >
			            <div class="box-header ">
			              <h3 class="box-title source-light"> Announcements </h3>
							<div class="box-tools pull-right">
					            <i class="fa fa-bullhorn" style="font-size: 2em;"></i>
							</div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body" style="height: 400px;overflow: hidden;">
							<div id="carousel-example-generic" class="carousel slide" announcements-view data-ride="carousel">
								<?php 
									$this->load->view('biometrics/announcements');
								 ?>
		              	</div>

			            </div>
			            <!-- /.box-body -->
			          </div>

			          

				</div>
				<div class="col-sm-4" id="log-monitor">
					<?php 
						$this->load->view('biometrics/log_monitor');
					 ?>
				</div>
				<div class="col-sm-4" id="log-history">
					<?php 
						$this->load->view('biometrics/log_history');					
					 ?>
				</div>
			<!-- </div> -->
		</section>
	</div>
	<div class="recovery-container">
		<div class="recovery-panel">
			<h2>Recovery Mode, Please Wait. . .</h2>
			<div class="ajax-viewer">Gathering Attendance Data...</div>
		</div>
	</div>

 </body>