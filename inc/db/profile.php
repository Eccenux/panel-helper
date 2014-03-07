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
			WHERE {pv_constraints|(1)}
			GROUP BY dzielnica
			ORDER BY 1, 2',
		'wyksztalcenie' =>
			'SELECT wyksztalcenie, count(wyksztalcenie) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY wyksztalcenie
			ORDER BY 2, 1',
		'plec' =>
			'SELECT plec as `płeć`, count(plec) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY plec
			ORDER BY 2, 1',
		'wiek' =>
			'
			(
			SELECT \'16-24\' as wiek, count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (2014 - rok <= 24)
			)
			UNION
			(
			SELECT \'25-39\', count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (2014 - rok >=25 AND 2014 - rok <= 39)
			)
			UNION
			(
			SELECT \'40-64\', count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (2014 - rok >=40 AND 2014 - rok <= 64)
			)
			UNION
			(
			SELECT \'65+\', count(*) as licznik
			FROM profile
			WHERE {pv_constraints|(1)} AND (2014 - rok >=65)
			)
		',
		'dzieci' =>
			'SELECT dzieci, count(dzieci) as licznik
			FROM profile
			WHERE {pv_constraints|(1)}
			GROUP BY dzieci
			ORDER BY 2, 1',
	);

	/**
	 * Grupy/statusy
	 * @var array
	 */
	public static $pv_grupy = array (
		'w puli', 'grupa główna', 'zastępcza', 'rezerwowa', 'rezygnacja', 'robocza'
	);
}