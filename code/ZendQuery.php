<?php

/**
 * Zend DB query result wrapper class
 * 
 * @package zenddb
 */
class ZendQuery extends SS_Query {
	
	/**
	 * Connector origin
	 * 
	 * @var ZendConnector
	 */
	protected $connector = null;
	
	/**
	 * Zend DB Result Set
	 *
	 * @var \Zend\Db\ResultSet\ResultSet 
	 */
	protected $results = null;
	
	/**
	 * Instantiate a new ZendQuery result set
	 * 
	 * @param ZendConnector $connector
	 * @param \Zend\Db\ResultSet\ResultSet $results
	 */
	function __construct(ZendConnector $connector, \Zend\Db\ResultSet\ResultSet $results) {
		$this->connector = $connector;
		$this->results = $results;
	}
	
	public function nextRecord() {
		$this->results->next();
		$current = (array)$this->results->current();
		return $current;
	}

	public function numRecords() {
		return $this->results->count();
	}

	public function seek($rowNum) {
		$this->rowNum = $rowNum - 1;
		$this->results->rewind();
		$result = null;
		for($i = 0; $i <= $rowNum; $i++) {
			$result = $this->next();
		}
		return $result;
	}	
}
