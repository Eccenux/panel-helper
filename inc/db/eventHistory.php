<?php
$currentRoot = dirname(__FILE__);
require_once $currentRoot.'/dbbase.class.php';

/**
 * Event history data class
 *
 * @note Connection need to be established before methods of this class are used.
 */
class dbEventHistory extends dbBaseClass
{
	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_tableName = 'event_history';

	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_defaultOrderSql = 'ORDER BY uuid, dt_change DESC';

	/**
	 * @see dbBaseClass
	 * @var array
	 */
	protected $pv_aliasNames2colNames = array (
		'id' => 'id',
		'uuid' => 'uuid',
		'dt_create' => 'dt_create',
		'dt_change' => 'dt_change',
		'history_data' => 'history_data',
	);

	/**
	 * Alised names of columns that are to be excluded when inserting records.
	 *
	 * @note For tables that have automatically incremented ids you should add the name of this id column here.
	 *
	 * @see pf_insRecord()
	 * @var array
	 */
	protected $pv_insertExcludedCols = array('id');

	/**
	 * Extra operations on a record to be run in `pf_insRecord`.
	 *
	 * @param array $pv_record The record.
	 */
	protected function pf_insRecordExtraParse(&$pv_record)
	{
		$now = date('Y-m-d H:i:s');
		$pv_record['dt_create'] = $now;
		$pv_record['dt_change'] = $now;
	}
	/**
	 * Extra operations on a record to be run in `pf_setRecords`.
	 *
	 * @param array $pv_record The record.
	 */
	protected function pf_setRecordExtraParse(&$pv_record)
	{
		$now = date('Y-m-d H:i:s');
		$pv_record['dt_change'] = $now;
	}

}