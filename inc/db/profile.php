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
	 * @var array
	 */
	protected $pv_aliasNames2colNames = array (
		'id' => 'id',
		'dt' => 'dt',
		'ankieta_id' => 'ankieta_id',
		'grupa' => 'grupa',
		
		'ulica' => 'ulica',
		'dzielnica' => 'dzielnica',
		'plec' => 'plec',
		'rok' => 'rok',
		'wiek' => '2014 - rok',
		'wyksztalcenie' => 'wyksztalcenie',
		'dzieci' => 'dzieci',
	);

	/**
	 * "Szablony" SQL do statystyk/szybkich zapytań.
	 *
	 * @see dbBaseClass->pf_getStats
	 * @var array
	 */
	protected $pv_sqlStatsTpls = array (
		// Zbiorcze podsumowanie
		'dzielnice' =>
			'SELECT dzielnica, count(dzielnica) as licznik
			FROM profile
			GROUP BY dzielnica
			ORDER BY 1, 2',
		'wyksztalcenie' =>
			'SELECT wyksztalcenie, count(wyksztalcenie) as licznik
			FROM profile
			GROUP BY wyksztalcenie
			ORDER BY 2, 1',
	);

	/**
	 * Grupy/statusy
	 * @var array
	 */
	public static $pv_grupy = array (
		'w puli', 'grupa główna', 'zastępcza', 'rezerwowa'
	);
}