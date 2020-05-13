<?php
/**
 * @Author: khrey
 * @Date:   2015-10-20 08:42:23
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-09 10:12:03
 */

$rules_heading = array('title' => 'Company Rules',
						'sub_title' => '',
						'crumbs' => false);

$this->load->view('admin/widgets/account_settings/user_account');
if ($this->userInfo->user_privilege == "admin") {
	$this->load->view('admin/content_header',$rules_heading);
	$this->load->view('admin/widgets/account_settings/attendance_rules');
}