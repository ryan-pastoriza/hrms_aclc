<?php
/**
 * @Author: khrey
 * @Date:   2015-08-14 10:42:07
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-22 12:06:21
 */
?>
<div class="col-md-12">
<section class="content-header">
  <h1>
    <?= $title ?>
    <small><?= $sub_title ?></small>
  </h1>
  <?php if (!isset($crumbs)): ?>
  	<ol class="breadcrumb">
	    <li><?= ucfirst($this->uri->segment(1)) ?></li>
	    <li class="active"><?= ucfirst($this->uri->segment(2)) ?></li>
	</ol>
  <?php endif ?>
</section>
</div>