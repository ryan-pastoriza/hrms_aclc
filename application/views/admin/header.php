<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>HRMS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?= base_url() ?>assets/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?= base_url() ?>assets/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?= base_url() ?>assets/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?= base_url() ?>assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?= base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?= base_url() ?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <!-- time Picker -->

    <link href="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
    
    <!-- data table -->
    <link href="<?= base_url() ?>assets/plugins/datatables/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/tautocomplete/tautocomplete.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/datatables/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"  />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body class="skin-blue">
    <div class="wrapper">
 		    <header class="main-header">
          <!-- Logo -->
          <a href="<?= base_url() ?>assets/index2.html" class="logo"><b>Admin</b>HRMS</a>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
           <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
              <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
              
                <!-- Messages: style can be found in dropdown.less-->
               
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    <span class="hidden-xs">Settings</span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="<?= base_url() ?>images/users/<?= $this->userInfo->employee_id ?>.jpg" class="img-circle" alt="User Image" />
                      <p>
                        <?= $this->userInfo->fullName('f m. l') ?>
                      </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                      <div class="col-xs-12 text-center">
                        HR ADMINISTRATOR
                      </div>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="<?= base_url()?>index.php/admin/account_settings" class="btn btn-default btn-flat">Account Settings <i class="fa fa-gears"></i></a>
                      </div>
                      <div class="pull-right">
                        <a href="<?= base_url() ?>index.php/admin/personnel_information/logout" class="btn btn-default btn-flat" id="logoutBTN">Sign out <i class="fa fa-sign-out"></i></a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
  </header>
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
      <!-- datepickter -->
      <script type="text/javascript" src="<?= base_url();?>assets/momentjs/moment.js"></script>
      <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
      <!-- Sparkline -->
      <script src="<?= base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
      <!-- jvectormap -->
      <script src="<?= base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
      <script src="<?= base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
      <!-- jQuery Knob Chart -->
      <script src="<?= base_url() ?>assets/plugins/knob/jquery.knob.js" type="text/javascript"></script>
      <!-- daterangepicker -->
      <script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
      <!-- datepicker -->
      <script src="<?= base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
      <!-- Bootstrap WYSIHTML5 -->
      <script src="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
      <!-- iCheck -->
      <script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
      <!-- Slimscroll -->
      <script src="<?= base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
      <!-- time Picker -->
      <script src="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
      <!-- FastClick -->
      <script src='<?= base_url() ?>assets/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/app.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/datatableTools.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/jszip.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/buttons.print.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables/weekdays-sorter.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>scripts/jquery.form.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/jquery-cookie-master/src/jquery.cookie.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/pace/pace.js"></script>
    <script src="<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>assets/tautocomplete/tautocomplete.js"></script>
     <script src="<?= base_url() ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
    

    <style type="text/css">
    #notifications{
      position: fixed;
      top: 2%;
      right: 1%;
      z-index: 100000 !important;
      min-width: 200px !important;
    }
    </style>
    <script type="text/javascript">
      $(function(){
        $(".timepicker").timepicker({
            showInputs: false
          });
      })
      //datetimepicker
      // $(function () {
      //   $('#datetimepicker1').datetimepicker();
      //   $('#datetimepicker2').datetimepicker();
      // });
    </script>
    
    <div id="notifications"></div>