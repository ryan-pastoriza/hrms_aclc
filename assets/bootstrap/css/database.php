<?php
	
	class database{
		private $server;
		private $user;
		private $pass;
		private $dbname;
		private $connection;
		private $query;
		public function connect($server,$user,$pass,$dbname){
			$this->server = $server;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbname = $dbname;
			$this->connection = mysqli_connect($this->server,$this->user,$this->pass,$this->dbname);
			
			if($this->connection){
				return "Connected";
			}else{
				return "Not COnnected";
			}
		}

		public function save_member($name,$age){
			$sql = "INSERT INTO `members` (`name`,`age`) VALUES ('$name','$age')";
			$this->query = mysqli_query($this->connection,$sql);
			if($this->query){
				return "Save SUccessfully";
			}else{
				return "Not Save";
			}
		} 

	}
?>