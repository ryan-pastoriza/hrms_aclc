<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>HRMS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?= base_url() ?>assets/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?= base_url() ?>assets/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?= base_url() ?>assets/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker -->
    <link href="<?= base_url() ?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <!-- time Picker -->

    <link href="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
    
    <!-- data table -->
    <link href="<?= base_url() ?>assets/plugins/datatables/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?= base_url() ?>assets/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
  </head>
<script type="text/javascript" src="<?= base_url();?>scripts/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/plugins/jquery-1.11.3.min.js"></script>
<!-- jQuery 2.1.3 -->
    <script src="<?= base_url() ?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- jQuery UI 1.11.2 -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
    <script src="<?= base_url() ?>assets/bootstrap/js/validator.js" type="text/javascript"></script>    
    <!-- Morris.js charts -->
      
      
      <!-- daterangepicker -->
      <script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
      <!-- datepicker -->
      <script src="<?= base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
      
      <!-- time Picker -->
      <script src="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
      
    <!-- DATA TABES SCRIPT -->
    <script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>scripts/jquery.form.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/jquery-cookie-master/src/jquery.cookie.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <style type="text/css">
    #notifications{
      position: fixed;
      top: 2%;
      right: 1%;
      z-index: 100000 !important;
      min-width: 200px !important;
    }
    </style>
    <div id="notifications"></div>
