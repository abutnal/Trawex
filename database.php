<?php
class Database
{
	public $con;
	public function __construct(){
		$this->con = mysqli_connect("localhost","root","","trawex");
		if (!$this->con) {
			die('Connection Failed').mysqli_error();
		}
	}
}
$obj = new Database;
?>