<?php

use Zend\Db\Adapter;
use Zend\Db\Adapter\Driver;

/**
 * Zend DB Connector wrapper class
 * 
 * @package zenddb
 */
class ZendConnector extends DBConnector {

	/**
	 * Zend database connection
	 *
	 * @var \Zend\Db\Adapter\Adapter
	 */
	protected $adapter;

	/**
	 * Number of affected rows of last query
	 *
	 * @var integer
	 */
	protected $numAffectedRows = null;

	/**
	 * Gets the Zend database adapter
	 * 
	 * @return \Zend\Db\Adapter\Adapter
	 */
	public function getAdapter() {
		return $this->adapter;
	}

	public function affectedRows() {
		return $this->numAffectedRows;
	}

	public function connect($parameters, $selectDB = false) {
		if (empty($parameters['driver'])) {
			$this->databaseError("Zend\Db\Adapter\Adapter requires the 'driver' parameter");
		}

		if (strtolower($parameters['driver']) === 'mysqli') {
			$parameters['options'] = array(
				'buffer_results' => true
			);
		}

		$this->adapter = new Adapter\Adapter($parameters);
	}

	public function getGeneratedID($table) {
		user_error('Not implemented', E_USER_ERROR);
	}

	public function getLastError() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function getSelectedDatabase() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function getVersion() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function isActive() {
		return !empty($this->adapter);
	}

	/**
	 * Substitute identifier escape characters in a SQL with the character expected
	 * by the adapter
	 * 
	 * @todo Implement better search and replace function that considers literal quotes
	 * 
	 * @param string $sql
	 * @return string
	 */
	public function transformSql($sql) {
		$identifier = $this->adapter->platform->getQuoteIdentifierSymbol();
		if ($identifier !== '"') {
			$sql = preg_replace('/"([A-Za-z0-9_-]+)"/', $identifier . '$1' . $identifier, $sql);
		}
		return $sql;
	}

	public function preparedQuery($sql, $parameters, $errorLevel = E_USER_ERROR) {

		// Check if we should only preview this query
		if ($this->previewWrite($sql)) return;

		// Simplify parameters
		$parameterValues = $this->parameterValues($parameters);

		// Inject correct identifier quote value
		$sql = $this->transformSql($sql);

		// Benchmark query
		$adapter = $this->adapter;
		$handle = $this->benchmarkQuery($sql, function($sql) use($adapter, $parameterValues) {
			if (empty($parameterValues)) {
				return $adapter->query($sql, Adapter\Adapter::QUERY_MODE_EXECUTE);
			} else {
				return $adapter->query($sql, $parameterValues);
			}
		});

		// For non-Select queries we will receive a ResultInterface object
		if ($handle instanceof Driver\ResultInterface) {
			$this->numAffectedRows = $handle->getAffectedRows();
			return true;
		}
		
		// Select queries return ResultSet objects
		$this->numAffectedRows = $handle->count();
		return new ZendQuery($this, $handle);
	}

	public function query($sql, $errorLevel = E_USER_ERROR) {
		return $this->preparedQuery($sql, array(), $errorLevel);
	}

	public function selectDatabase($name) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function unloadDatabase() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function escapeString($value) {
		$quoted = $this->quoteString($value);
		// Remove quoted character from value
		$quoteChar = preg_quote($this->adapter->platform->getQuoteIdentifierSymbol());
		return preg_replace("/(^{$quoteChar})|({$quoteChar}$)/", '', $quoted);
	}

	public function quoteString($value) {
		return $this->adapter->platform->quoteValue($value);
	}

	public function escapeIdentifier($value, $separator = '.') {
		return $this->adapter->platform->quoteIdentifierInFragment($value);
	}

}

