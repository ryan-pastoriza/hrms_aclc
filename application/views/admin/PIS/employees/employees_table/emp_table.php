<?php 
/**
 * @Author: gian
 * @Date:   2016-03-31 16:51:40
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-14 08:38:22
 */
$tbl = lte_table(['tableHeaders'  => ['Employee','Job Title', 'Department', 'Status', ''],
                'tableRows'     => [],
                'tableId'       => 'emps-tbl',
                'tblVarName'    => 'emps_tbl',
                'tableOptions'  => ['ajax' => base_url('index.php/admin/employees/employees_list')],
                'footerSearchable' => true
                ]);
?>
<div class="row">
<?php
echo lte_widget(5,array('body'      => $tbl,
                        'col_grid'  => col_grid(12,12,12,12),
                        'bgColor'   => 'box-primary',
                        'header' => 'Employees Table'));
?>
</div>