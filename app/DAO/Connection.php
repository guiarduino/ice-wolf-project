<?php

namespace app\DAO;

use app\Models\Model;
use ReflectionClass;
use ReflectionProperty;

abstract class Connection
{
	protected $pdo;
	private $table_name;

	public function __construct(string $table)
	{
		$host = getenv('DB_MYSQL_HOST');
		$port = getenv('DB_MYSQL_PORT');
		$user = getenv('DB_MYSQL_USER');
		$pasword = getenv('DB_MYSQL_PASSWORD');
		$dbname = getenv('DB_MYSQL_DBNAME');

		$this->table_name = $table;

		$dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

		$this->pdo = new \PDO($dsn, $user, $pasword);
		$this->pdo->setAttribute(
			\PDO::ATTR_ERRMODE,
			\PDO::ERRMODE_EXCEPTION
		);
		$this->pdo->setAttribute(
			\PDO::ATTR_DEFAULT_FETCH_MODE,
			\PDO::FETCH_ASSOC
		);
		$this->pdo->setAttribute(
			\PDO::ATTR_EMULATE_PREPARES,
			 false); // Desabilita a emulação
	}

	public function setWhere(array $finders): string
	{
		$where_string = "";
		$where = [];

		foreach ($finders as $key => $value) {
			$where[$key] = $value;
		}

		foreach ($where as $key => $value) {

			if($where_string === "")
			{
				$where_string .= " {$key} = {$value}";
			} else {
				$where_string .= " AND {$key} = {$value}";
			}
		}

		return "WHERE " . $where_string;
	}

	public function setInsert(Model $model): array
	{
		$return = [
			'sql_string' => '',
			'sql_array' => []
		];

		$reflection = new ReflectionClass($model);
		$properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

		foreach ($properties as $property) {
			$property->setAccessible(true);  // Torna a propriedade acessível
			$array[$property->getName()] = $property->getValue($model);  // Adiciona o valor ao array
		}

		$formattedArray = array_map(function($item) {
			return ":$item";
		}, array_keys($array));

		$return['sql_string'] = implode(',', $formattedArray);
		$return['sql_array'] = $array ?? [];

		return $return;
	}

	public function setUpdate(Model $model): string
	{
		$return = "";
		$reflection = new ReflectionClass($model);
		$properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

		foreach ($properties as $property) {
			$property->setAccessible(true);  // Torna a propriedade acessível
			$array[$property->getName()] = $property->getValue($model);  // Adiciona o valor ao array
		}

		$formattedArray = array_map(function($index) use ($array) {
			// Testando o tipo antes do switch
			$type = null;

			if ($array[$index] instanceof \DateTime) {
				$type = 'datetime';
			} elseif (is_int($array[$index])) {
				$type = 'integer';
			} elseif (is_string($array[$index])) {
				$type = 'string';
			} else {
				$type = 'other';
			}

			switch ($type) {
				case 'datetime':
					$info = "'{$array[$index]->format('Y-m-d H:i:s')}'";
					break;
				
				case 'string':
					$info = "'{$array[$index]}'";
					break;
				
				case 'integer':
					$info = "{$array[$index]}";
					break;

				default:
					$info = "{$array[$index]}";
					break;
			}
			return "{$index} = {$info}";
		}, array_keys($array));

		array_shift($formattedArray);
		$return = implode(',', $formattedArray);

		return $return;
	}

	public function getAll()
	{
		$statment = $this->pdo->query(
			"SELECT * FROM {$this->table_name}"
		);

		return $statment->fetchAll();
		
	}

	public function getById(int $id)
	{
		$statment = $this->pdo->query(
			"SELECT * FROM {$this->table_name} WHERE id = {$id}"
		);

		return $statment->fetch();
	}

	public function getBySlug(array $finders)
	{
		$where = $this->setWhere($finders);

		$statment = $this->pdo->query(
			"SELECT * FROM {$this->table_name} {$where}"
		);

		return $statment->fetchAll();
	}

	public function create(Model $model)
	{
		try {
			$sql_formated = $this->setInsert($model);

			$this->pdo->beginTransaction();

			$statment = $this->pdo->prepare(
				"INSERT INTO {$this->table_name} VALUES({$sql_formated['sql_string']});"
			);
			$statment->execute($sql_formated['sql_array']);

			$this->pdo->commit();

		} catch(\Exception $ex) {
			throw new \Exception("Erro ao tentar cadastrar novo '{$this->table_name}'", 500);
		}
	}

	public function update(Model $model, int $id)
	{
		try {
			$sql_formated = $this->setUpdate($model);
			
			$this->pdo->beginTransaction();

			$statment = $this->pdo->prepare(
				"UPDATE {$this->table_name} SET {$sql_formated} WHERE id = :id;"
			);

			$statment->bindParam(':id', $id, \PDO::PARAM_INT);

			$statment->execute();
			$this->pdo->commit();

		} catch(\Exception $ex) {
			throw new \Exception("Erro ao editar '{$this->table_name}'", 500);
		}
	}

	public function delete(int $id)
	{
		try 
		{
			$this->pdo->beginTransaction();

			$statment = $this->pdo->prepare(
				"DELETE FROM {$this->table_name} WHERE id = :id"
			);

			$statment->bindParam(':id', $id, \PDO::PARAM_INT);

			$statment->execute();
			$this->pdo->commit();
			
		} catch (\Throwable $ex) {
			throw new \Exception("Erro ao tentar deletar '{$this->table_name}'", 500);
		}

	}

}