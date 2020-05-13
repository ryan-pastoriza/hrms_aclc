<?php
/**
 * @Author: gian
 * @Date:   2016-04-01 09:20:36
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-19 09:20:29
 */
	$this->load->view('admin/Department/department_list/jscripts');


  // echo lte_widget(4,array('header'      => 'Department List',
  //                         'col_grid'    => col_grid(12,12,8),
  //                         'bgColor'     => 'box-info',
  //                         'collapsable' => true,
  //                         'body'        => '
  //                                             <div>

  //                                             </div>
  //                                          ',
  //                         'foot'        => false,
  //                        )
  //                )


?>
<div class="col-xs-12 col-md-12">
  <div class="box box-default">
    <div class="box-header">
      <h3 class="box-title">Departments List</h3>
      <div class="pull-right box-tools">
        <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table id="example1" class="table table-bordered table-hover">
        <thead>
          <th>Department Name <small>Click to sort</small></th>
          <th>Action</th>
        </thead>
        <tbody id="deptLV"> 
        </tbody>
      </table>
    </div>
  </div>
</div>