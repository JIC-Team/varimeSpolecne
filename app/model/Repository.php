<?php

use Nette;

class Repository extends Nette\Object
{
	protected $connection;

	function __construct(Nette\Database\Connection $connection) 
	{
		$this->connection = $connection;
	}

	protected function getTable()
	{
		preg_match('#(\w+)Repository$#', get_class($this), $m);
        return $this->connection->table(lcfirst($m[1]));
	}

	public function findAll()
	{
		return $this->getTable();
	}

	public function findBy(array $by)
	{
		return $this->getTable()->where($by);
	}
}