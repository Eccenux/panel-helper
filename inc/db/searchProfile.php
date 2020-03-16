<?php
$currentRoot = dirname(__FILE__);
require_once $currentRoot.'/dbbase.class.php';

/**
 * Search profiles data class.
 *
 * @note Connection need to be established before methods of this class are used.
 */
class dbSearchProfile extends dbBaseClass
{
	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_tableName = 'search_profile';

	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_defaultOrderSql = 'ORDER BY id';

	/**
	 * @see dbBaseClass
	 * @var array
	 */
	protected $pv_aliasNames2colNames = array (
		'id' => 'id',

		'dt_create' => 'dt_create',
		'dt_change' => 'dt_change',

		'group_name' => 'group_name',
		'invites_no' => 'invites_no',

		'sex' => 'sex',
		'age_min' => 'age_min',
		'age_max' => 'age_max',
		'region' => 'region',
		'education' => 'education',

		'row_state' => 'row_state',
		'csv_row' => 'csv_row',
		'csv_file' => 'csv_file',
	);

	/**
	 * "Szablony" SQL do statystyk/szybkich zapytań.
	 *
	 * @see dbBaseClass->pf_getStats
	 * @var array
	 */
	protected $pv_sqlStatsTpls = array ();

	/**
	 * Grupy/statusy
	 * @var array
	 */
	public static $pv_grupy = array (
		'w puli', 'grupa główna', 'zastępcza', 'rezerwowa', 'rez.zast.', 'rezygnacja'
	);

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