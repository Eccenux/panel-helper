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
		
		'ulica' => 'ulica',
		'dzielnica' => 'dzielnica',
		'plec' => 'plec',
		'rok' => 'rok',
		'wyksztalcenie' => 'wyksztalcenie',
		'dzieci' => 'dzieci',
	);
}

?>