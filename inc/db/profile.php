<?php
$currentRoot = dirname(__FILE__);
require_once $currentRoot.'/dbbase.class.php';

/**
 * Profile data class
 *
 * @note Connection need to be established before methods of this class are used.
 */
class dbProfile extends dbBaseClass
{
	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_tableName = 'profile';

	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_defaultOrderSql = 'ORDER BY dt';

	/**
	 * @see dbBaseClass
	 * @var array
	 */
	protected $pv_aliasNames2colNames = array (
		'id' => 'id',
		'dt' => 'dt',
		'ankieta_id' => 'ankieta_id',
		'grupa' => 'grupa',
		'dt_change' => 'dt_change',
		
		'miejsce' => 'miejsce',
		'plec' => 'plec',
		'wiek' => 'wiek',
		'wyksztalcenie' => 'wyksztalcenie',
	);

	/**
	 * "Szablony" SQL do statystyk/szybkich zapytań.
	 *
	 * @see dbBaseClass->pf_getStats
	 * @var array
	 */
	protected $pv_sqlStatsTpls = array (
		// liczniki grup
		'grupy' =>
			'SELECT grupa as nazwa, count(grupa) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY grupa
			ORDER BY 1, 2',
		// Zbiorcze podsumowanie
		'miejsce' =>
			'SELECT miejsce, count(miejsce) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY miejsce
			ORDER BY 1, 2',
		'wyksztalcenie' =>
			'SELECT wyksztalcenie, count(wyksztalcenie) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY wyksztalcenie
			ORDER BY 1, 2',
		'plec' =>
			'SELECT plec as `płeć`, count(plec) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY plec
			ORDER BY 1, 2',
		'wiek' =>
			'
			(
			SELECT \'18-24\' as wiek, count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (wiek <= 24)
			)
			UNION
			(
			SELECT \'25-39\', count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (wiek >=25 AND wiek <= 39)
			)
			UNION
			(
			SELECT \'40-64\', count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (wiek >=40 AND wiek <= 64)
			)
			UNION
			(
			SELECT \'65+\', count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (wiek >=65)
			)
		'
	);

	/**
	 * Grupy/statusy
	 * @var array
	 */
	public static $pv_grupy = array (
		'w puli', 'grupa główna', 'zastępcza', 'rezerwowa', 'rez.zast.', 'rezygnacja'
	);

	public static function pf_wyksztalcenieTranslate($dbValue) {
		switch ($dbValue)
		{
			 case 'p': return "podstawowe";
			 case 's': return "średnie";
			 case 'w': return "wyższe";
		}
		return $dbValue;
	}
	public static function pf_ageRangeTranslate($from, $to) {
		if (!empty($to)) {
			if (empty($from)) {
				$from = '0';
			}
			return $from . "-" . $to;
		} else if (!empty($from)) {
			return $from . "+";
		}
		return "";
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