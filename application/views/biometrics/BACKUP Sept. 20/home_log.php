<style type="text/css">
	body{
		background: #ddd;
	}
	.head{
		background: #154360;
		height: 100px !important !important;
		padding: 0px;
	}
	.head h1{
		line-height: .7em;
	}
	.head h1 small{
		color:#fff !important;
		line-height: .5em;
	}
	.head-left{
		font-size: 3.5em;
		color: #fff;
		line-height: 2em;
		border-right: 1px solid #486F87 !important;
		width: 18%;
		font-family: 'Source Sans Pro Regular';
		/*padding: ;*/
	}
	.source-light{
		font-family: 'Source Sans Pro Light';
	}
	.source-regular{
		font-family: 'Source Sans Pro Regular';
	}
	.head-left .panel{
		padding: 5px 10px;
		color: #154360;
	}
	.content-wrapper{
		background: #ddd !important;
		height: 100px !important;
	}
	.head>div{
		padding: 0;
		margin:0;
		display: inline-block;
	}
	.head-mid{
		width:40%;
		color: #fff;
		text-align: center;
	}
	.head-mid>h1{
		vertical-align: middle;
		float: left;
		margin-left: 15%;
	}
	.head-mid img:first-child{
		position: absolute;
		left: 18%;
		top: 3%;
		width: 50px;
		height: 50px;
	}
	.head-mid img{
		/*vertical-align: middle;*/
		height: 80px;
		display: inline-block;
		float: left;
		margin-left: 10px;
	}
/*	.head-right{
		font-size: 3em;
		line-height: 1em;
		color: #fff;
		padding-right: 10%;
	}*/
	.head-rightest{
		position: absolute;
		right: 0px;
		top: 0px;
		background: #fff;
		font-size:3em;
		line-height: 2.7em;
		/*padding:10px;*/
		padding-left:100px;
		color:#154360;
		font-family: 'Source Sans Pro Light';
	}
	.head-rightest>span:first-child{
		background:#FFA64D; 
		color:#fff;
		font-size: 12pt;
		-webkit-transform: rotate(-90deg);
		display: block;
		height: 14pt;
		line-height: .5em;
		transform-origin: bottom left;
		position: absolute;
		bottom: 0px;
		left: 0px;
		text-align: center;
		padding: 5px;
		width: 7.5em;
	}
	.navy-text{
		color:#154360;
	}
	.box-navy .box-header{
		background: #154360;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		color:#fff;
	}
	.logger img{
		width: 100%;
		border-radius:10px;
		/*height: 400px;*/
	}
	.logger>.img-frame{
		width: 80%;
		position: relative;
		text-align: center;
		margin:5% 10%;
	}
	.logger{
		/*padding:10%;*/
	}
	.box{
		border-radius: 5px;
	}
	.logger-info{
		z-index: 10;
		background: rgba(21,67,96,0.7);
		height: 100px;
		width: 100%;
		text-align: center;
		color: #fff;
		position: absolute;
		bottom: 0px;
		border-bottom-left-radius: 10px;
		border-bottom-right-radius: 10px;
	}
	.log-label{
		font-weight: lighter;
		background: #8A8A7A;
		width: 100%;
		text-align: center;
		padding: 10px;
		color: #fff;
		font-size: 1.3em;
	}
	.log-monitor{
		margin:2% 10%;
		border-top:1px solid #8A8A7A;
		position: relative;
	}
	.log-monitor label{
		position: absolute;
		top:-0.98em;
		background: #fff;
		padding: 5px 15px 5px 0px;
		color:#8A8A7A ;
		left: 0;
		font-family: 'Source Sans Pro Regular';
	}
	.log-monitor>.logs{
		padding: 0;
	}
	.log-monitor>.logs>ul.log-set>li{
		color: #154360;
		padding:0;
		list-style: none;
	}
	.log-monitor>.logs>ul.log-set>li>div>.right-part{
		float: right;
		color: #fff;
		padding: 0 10px;
		border-top-right-radius: 10px;
		border-bottom-right-radius: 10px;
		background: #154360;
		z-index: 40;
	}
	.log-monitor>.logs>ul.log-set>li>div>.left-part{
		float: left;
		overflow: hidden;
	}
	.log-monitor>.logs>ul.log-set>li>div>.left-part>h1>p{
		font-size: .4em;
		width: 70%;
		text-align: center;
		margin-left: -15px;
		position: absolute;
		bottom: 0;
	}
	.log-monitor>.logs>ul.log-set>li>div{
		border-radius: 10px;
		line-height: .3em;
		background: #CECEBF;
		margin:0;
		padding-right: 0;
		margin-top:3%;
		width: 47% !important;
	}
	.log-monitor>.logs>ul.log-set>li>div:nth-child(even){
		margin-left: 3%;
		color: #00698C;
	}
	.log-monitor>.logs>ul.log-set>li>div:nth-child(even)>.right-part{
		background: #00698C;
	}
	.log-monitor>.logs>ul.log-set>li>div:nth-child(even) small{
		color: #00698c;
	}
	.log-monitor>.logs>ul.log-set>li>div:nth-child(odd){
		margin-right:3%;
	}
	.log-monitor>.logs>ul.log-set{
		position: relative;
		padding:0px 15px;
	}
	ul.users-list{
		padding:0;
		color: #154360;
	}
	ul.log-history>li{
		list-style: none;
		padding: 0;
		margin-bottom: 10px;
		display: block;
		position: relative;
		border-bottom:2px groove #fff;
		width: 97%;
		padding-bottom: 10px;
	}
	ul.log-history{
		padding: 0;
		padding-left: 15px;
		font-family: 'Source Sans Pro Regular';
	}
	ul.log-history>li>.empInfo>img{
		float: left;
		height: 100px;
		margin-right: 10px;
		display: inline-block;
		border-radius: 5px;
	}
	ul.log-history>li *{
		color: #154360;
	}
	ul.log-history>li>.empInfo>.info-block{
		/*float: left;*/
		margin-right: 10px;
		margin-bottom: 20px;
		display: block;
		width: 100%;
	}
	ul.log-history>li>.empInfo>.log-block{
		border-left: 1px solid #ddd !important;
		float: left;
		padding-left: 10px;
		margin-left: 5px;
	}
	ul.log-history>li>.empInfo>.log-block>.block{
		margin-bottom: 10px;
	}
	ul.log-history>li>.empInfo>.log-block>.block>span{
		background: #154360;
		padding: 5px 10px;
		border-radius:5px;
		color: #fff;
		display: inline-block;
		text-align: center;
		width: 50px;
	}
	ul.log-history>li>.empInfo>.log-block>.block:nth-child(odd)>span{
		background: #0085B2;
	}
	ul.log-history>li>.empInfo>.info-block>h3{
		color: #154360;
		padding: 0;
		padding-top: 20px;
		font-size: 2em;
		line-height: .8em;
	}
	@font-face{
      font-family: 'Source Sans Pro Regular';
      src:url("<?php echo base_url('assets/fonts/SourceSansPro-Regular.ttf'); ?>");
    }
    @font-face{
      font-family: 'Source Sans Pro Light';
      src:url("<?php echo base_url('assets/fonts/SourceSansPro-Light.ttf'); ?>");
    }
