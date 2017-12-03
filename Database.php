<?php 
/** Creator:  Harold "Roy" Rita 
* 	Website: www.coloftech.com
*	License: private
*	Purpose: Basic Database connection class using mysqli
*/
class Database
{
	

	private $database = 'cacaoapp';
	private $host = 'localhost';
	private $username = 'root';
	private $password = '';
	private $db;


	public function connect()
	{
		# code...
		$con = mysqli_connect($this->host,$this->username,$this->password,$this->database);

		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }else{
		  	$this->db = $con;
		  	return $this->db;
		  }

	}
	public function query($query='')
	{
		return mysqli_query($this->connect(), $query);

	}
	public function escape($string)
	{
		# code...
		return mysqli_escape_string($this->connect(),$string);


	}
	public function result($result='')
	{
		# code...
		return mysqli_fetch_object($result);
		

	}

	public function result_array($result='')
	{
		# code...
		return mysqli_fetch_array($result,MYSQLI_ASSOC);

	}
	public function insert($table='',$data)
	{
		# code...
		$i = 0;
		foreach ($data as $key => $value) {
			# code...
			if($i <=0){
				$keys = $key;
				$values = "'".$value."'";
			}else{
				$keys .= ",".$key;
				$values .= ", '".$value."'";
			}

			$i++;
		}

		$sql = sprintf("INSERT INTO %s (%s) VALUES (%s)",$table,$keys,$values);

		if($result = $this->query($sql)){
			//echo "Data stored";
			return $result;
		}else{
			return mysqli_error($this->connect());
		}

	}
	public function update($table='',$set='',$where='')
	{
		# code...
		$sql = sprintf("UPDATE %s SET %s WHERE %s",$table,$set,$where);
		//var_dump($sql);
		$result = $this->query($sql);
		if($result = false){
			return mysqli_error($this->connect);

		}else{
			return $result;
		}
	}
/*	public function delete($table='',$key = '',$value = '')
	{
		if($table !== '' && $key !== '' && $value !== ''){

		$sql = sprintf("DELETE FROM %s WHERE %s = '%s'",$table,$key.$value)
		$query = $this->query($sql);
		return $this->result($query);

		}else{
			return false;
		}
	}*/
	public function truncate($table='')
	{
		# code...
		if(is_array($table)){
			foreach ($table as $key) {
				# code...
				$this->query("TRUNCATE $key");
			}
			return true;
		}else{
			return $this->query("TRUNCATE $table");
		}
		
	}
	public function tableExists($table)
	{
		$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
		if($tablesInDb)
		{
		if(mysql_num_rows($tablesInDb)==1)
		{
		return true;
		}
		else
		{
		return false;
		}
		}
	}
	public function db_close()
	{
		# code...
		return mysqli_close($this->db);
	}

		
}
