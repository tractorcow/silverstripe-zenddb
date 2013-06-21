<?php

/**
 * Zend database controller class
 * 
 * @package zenddb
 */
class ZendDatabase extends SS_Database {
	
	/**
	 * database server type specified by the 'driver' parameter
	 *
	 * @var type 
	 */
	protected $serverType = null;
	
	public function connect($parameters) {

		// Notify connector of parameters. Connect to DB at the same time (required for 
		// servers that require the database to be specified).
		$this->connector->connect($parameters, true);
		
		// Save server type
		$this->serverType = $parameters['driver'];
	}
	
	public function comparisonClause($field, $value, $exact = false, $negate = false, $caseSensitive = null, $parameterised = false) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function datetimeDifferenceClause($date1, $date2) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function datetimeIntervalClause($date, $interval) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function formattedDatetimeClause($date, $format) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function getDatabaseServer() {
		return $this->serverType;
	}

	public function now() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function random() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function searchEngine($classesToSearch, $keywords, $start, $pageLength, $sortBy = "Relevance DESC", $extraFilter = "", $booleanSearch = false, $alternativeFileFilter = "", $invertedMatch = false) {
		
		user_error('Not implemented', E_USER_ERROR);
	}

	public function supportsCollations() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function supportsTimezoneOverride() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function supportsTransactions() {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function transactionEnd($chain = false) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function transactionRollback($savepoint = false) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function transactionSavepoint($savepoint) {
		user_error('Not implemented', E_USER_ERROR);
		
	}

	public function transactionStart($transactionMode = false, $sessionCharacteristics = false) {
		user_error('Not implemented', E_USER_ERROR);
		
	}	
}
