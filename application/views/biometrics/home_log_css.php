<style type="text/css">
body{
	background: #ddd;
}
.head{
	background: #154360;
	padding: 0px;
}
.head h1{
	line-height: 1em;
}
.head h1 small{
	color:#fff !important;
	/*line-height: 1em;*/
}
.head-left{
	float: left;
	padding-left: 20px;
	font-size: 3.5em;
	color: #fff;
	line-height: 1em;
	margin-top: 30px !important;
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
	padding: 0px 20px;
	margin:0;
	display: inline-block;
}
.head-mid{
	width:50%;
	color: #fff;
	text-align: center;
}
.head-mid>h2{
	vertical-align: middle;
	float: left;
	margin-left: 15%;
}
.head-mid img:first-child{
	position: absolute;
	left: 18%;
	/*top: 3%;*/
	width: 50px;
	height: 50px;
	margin-top: 0;
}
.head-mid img{
	/*vertical-align: middle;*/
	height: 80px;
	display: inline-block;
	float: left;
	margin-top:20px;
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
	font-size:2em;
	line-height: 3.77em;
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
	width: 7em;
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
	height: 120px;
	width: 100%;
	text-align: center;
	color: #fff;
	position: absolute;
	bottom: 0px;
	padding-bottom: 20px;
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
	bottom: -100;
	background: #DD4B39;
	border-radius: 10px;
	color: #fff;
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
  src:url("<?php echo base_url('hrms/assets/fonts/SourceSansPro-Regular.ttf'); ?>");
}
@font-face{
  font-family: 'Source Sans Pro Light';
  src:url("<?php echo base_url('hrms/assets/fonts/SourceSansPro-Light.ttf'); ?>");
}
</style>