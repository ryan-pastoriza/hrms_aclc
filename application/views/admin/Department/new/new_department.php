<?php
/**
 * @Author: gian
 * @Date:   2016-03-31 17:03:44
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-19 09:21:12
 */
	$this->load->view('admin/Department/new/jscripts');


  // echo lte_widget(4,array('header'  => 'Add New Department <small>Expand to open form</small>',
  //                         'col_grid' => col_grid(12,12,4),
  //                         'bgColor' => 'box-info',
  //                         'collapsable' => true,
  //                         'body'      => '
  //                                         <div class="col-md-12">
  //                                           <div class="row">
                                              
  //                                           </div>
  //                                         </div>


  //                                        ',
  //                         'foot' => '
  //                                   <button type="submit" name="submit" id="addDept" class="btn btn-primary btn-flat">Add<span class="glyphicon glyphicon-plus"></span></button>
  //                                   ',
  //                         'formData' => array(
  //                                               'form_open'   => form_open("admin/departments/add_department",'class="form-horizontal" id="eventForm"'),
  //                                               'ajaxForm'    => array('beforSubmit' => 'function(e){

  //                                                                                       }',
  //                                                                      'complete'    => 'function(data){

  //                                                                                       }',
  //                                                                      'dataType'    => '"JSON"'            
  //                                                                     )
  //                                            ),
  //                         'formID'  => 'addDepartment'
  //                        )
  //                );


?>
<section class="content">
    <div class="col-md-6">
      <div class="box box-info collapsed-box">
        <div class="box-header">
          <h3 class="box-title">Add New Department <small>Expand to open form</small></h3>
          <div class="pull-right box-tools">
            <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="box-body pad">
         <?php 
           echo form_open('admin/departments/add_department',array('id'=>'addDepartment' , 'class' => 'form-horizontal', 'data-toggle' => "validator"))
         ?>
         <div class="form-group">
            <div class="col-md-12">
            <label>New Department Name</label>
            <input type="text" class="form-control" placeholder="New Department Name" name="department_name" required>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-plus"></i>Add</button>
          </div>
          </form>
        </div>
      </div>
      
    </div>
    <div id="allDepartments">
      <?php 
        $this->load->view('admin/Department/department_list/department_listview');
       ?>
    </div>
</section> 