<?php

use Nette;

/**
* Provádí operace nad databázovou tabulkou.
* @author David Pohan
*/
class Repository extends Nette\Object
{
	protected $connection;

	function __construct(Nette\Database\Connection $connection) 
	{
		$this->connection = $connection;
	}

	/**
     * Vrací objekt reprezentující databázovou tabulku.
     * @return Nette\Database\Table\Selection
     * @author David Pohan
     */
	protected function getTable()
	{
		preg_match('#(\w+)Repository$#', get_class($this), $m);
        return $this->connection->table(lcfirst($m[1]));
	}

	/**
     * Vrací všechny řádky z tabulky.
     * @return Nette\Database\Table\Selection
     * @author David Pohan
     */
	public function findAll()
	{
		return $this->getTable();
	}

	/**
     * Vrací řádky podle filtru, např. array('name' => 'John').
     * @return Nette\Database\Table\Selection
     * @author David Pohan
     */
	public function findBy(array $by)
	{
		return $this->getTable()->where($by);
	}
}