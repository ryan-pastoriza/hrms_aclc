<?php
/**
 * @Author: Gian
 * @Date:   2015-09-11 14:27:57
 * @Last Modified by:   gian
 * @Last Modified time: 2015-10-14 10:26:11
 */
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Checkinouts extends MY_Model{
		const DB_TABLE = "CHECKINOUT";
		const DB_TABLE_PK = "USERID";
		
		public $USERID;
		public $CHECKTIME;
		public $CHECKTYPE;
		public $VERIFYCODE;
		public $SENSORID;
		public $LOGID;
		public $MachineId;
		public $UserExtFmt;
		public $WordCode;
		public $MemoInfo;
		public $sn;
	}