</style>

<script type="text/javascript">
	setInterval(function(){

	  var dt = new Date();
	  var hours = dt.getHours();
	  var minutes = dt.getMinutes();
	  var seconds = dt.getSeconds();
	  var ampm = hours >= 12 ? 'PM' : 'AM';


	  hours = hours % 12;
	  hours = hours ? hours : 12; // the hour '0' should be '12'
	  minutes = minutes < 10 ? '0'+minutes : minutes;
	  seconds = seconds < 10 ? '0'+seconds: seconds;
	  var strTime = hours + ':' + minutes + ':' + seconds;

	  $('.timer').html(strTime);
	  $('ampm').html(ampm);
	  checkNewLog();

	 },1000)

	var checkNewLog = function(){
		$.post("<?= base_url('hrms/index.php/biometrics/bio_log/monitor_log') ?>","data",function(r){
				$('#log-monitor').html(r.monitoring);
				$('#log-history').html(r.log_history);
			}, 'json')
	}

</script>

 <body class="sidebar-collapse">
	<div class="content-wrapper">
		<section class="head">
	       <div class="head-left">
	       		<span class="timer"></span> <span class="panel source-light ampm"><?= date('A') ?></span>
	       </div>
	       <div class="head-mid">
	       		<h1 class="source-light">AMA COMPUTER LEARNING CENTER
	       		<img src="<?= base_url('hrms/images/icon-image/sun.fw.png') ?>">
	       			<br>
					<small>Butuan City, Agusan del Norte</small>
	       		</h1>
	       		<img src="<?= base_url('hrms/images/ama.fw.png') ?>">
	       		
	       </div>
	       <div class="head-right source-light">
	       </div>
	       <div class="head-rightest">
	       		<span>TODAY IS</span>
	       		<?= date('F') ?> <span style="font-size: 2em; line-height: .3em"><?= date('d') ?>, </span> <?= date('Y') ?>
	       		<?= strtoupper(date('l')) ?>
	       </div>
		</section>
		<section class="content">
			<!-- <div class="row"> -->
				<div class="col-sm-4">
					<div class="box box-navy box-solid" style="height: 400px">
			            <div class="box-header ">
			              <h3 class="box-title source-light"> Upcoming Birthday Celebrants</h3>
							<div class="box-tools pull-right">
					            <i class="fa fa-birthday-cake" style="font-size: 2em;"></i>
				             </div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body row" >
			            	
			            	 <?php if ($birthdays): ?>
			                  <?php foreach ($birthdays as $key => $value): ?>
			                  <ul class="users-list">
			                    <li>
			                    <?php 
			                      $img = file_exists(base_url('hrms/images/users/{$value->employee_id}.jpg')) ? base_url('hrms/images/users/{$value->employee_id}.jpg') : base_url('hrms/images/no-image.fw.png');
			                     ?>
			                      <img src="<?= $img ?>" >
			                      <a class="users-list-name" href="#" style="color:#222"><?= $value->fullName() ?></a>
			                      <span class="users-list-date" style="color:#fff;background: #154360"><?= $value->employee_bday() ?></span>
			                    </li>
			                  </ul>
			                  <?php endforeach ?>
			                <?php else: ?>
			                  <center>
			                    <h1 class="fa fa-frown-o"><br>No Birthdays this month.</h1>
			                  </center>
			                <?php endif ?>

			            </div>
			            <!-- /.box-body -->
			          </div>
			          <div class="box box-navy box-solid" >
			            <div class="box-header ">
			              <h3 class="box-title source-light"> Announcements </h3>
							<div class="box-tools pull-right">
					            <i class="fa fa-bullhorn" style="font-size: 2em;"></i>
							</div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body" style="height: 400px;overflow: hidden;">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<?php 
									$this->load->view('biometrics/announcements');
								 ?>
				                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
				                  <span class="fa fa-angle-left"></span>
				                </a>
				                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
				                  <span class="fa fa-angle-right"></span>
				                </a>
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
 </body>