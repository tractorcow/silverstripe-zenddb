<?php

use Zend\Db\Sql\Ddl;
use Zend\Db\Metadata;

/**
 * Zend DB schema manager class
 * 
 * @package zenddb
 */
class ZendSchemaManager extends DBSchemaManager {
	
	public function flushCache() {
		$this->metaData = null;
		$this->tableMetaData = null;
	}
	
	protected $metaData = null;
	
	protected $tableMetaData = null;
	
	/**
	 * Retrieves the Zend Metadata object
	 * 
	 * @return \Zend\Db\Metadata\Metadata
	 */
	protected function getMetaData() {
		if($this->metaData) return $this->metaData;
		
		$connector = $this->database->getConnector();
		if(!($connector instanceof ZendConnector)) {
			throw new BadMethodCallException('Cannot call getMetaData on ZendSchemaManager without a valid ZendConnector instance');
		}
		$adapter = $connector->getAdapter();
		$this->metaData = new Metadata\Metadata($adapter);
		return $this->metaData;
	}
	
	/**
	 * Retrieves table data
	 * 
	 * @return \Zend\Db\Metadata\Object\TableObject
	 */
	protected function getTableMetaData($table) {
		if(!empty($this->tableMetaData[$table])) {
			return $this->tableMetaData[$table];
		}
		
		// Get system name of this table
		$tables = $this->tableList();
		$tableCS = $tables[strtolower($table)];
		
		// get metadata object for this table
		$metadata = $this->getMetaData();
		$this->tableMetaData[$table] = $metadata->getTable($tableCS);
		return $this->tableMetaData[$table];
	}
	
	protected function indexKey($table, $index, $spec) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function IdColumn($asDbValue = false, $hasAutoIncPK = true) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function alterIndex($tableName, $indexName, $indexSpec) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function alterTable($table, $newFields = null, $newIndexes = null, $alteredFields = null, $alteredIndexes = null, $alteredOptions = null, $advancedOptions = null) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function checkAndRepairTable($tableName) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function createDatabase($name) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function createField($table, $field, $spec) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function createTable($table, $fields = null, $indexes = null, $options = null, $advancedOptions = null) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function databaseExists($name) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function databaseList() {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function dbDataType($type) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function dropDatabase($name) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function enumValuesForField($tableName, $fieldName) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function fieldList($table) {
		$tableData = $this->getTableMetaData($table);
		$fields = array();
		foreach($tableData->getColumns() as $column) {
			// @todo - proper implementation
			$spec = $column->getDataType() . ($column->getIsNullable() ? ' null' : ' not null');
			$fields[$column->getName()] = $spec;
		}
		return $fields;
	}

	public function hasTable($tableName) {
		$tables = $this->tableList();
		$tableName = strtolower($tableName); 
		return !empty($tables[$tableName]);
	}

	public function indexList($table) {
		$metadata = $this->getMetaData();
		$tableData = $metadata->getTable($table);
		Debug::dump($tableData->getConstraints());
		die;
	}

	public function renameField($tableName, $oldName, $newName) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function renameTable($oldTableName, $newTableName) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function tableList() {
		Debug::dump('tablelist');
		$metadata = $this->getMetaData();
		$tables = array();
		foreach($metadata->getTableNames() as $table) {
			$tables[strtolower($table)] = $table;
		}
		return $tables;
	}	
}
