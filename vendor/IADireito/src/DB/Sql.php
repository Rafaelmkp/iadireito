<?php 

namespace IADireito\DB;

class Sql {

	const HOSTNAME = "127.0.0.1";
	const USERNAME = "postgres";
	const PASSWORD = "admin";
	const DBNAME = "processos";

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"pgsql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, 
			Sql::USERNAME,
			Sql::PASSWORD
		);

	}

	//uso generico
	private function setParams($statement, $parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);

		}

	}

	//uso para procedures com retorno
	private function setParameters($statement, $parameters = array(), $length)
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParameters($statement, $key, $value, $length);

		}

	}

	//uso generico
	private function bindParam($statement, $key, $value)
	{

		$statement->bindParam($key, $value);

	}

	//uso para procedures com retorno
	private function bindParameters($statement, $key, $value, $length)
	{

		$statement->bindParam($key, $value, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, $length);

	}

	public function query($rawQuery, $params = array())
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

	}

	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}

	public function outputProcedure($rawQuery, $params = array())
	{
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParameters($stmt, $params, 12);

		 $stmt->execute();

		return $stmt->fetchAll();
	}

}

 ?>