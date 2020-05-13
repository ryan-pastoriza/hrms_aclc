<?php
/**
 * @Author: gian
 * @Date:   2016-04-01 15:54:26
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-01 15:54:34
 */
?>
<div class="btn-group">
		<!-- delete button -->
	      <a href='#' class="text-red dropdown-toggle" data-toggle="dropdown">
	        	<span class="glyphicon glyphicon-trash"></span>
	      </a>
	      <ul class="dropdown-menu">
		        <li><span class='label alert-warning'>Are you sure?</span></li>
		        <li><a href="#" class="deleteEmpSched" table="<?= $table ?>" table_id="<?= $id ?> ">Yes</a></li>
		        <li><a href="#" id="no">No</a></li>
	      </ul>
	     
</div>