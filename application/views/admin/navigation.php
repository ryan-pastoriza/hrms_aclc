 <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?= base_url() ?>images/users/<?= $this->userInfo->employee_id ?>.jpg" class="img-circle" alt="<?= base_url() ?>images/users/ermegerd.jpg" />
            </div>
            <div class="pull-left info">
              <p><?= $this->userInfo->fullName("f m. l") ?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?= $this->uri->segment(2) == "home" ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/home"><i class="fa fa-home" ></i>Home</a>
            </li>
            <li class="treeview <?= $this->uri->segment(2) == "employees" || $this->uri->segment(2) == 'personnel_information' ? 'active':'' ?>">
              <a href="#">
                <i class="fa fa-user"></i> <span>PIS</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?= $this->uri->segment(2) == 'personnel_information' ? 'active':'' ?>"><a href="<?= base_url() ?>index.php/admin/personnel_information"><i class="fa fa-circle-o"></i> New</a></li>
                <li class="<?= $this->uri->segment(2) == 'employees' ? 'active':'' ?>"><a href="<?= base_url() ?>index.php/admin/employees"><i class="fa fa-circle-o"></i>Employees</a></li>
              </ul>
            </li>
            <li class="<?= $this->uri->segment(2) == "departments" ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/departments">
                <i class="fa fa-sitemap"></i>
                <span>Departments</span>
              </a>
            </li>
            <li class=" treeview <?= $this->uri->segment(2) == "employee_schedule" || $this->uri->segment(2) == 'department_schedule' ? 'active':'' ?>" >
              <a href="#">
                <i class="fa fa-clock-o"></i> <span>Schedule</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?= $this->uri->segment(2) == 'department_schedule' ? 'active':'' ?>"><a href="<?= base_url() ?>index.php/admin/department_schedule"><i class="fa fa-circle-o"></i>Department Sched</a></li>
                 <li class="<?= $this->uri->segment(2) == 'employee_schedule' ? 'active':'' ?>"><a href="<?= base_url() ?>index.php/admin/employee_schedule"><i class="fa fa-circle-o"></i>Employee Sched</a></li>
              </ul>
            </li>
            <li class="<?= $this->uri->segment(2) == 'biometrics' ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/biometrics">
                <i class="glyphicon glyphicon-thumbs-up"></i> <span> Biometrics </span>
              </a>
            </li>

            <li class="treeview <?= $this->uri->segment(2) == 'daily_time_record' || $this->uri->segment(2) == 'failure_to_log' ? 'active' : ''?>">
              <a href="#">
                <i class="fa fa-sun-o"></i> <span>Daily Time Record</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?= $this->uri->segment(2) == 'daily_time_record' ? 'active' : '' ?>">
                  <a href="<?= base_url() ?>index.php/admin/daily_time_record">
                    <i class="fa fa-circle-o"></i>Attendance
                  </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'failure_to_log' ? 'active' : '' ?>">
                  <a href="<?= base_url() ?>index.php/admin/failure_to_log">
                    <i class="fa fa-circle-o"></i>Failure to Log
                  </a>
                </li>
              </ul>
            </li>

            <!-- <li class="<?= $this->uri->segment(2) == 'daily_time_record' ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/daily_time_record">
                <i class="fa fa-sun-o"></i> <span> Daily Time Record</span>
              </a>
            </li> -->

            <li class="<?= $this->uri->segment(2) == 'my_calendar' ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/my_calendar">
                <i class="glyphicon glyphicon-calendar"></i> <span> Calendar</span>
              </a>
            </li>
            <li class="<?= $this->uri->segment(2) == 'leave' ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/leave">
                <i class="fa fa-sticky-note-o"></i> <span> Leave</span>
              </a>
            </li>
            <li class="<?= $this->uri->segment(2) == 'payroll' ? 'active':'' ?>">
              <a href="<?= base_url() ?>index.php/admin/payroll">
                <i class="fa fa-calculator"></i> <span> Payroll</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
   <div class="content-wrapper row-fluid">