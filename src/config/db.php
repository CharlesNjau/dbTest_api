<?php

class db{
	//properties
	private $dbhost='localhost';
	private $dbuser='root';
	private $dbpass='';
	private $dbname='slimapp';

	public $Name="functional class variable";

	//connect to databse
	public  function connect(){
		$mysql_connect_str="mysql:host=$this->dbhost;dbname=$this->dbname;"; 
		$dbConnection=new PDO($mysql_connect_str,$this->dbuser,$this->dbpass);
		$dbConnection->setAttribute(PDO::ATTR_MODE,PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}  
}


?>